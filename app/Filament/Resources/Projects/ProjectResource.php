<?php

namespace App\Filament\Resources\Projects;

use App\ContentStatus;
use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
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

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Dịch vụ & Dự án';

    protected static ?string $navigationLabel = 'Dự án thực hiện';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return 'Dự án';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Dự án';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin dự án')
                    ->components([
                        TextInput::make('title')
                            ->label('Tên dự án')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Đường dẫn tĩnh (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(Project::class, 'slug', ignoreRecord: true),
                        TextInput::make('client')
                            ->label('Chủ đầu tư / Khách hàng')
                            ->maxLength(255),
                        TextInput::make('location')
                            ->label('Địa điểm thực hiện')
                            ->maxLength(255),
                        TextInput::make('category')
                            ->label('Loại hình dự án')
                            ->placeholder('Ví dụ: Giấy phép môi trường, Xử lý nước, Quan trắc...'),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        Textarea::make('summary')
                            ->label('Tóm tắt dự án')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Nội dung chi tiết dự án')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Hình ảnh & Thời gian')
                    ->components([
                        FileUpload::make('thumbnail')
                            ->label('Ảnh dự án')
                            ->image()
                            ->directory('uploads/projects')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9'),
                        DatePicker::make('completed_at')
                            ->label('Ngày hoàn thành'),
                        Toggle::make('is_featured')
                            ->label('Dự án tiêu biểu (Trang chủ)')
                            ->default(false),
                        DateTimePicker::make('published_at')
                            ->label('Ngày đăng')
                            ->default(now()),
                    ])->columns(2),

                Section::make('Cấu hình SEO')
                    ->collapsed()
                    ->components([
                        TextInput::make('meta_title')
                            ->label('Meta Title'),
                        TextInput::make('meta_description')
                            ->label('Meta Description'),
                        TextInput::make('canonical_url')
                            ->label('Canonical URL'),
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
                    ->label('Tên dự án')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),
                TextColumn::make('client')
                    ->label('Khách hàng')
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Địa điểm')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                IconColumn::make('is_featured')
                    ->label('Tiêu biểu')
                    ->boolean(),
                TextColumn::make('completed_at')
                    ->label('Hoàn thành')
                    ->date('d/m/Y')
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
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
