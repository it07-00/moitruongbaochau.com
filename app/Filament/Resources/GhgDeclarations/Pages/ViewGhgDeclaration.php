<?php

namespace App\Filament\Resources\GhgDeclarations\Pages;

use App\Filament\Resources\GhgDeclarations\GhgDeclarationResource;
use App\Services\GhgDeclarationExcelExport;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGhgDeclaration extends ViewRecord
{
    protected static string $resource = GhgDeclarationResource::class;

    protected string $view = 'filament.resources.ghg-declarations.view';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('exportExcel')->label('Xuất Excel')->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => app(GhgDeclarationExcelExport::class)->downloadDeclaration($this->record)),
            DeleteAction::make(),
        ];
    }
}
