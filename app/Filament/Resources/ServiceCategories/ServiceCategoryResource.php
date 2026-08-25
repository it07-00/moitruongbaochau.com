<?php

namespace App\Filament\Resources\ServiceCategories;

use App\Filament\Resources\ServiceCategories\Pages\CreateServiceCategory;
use App\Filament\Resources\ServiceCategories\Pages\EditServiceCategory;
use App\Filament\Resources\ServiceCategories\Pages\ListServiceCategories;
use App\Models\ServiceCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceCategoryResource extends Resource
{
    protected static ?string $model = ServiceCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static string|\UnitEnum|null $navigationGroup = 'Dịch vụ & Dự án';

    protected static ?string $navigationLabel = 'Danh mục dịch vụ';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Danh mục dịch vụ';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Danh mục dịch vụ';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên danh mục')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Đường dẫn tĩnh (Slug)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ServiceCategory::class, 'slug', ignoreRecord: true),
                FileUpload::make('image')
                    ->label('Hình ảnh đại diện / Banner Tab')
                    ->image()
                    ->disk('public')
                    ->directory('uploads/service-categories')
                    ->visibility('public')
                    ->imageEditor(),
                FileUpload::make('icon')
                    ->label('Biểu tượng (Icon SVG / PNG)')
                    ->image()
                    ->disk('public')
                    ->directory('uploads/service-categories')
                    ->visibility('public'),
                Textarea::make('description')
                    ->label('Mô tả ngắn')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('Thứ tự sắp xếp')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Kích hoạt')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Hình ảnh')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->image ? (str_starts_with($record->image, 'http') ? $record->image : (str_starts_with($record->image, 'uploads/') ? asset('storage/'.$record->image) : asset('assets/images/'.$record->image))) : null),
                TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                TextColumn::make('services_count')
                    ->label('Số dịch vụ')
                    ->counts('services')
                    ->badge()
                    ->color('info'),
                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Trạng thái')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListServiceCategories::route('/'),
            'create' => CreateServiceCategory::route('/create'),
            'edit' => EditServiceCategory::route('/{record}/edit'),
        ];
    }
}
