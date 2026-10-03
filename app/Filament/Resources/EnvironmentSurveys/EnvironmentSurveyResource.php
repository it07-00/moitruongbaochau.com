<?php

namespace App\Filament\Resources\EnvironmentSurveys;

use App\Filament\Resources\EnvironmentSurveys\Pages\ListEnvironmentSurveys;
use App\Filament\Resources\EnvironmentSurveys\Pages\ViewEnvironmentSurvey;
use App\Filament\Resources\EnvironmentSurveys\Tables\EnvironmentSurveysTable;
use App\Models\EnvironmentSurvey;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class EnvironmentSurveyResource extends Resource
{
    protected static ?string $model = EnvironmentSurvey::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'company_name';

    protected static ?string $slug = 'khao-sat-bvmt';

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Khảo sát công tác BVMT 2026';

    public static function getModelLabel(): string
    {
        return 'Phiếu khảo sát BVMT';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Phiếu khảo sát BVMT';
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
        return EnvironmentSurveysTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEnvironmentSurveys::route('/'),
            'view' => ViewEnvironmentSurvey::route('/{record}'),
        ];
    }
}
