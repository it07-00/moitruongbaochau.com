<?php

namespace App\Filament\Resources\EnvironmentSurveys\Pages;

use App\Filament\Resources\EnvironmentSurveys\EnvironmentSurveyResource;
use App\Services\EnvironmentSurveyService;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;

class ViewEnvironmentSurvey extends ViewRecord
{
    protected static string $resource = EnvironmentSurveyResource::class;

    protected string $view = 'filament.resources.environment-surveys.view';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('openSurvey')->label('Mở link doanh nghiệp')->url(fn (): string => route('bvmt.show', ['survey' => $this->record->token]))->openUrlInNewTab(),
            Action::make('exportExcel')->label('Xuất Excel')->url(fn (): string => route('bvmt.admin.export', ['survey' => $this->record])),
            Action::make('downloadFiles')->label('Tải hồ sơ ZIP')->url(fn (): string => route('bvmt.admin.archive', ['survey' => $this->record]))->visible(fn (): bool => $this->record->files()->exists()),
            Action::make('requestRevision')->label('Mở lại / yêu cầu bổ sung')->color('warning')
                ->visible(fn (): bool => in_array($this->record->status, ['submitted', 'completed'], true))
                ->schema([Textarea::make('note')->label('Nội dung cần bổ sung')->required()->maxLength(2000)])
                ->action(fn (array $data) => app(EnvironmentSurveyService::class)->changeStatus($this->record, 'revision_required', $data['note'])),
            Action::make('complete')->label('Hoàn tất hồ sơ')->color('success')->requiresConfirmation()
                ->visible(fn (): bool => $this->record->status === 'submitted')
                ->action(fn () => app(EnvironmentSurveyService::class)->changeStatus($this->record, 'completed')),
        ];
    }
}
