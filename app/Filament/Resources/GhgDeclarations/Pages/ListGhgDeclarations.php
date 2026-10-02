<?php

namespace App\Filament\Resources\GhgDeclarations\Pages;

use App\Filament\Resources\GhgDeclarations\GhgDeclarationResource;
use App\Services\GhgDeclarationExcelExport;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListGhgDeclarations extends ListRecords
{
    protected static string $resource = GhgDeclarationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportExcel')->label('Xuất danh sách Excel')->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => app(GhgDeclarationExcelExport::class)->downloadList($this->getFilteredSortedTableQuery()->lazy(500))),
        ];
    }
}
