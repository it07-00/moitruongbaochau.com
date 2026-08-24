<?php

namespace App\Filament\Resources\Posts;

use App\ContentStatus;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
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
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        Textarea::make('excerpt')
                            ->label('Tóm tắt ngắn (Excerpt)')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Nội dung chi tiết')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Ảnh đại diện & Hiển thị')
                    ->components([
                        FileUpload::make('thumbnail')
                            ->label('Ảnh đại diện bài viết')
                            ->image()
                            ->directory('uploads/posts')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9'),
                        Toggle::make('is_featured')
                            ->label('Đánh dấu là bài viết nổi bật')
                            ->default(false),
                        DateTimePicker::make('published_at')
                            ->label('Ngày xuất bản')
                            ->default(now()),
                    ])->columns(2),

                Section::make('Cấu hình SEO Meta')
                    ->collapsed()
                    ->components([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255),
                        TextInput::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(255),
                        TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->url(),
                        TextInput::make('robots')
                            ->label('Robots Tag')
                            ->default('index,follow'),
                        TextInput::make('og_title')
                            ->label('OG Title'),
                        TextInput::make('og_description')
                            ->label('OG Description'),
                        FileUpload::make('og_image')
                            ->label('OG Image')
                            ->image()
                            ->directory('uploads/seo'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Ảnh')
                    ->circular(),
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
