<?php

namespace App\Filament\Resources\GhgDeclarations\Pages;

use App\Filament\Resources\GhgDeclarations\GhgDeclarationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewGhgDeclaration extends ViewRecord
{
    protected static string $resource = GhgDeclarationResource::class;

    protected string $view = 'filament.resources.ghg-declarations.view';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
