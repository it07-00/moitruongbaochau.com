<?php

namespace App\Filament\Resources\GhgConsultations;

use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\GhgConsultations\Pages\EditGhgConsultation;
use App\Filament\Resources\GhgConsultations\Pages\ListGhgConsultations;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class GhgConsultationResource extends ContactResource
{
    protected static ?string $slug = 'ghg-consultations';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhone;

    protected static ?string $navigationLabel = 'Tư vấn kiểm kê khí nhà kính';

    protected static ?int $navigationSort = 2;

    protected static bool $isGhgConsultation = true;

    public static function getModelLabel(): string
    {
        return 'Yêu cầu tư vấn khí nhà kính';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tư vấn kiểm kê khí nhà kính';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGhgConsultations::route('/'),
            'edit' => EditGhgConsultation::route('/{record}/edit'),
        ];
    }
}
