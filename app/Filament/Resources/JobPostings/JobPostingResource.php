<?php

namespace App\Filament\Resources\JobPostings;

use App\ContentStatus;
use App\Filament\Forms\Components\SeoSection;
use App\Filament\Resources\JobPostings\Pages\CreateJobPosting;
use App\Filament\Resources\JobPostings\Pages\EditJobPosting;
use App\Filament\Resources\JobPostings\Pages\ListJobPostings;
use App\Models\JobPosting;
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
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class JobPostingResource extends Resource
{
    protected static ?string $model = JobPosting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Nội dung khác';

    protected static ?string $navigationLabel = 'Tuyển dụng';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Vị trí tuyển dụng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tuyển dụng';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin vị trí tuyển dụng')
                    ->components([
                        TextInput::make('title')
                            ->label('Vị trí tuyển dụng')
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
                            ->unique(JobPosting::class, 'slug', ignoreRecord: true),
                        TextInput::make('location')
                            ->label('Địa điểm làm việc')
                            ->default('TP. Hồ Chí Minh')
                            ->maxLength(255),
                        TextInput::make('employment_type')
                            ->label('Hình thức làm việc')
                            ->default('Toàn thời gian')
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        DateTimePicker::make('expires_at')
                            ->label('Hạn nộp hồ sơ'),
                        Textarea::make('summary')
                            ->label('Mô tả ngắn vị trí')
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
                            ->label('Mô tả công việc (JD)')
                            ->formatStateUsing(fn (?string $state): ?string => RichContentNormalizer::normalize($state))
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('uploads/job-postings/content')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->fileAttachmentsMaxSize(10240),
                        RichEditor::make('requirements')
                            ->label('Yêu cầu ứng viên')
                            ->formatStateUsing(fn (?string $state): ?string => RichContentNormalizer::normalize($state))
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('uploads/job-postings/content')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->fileAttachmentsMaxSize(10240),
                        RichEditor::make('benefits')
                            ->label('Quyền lợi được hưởng')
                            ->formatStateUsing(fn (?string $state): ?string => RichContentNormalizer::normalize($state))
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('uploads/job-postings/content')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->fileAttachmentsMaxSize(10240),
                    ])->columns(2),

                Section::make('Hình ảnh & hiển thị')
                    ->components([
                        FileUpload::make('thumbnail')
                            ->label('Ảnh đại diện vị trí tuyển dụng')
                            ->image()
                            ->disk('public')
                            ->directory('uploads/job-postings')
                            ->imageAspectRatio('16:9')
                            ->maxSize(10240),
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
                    ->defaultImageUrl(fn ($record) => $record->thumbnail ? (str_starts_with($record->thumbnail, 'http') ? $record->thumbnail : (str_starts_with($record->thumbnail, 'uploads/') ? asset('storage/'.$record->thumbnail) : asset('assets/images/'.$record->thumbnail))) : asset('assets/images/Bai-Dang-Bao-Chau-1024x572.png')),
                TextColumn::make('title')
                    ->label('Vị trí tuyển dụng')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('location')
                    ->label('Địa điểm')
                    ->searchable(),
                TextColumn::make('employment_type')
                    ->label('Hình thức')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('expires_at')
                    ->label('Hạn nộp')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options(ContentStatus::class),
            ])
            ->defaultSort('id', 'desc')
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
            'index' => ListJobPostings::route('/'),
            'create' => CreateJobPosting::route('/create'),
            'edit' => EditJobPosting::route('/{record}/edit'),
        ];
    }
}
