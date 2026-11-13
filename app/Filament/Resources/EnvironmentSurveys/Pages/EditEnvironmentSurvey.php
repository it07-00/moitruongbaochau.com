<?php

namespace App\Filament\Resources\EnvironmentSurveys\Pages;

use App\Filament\Resources\EnvironmentSurveys\EnvironmentSurveyResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEnvironmentSurvey extends EditRecord
{
    protected static string $resource = EnvironmentSurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('openSurvey')
                ->label('Mở giao diện 7 bước')
                ->color('gray')
                ->url(fn (): string => route('bvmt.admin.resume', ['survey' => $this->record]))
                ->openUrlInNewTab(),
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
        $data['data']['company_name'] ??= $data['company_name'] ?? null;
        $data['data']['contact_email'] ??= $data['contact_email'] ?? null;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $surveyData = is_array($data['data'] ?? null) ? $data['data'] : [];

        $originalCompanyName = $this->record->company_name;
        $formCompanyName = $data['company_name'] ?? null;
        $nestedCompanyName = $surveyData['company_name'] ?? null;

        if ($formCompanyName !== $originalCompanyName && filled($formCompanyName)) {
            $surveyData['company_name'] = $formCompanyName;
        } elseif (filled($nestedCompanyName)) {
            $data['company_name'] = $nestedCompanyName;
        }

        $originalEmail = $this->record->contact_email;
        $formEmail = $data['contact_email'] ?? null;
        $nestedEmail = $surveyData['contact_email'] ?? null;

        if ($formEmail !== $originalEmail && filled($formEmail)) {
            $surveyData['contact_email'] = $formEmail;
        } elseif (filled($nestedEmail)) {
            $data['contact_email'] = $nestedEmail;
        }

        $data['data'] = array_replace_recursive($this->record->data ?? [], $surveyData);
        foreach (['products', 'fuels', 'approved_wastewater_flows', 'actual_wastewater_flows', 'domestic_wastes', 'industrial_wastes', 'hazardous_wastes'] as $tableKey) {
            if (array_key_exists($tableKey, $surveyData)) {
                $data['data'][$tableKey] = array_values((array) $surveyData[$tableKey]);
            }
        }

        $data['history'] = [
            ...($this->record->history ?? []),
            [
                'action' => 'save',
                'status' => $data['status'] ?? $this->record->status,
                'note' => 'Quản trị viên chỉnh sửa phiếu trong Admin',
                'actor' => auth()->id(),
                'at' => now()->toIso8601String(),
            ],
        ];

        return $data;
    }
}

