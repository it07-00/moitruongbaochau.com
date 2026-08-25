<?php

namespace App\Filament\Resources\Services;

use App\ContentStatus;
use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
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

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Dịch vụ & Dự án';

    protected static ?string $navigationLabel = 'Dịch vụ môi trường';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Dịch vụ';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Dịch vụ môi trường';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin dịch vụ')
                    ->description('Nhập thông tin chi tiết dịch vụ môi trường')
                    ->components([
                        TextInput::make('name')
                            ->label('Tên dịch vụ')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Đường dẫn tĩnh (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(Service::class, 'slug', ignoreRecord: true),
                        Select::make('service_category_id')
                            ->label('Danh mục dịch vụ')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        Textarea::make('short_description')
                            ->label('Mô tả ngắn gọn')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Nội dung chi tiết dịch vụ')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Hình ảnh & Hiển thị')
                    ->components([
                        FileUpload::make('thumbnail')
                            ->label('Ảnh đại diện')
                            ->image()
                            ->directory('uploads/services')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9'),
                        TextInput::make('icon')
                            ->label('Tên Icon (nếu có)'),
                        Toggle::make('is_featured')
                            ->label('Dịch vụ nổi bật (Trang chủ)')
                            ->default(false),
                        TextInput::make('sort_order')
                            ->label('Thứ tự hiển thị')
                            ->numeric()
                            ->default(0),
                        DateTimePicker::make('published_at')
                            ->label('Thời gian xuất bản')
                            ->default(now()),
                    ])->columns(2),

                Section::make('Tối ưu hóa SEO')
                    ->description('Cấu hình thẻ Meta Title, Description và OpenGraph phục vụ Google Search')
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
                            ->label('OG Title (Facebook/Zalo)'),
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
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->thumbnail ? (str_starts_with($record->thumbnail, 'http') ? $record->thumbnail : (str_starts_with($record->thumbnail, 'uploads/') ? asset('storage/'.$record->thumbnail) : asset('assets/images/'.$record->thumbnail))) : null),
                TextColumn::make('name')
                    ->label('Tên dịch vụ')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                IconColumn::make('is_featured')
                    ->label('Nổi bật')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Ngày xuất bản')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('service_category_id')
                    ->label('Lọc theo danh mục')
                    ->relationship('category', 'name'),
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options(ContentStatus::class),
            ])
            ->defaultSort('sort_order')
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
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
