<?php

namespace App\Filament\Resources\GhgDeclarations;

use App\Filament\Resources\GhgDeclarations\Pages\ListGhgDeclarations;
use App\Filament\Resources\GhgDeclarations\Pages\ViewGhgDeclaration;
use App\Filament\Resources\GhgDeclarations\Tables\GhgDeclarationsTable;
use App\Models\GhgDeclaration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class GhgDeclarationResource extends Resource
{
    protected static ?string $model = GhgDeclaration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Phiếu khai báo khí nhà kính';

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function getModelLabel(): string
    {
        return 'Phiếu khai báo khí nhà kính';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Phiếu khai báo khí nhà kính';
    }

    public static function canViewAny(): bool
    {
        return (bool) auth()->user()?->is_admin;
    }

    public static function canView(Model $record): bool
    {
        return self::canViewAny();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return GhgDeclarationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGhgDeclarations::route('/'),
            'view' => ViewGhgDeclaration::route('/{record}'),
        ];
    }
}
