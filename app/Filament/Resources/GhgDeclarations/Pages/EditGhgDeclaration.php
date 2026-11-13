<?php

namespace App\Filament\Resources\GhgDeclarations\Pages;

use App\Filament\Resources\GhgDeclarations\GhgDeclarationResource;
use App\Services\GhgDeclarationExcelExport;
use App\Support\GhgSurveyDefinition;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGhgDeclaration extends EditRecord
{
    protected static string $resource = GhgDeclarationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('exportExcel')
                ->label('Xuất Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => app(GhgDeclarationExcelExport::class)->downloadDeclaration($this->record)),
            DeleteAction::make(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['data'] = is_array($data['data'] ?? null) ? $data['data'] : [];
        $data['data'][1] = is_array($data['data'][1] ?? null) ? $data['data'][1] : [];
        $data['data'][1]['company_name'] ??= $data['company_name'] ?? null;
        $data['data'][1]['contact_email'] ??= $data['contact_email'] ?? null;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $declarationData = is_array($data['data'] ?? null) ? $data['data'] : [];
        $declarationData[1] = is_array($declarationData[1] ?? null) ? $declarationData[1] : [];

        $originalCompanyName = $this->record->company_name;
        $formCompanyName = $data['company_name'] ?? null;
        $nestedCompanyName = $declarationData[1]['company_name'] ?? null;

        if ($formCompanyName !== $originalCompanyName && filled($formCompanyName)) {
            $declarationData[1]['company_name'] = $formCompanyName;
        } elseif (filled($nestedCompanyName)) {
            $data['company_name'] = $nestedCompanyName;
        }

        $originalEmail = $this->record->contact_email;
        $formEmail = $data['contact_email'] ?? null;
        $nestedEmail = $declarationData[1]['contact_email'] ?? null;

        if ($formEmail !== $originalEmail && filled($formEmail)) {
            $declarationData[1]['contact_email'] = $formEmail;
        } elseif (filled($nestedEmail)) {
            $data['contact_email'] = $nestedEmail;
        }

        $merged = array_replace_recursive($this->record->data ?? [], $declarationData);

        foreach (range(2, 6) as $step) {
            foreach (array_keys(GhgSurveyDefinition::sections($step)) as $sectionKey) {
                if (isset($declarationData[$step]) && array_key_exists($sectionKey, (array) $declarationData[$step])) {
                    $merged[$step][$sectionKey] = array_values((array) $declarationData[$step][$sectionKey]);
                }
            }
        }

        $data['data'] = $merged;

        return $data;
    }
}

