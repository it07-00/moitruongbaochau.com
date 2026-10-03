<?php

namespace App\Filament\Resources\EnvironmentSurveys\Pages;

use App\Filament\Resources\EnvironmentSurveys\EnvironmentSurveyResource;
use App\Models\EnvironmentSurvey;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListEnvironmentSurveys extends ListRecords
{
    protected static string $resource = EnvironmentSurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createSurvey')->label('Tạo link khảo sát')->icon('heroicon-o-plus')
                ->schema([
                    TextInput::make('company_name')->label('Tên doanh nghiệp')->required()->maxLength(255),
                    TextInput::make('contact_email')->label('Email liên hệ')->email()->maxLength(255),
                ])
                ->action(function (array $data): void {
                    abort_unless(auth()->user()?->is_admin, 403);
                    $record = EnvironmentSurvey::query()->create([
                        'company_name' => $data['company_name'], 'contact_email' => $data['contact_email'] ?? null,
                        'data' => $data, 'history' => [['action' => 'created', 'at' => now()->toIso8601String(), 'actor' => auth()->id()]],
                    ]);
                    $this->redirect(EnvironmentSurveyResource::getUrl('view', ['record' => $record]));
                }),
        ];
    }
}
