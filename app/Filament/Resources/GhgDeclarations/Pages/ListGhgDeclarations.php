<?php

namespace App\Filament\Resources\GhgDeclarations\Pages;

use App\Filament\Resources\GhgDeclarations\GhgDeclarationResource;
use Filament\Resources\Pages\ListRecords;

class ListGhgDeclarations extends ListRecords
{
    protected static string $resource = GhgDeclarationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
