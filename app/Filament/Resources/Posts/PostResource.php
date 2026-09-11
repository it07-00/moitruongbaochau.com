<?php

namespace App\Filament\Resources\Posts;

use App\ContentStatus;
use App\Filament\Forms\Components\SeoSection;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use App\Support\RichContentNormalizer;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Tin tức & Bài viết';

    protected static ?string $navigationLabel = 'Tất cả bài viết';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Bài viết';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Bài viết';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin bài viết')
                    ->components([
                        TextInput::make('title')
                            ->label('Tiêu đề bài viết')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, callable $set, callable $get) {
                                if ($operation === 'create' || blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                                if (blank($get('meta_title'))) {
                                    $set('meta_title', $state);
                                }
                                if (blank($get('og_title'))) {
                                    $set('og_title', $state);
                                }
                            }),
                        TextInput::make('slug')
                            ->label('Đường dẫn tĩnh (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(Post::class, 'slug', ignoreRecord: true),
                        Select::make('post_category_id')
                            ->label('Danh mục bài viết')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('author_id')
                            ->label('Tác giả')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        Textarea::make('excerpt')
                            ->label('Tóm tắt ngắn (Excerpt)')
                            ->rows(3)
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set, callable $get) {
                                if (filled($state)) {
                                    $clean = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($state))), 160, '');
                                    if (blank($get('meta_description'))) {
                                        $set('meta_description', $clean);
                                    }
                                    if (blank($get('og_description'))) {
                                        $set('og_description', $clean);
                                    }
                                }
                            }),
                        RichEditor::make('content')
                            ->label('Nội dung chi tiết')
                            ->formatStateUsing(fn (?string $state): ?string => RichContentNormalizer::normalize($state))
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('uploads/posts/content')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->fileAttachmentsMaxSize(10240),
                    ])->columns(2),

                Section::make('Ảnh đại diện & Hiển thị')
                    ->components([
                        FileUpload::make('thumbnail')
                            ->label('Ảnh đại diện bài viết')
                            ->image()
                            ->disk('public')
                            ->directory('uploads/posts')
                            ->imageAspectRatio('16:9')
                            ->maxSize(10240),
                        Toggle::make('is_featured')
                            ->label('Đánh dấu là bài viết nổi bật')
                            ->default(false),
                        DateTimePicker::make('published_at')
                            ->label('Ngày xuất bản')
                            ->default(now()),
                        TagsInput::make('tags')
                            ->label('Thẻ nội dung')
                            ->helperText('Nhập tag không kèm ký tự #.')
                            ->columnSpanFull(),
                        TextInput::make('view_count')
                            ->label('Lượt xem')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('rating_average')
                            ->label('Điểm đánh giá')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(0.1),
                        TextInput::make('rating_count')
                            ->label('Số lượt đánh giá')
                            ->numeric()
                            ->minValue(0)
                            ->step(1)
                            ->default(0),
                    ])->columns(2),

                Section::make('Tài liệu PDF đính kèm')
                    ->description('Tải lên file văn bản pháp luật, nghị định, thông tư hoặc báo cáo kỹ thuật (định dạng PDF). Hệ thống sẽ tự động hiển thị khung đọc trực tiếp và nút tải về trên website.')
                    ->components([
                        FileUpload::make('pdf_file')
                            ->label('Tập tin PDF')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('uploads/posts/documents')
                            ->maxSize(51200)
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                    ]),

                SeoSection::make(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Ảnh')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->thumbnail ? (str_starts_with($record->thumbnail, 'http') ? $record->thumbnail : (str_starts_with($record->thumbnail, 'uploads/') ? asset('storage/'.$record->thumbnail) : asset('assets/images/'.$record->thumbnail))) : null),
                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),
                TextColumn::make('category.name')
                    ->label('Chuyên mục')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                IconColumn::make('pdf_file')
                    ->label('PDF')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedDocumentArrowDown)
                    ->falseIcon(null)
                    ->color('danger')
                    ->alignCenter(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                IconColumn::make('is_featured')
                    ->label('Nổi bật')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('post_category_id')
                    ->label('Lọc theo chuyên mục')
                    ->relationship('category', 'name'),
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options(ContentStatus::class),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
