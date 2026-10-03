<?php

namespace App\Filament\Resources\EnvironmentSurveys\Tables;

use App\Models\EnvironmentSurvey;
use App\Support\EnvironmentSurveyDefinition;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EnvironmentSurveysTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label('Mã phiếu')->searchable()->copyable(),
                TextColumn::make('company_name')->label('Doanh nghiệp')->searchable()->sortable(),
                TextColumn::make('contact_email')->label('Email liên hệ')->searchable(),
                TextColumn::make('status')->label('Trạng thái')->badge()->formatStateUsing(fn (string $state): string => EnvironmentSurveyDefinition::statuses()[$state])->color(fn (string $state): string => match ($state) {
                    'submitted' => 'info', 'completed' => 'success', 'revision_required' => 'warning', default => 'gray'
                }),
                TextColumn::make('current_step')->label('Bước đang nhập'),
                TextColumn::make('files_count')->counts('files')->label('Số tệp'),
                TextColumn::make('submitted_at')->label('Ngày gửi')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('updated_at')->label('Cập nhật')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Trạng thái')->options(EnvironmentSurveyDefinition::statuses()),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('exportExcel')->label('Excel')->url(fn (EnvironmentSurvey $record): string => route('bvmt.admin.export', ['survey' => $record])),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}
