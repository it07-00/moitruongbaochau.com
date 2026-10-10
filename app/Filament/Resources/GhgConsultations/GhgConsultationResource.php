<?php

namespace App\Filament\Resources\GhgConsultations;

use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\GhgConsultations\Pages\EditGhgConsultation;
use App\Filament\Resources\GhgConsultations\Pages\ListGhgConsultations;
use App\Models\Contact;
use App\Services\GhgGoogleSheetSync;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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

    public static function table(Table $table): Table
    {
        $table = parent::table($table);

        return $table->pushColumns([
            TextColumn::make('sheets_synced_at')->label('Google Sheets')->badge()
                ->getStateUsing(function (Contact $record): string {
                    if ($record->sheets_synced_at !== null) {
                        return 'Đã đồng bộ';
                    }
                    if (! $record->sheets_sync_key) {
                        return 'Dữ liệu cũ';
                    }
                    if (! app(GhgGoogleSheetSync::class)->isConfigured()) {
                        return 'Chờ kết nối';
                    }

                    return $record->sheets_sync_error ? 'Chờ gửi lại' : 'Chờ đồng bộ';
                })
                ->color(fn (Contact $record): string => $record->sheets_synced_at !== null ? 'success' : 'warning'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGhgConsultations::route('/'),
            'edit' => EditGhgConsultation::route('/{record}/edit'),
        ];
    }
}
