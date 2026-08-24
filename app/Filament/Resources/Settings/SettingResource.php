<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\Pages\CreateSetting;
use App\Filament\Resources\Settings\Pages\EditSetting;
use App\Filament\Resources\Settings\Pages\ListSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Cấu hình & Hệ thống';

    protected static ?string $navigationLabel = 'Cài đặt Website & SEO';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Cài đặt';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cài đặt Website';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin cài đặt')
                    ->components([
                        TextInput::make('key')
                            ->label('Khóa cấu hình (Setting Key)')
                            ->required()
                            ->maxLength(255)
                            ->unique(Setting::class, 'key', ignoreRecord: true),
                        Select::make('group')
                            ->label('Nhóm cài đặt')
                            ->options([
                                'general' => 'Thông tin chung (General)',
                                'seo' => 'Cấu hình SEO & Mạng xã hội',
                                'contact' => 'Thông tin liên hệ & Hotline',
                            ])
                            ->default('general')
                            ->required(),
                        Textarea::make('value')
                            ->label('Giá trị (Value)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Khóa cấu hình')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('value')
                    ->label('Giá trị')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('group')
                    ->label('Nhóm')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Lọc theo nhóm')
                    ->options([
                        'general' => 'Thông tin chung',
                        'seo' => 'Cấu hình SEO',
                        'contact' => 'Thông tin liên hệ',
                    ]),
            ])
            ->defaultSort('group', 'asc')
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
            'index' => ListSettings::route('/'),
            'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }
}
