<?php

namespace App\Filament\Resources\GhgDeclarations\Tables;

use App\Models\GhgDeclaration;
use App\Services\GhgDeclarationExcelExport;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GhgDeclarationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label('Mã phiếu')->searchable()->copyable(),
                TextColumn::make('company_name')->label('Doanh nghiệp')->searchable()->sortable(),
                TextColumn::make('contact_email')->label('Email liên hệ')->searchable(),
                TextColumn::make('status')->label('Trạng thái')->badge()->formatStateUsing(fn (string $state): string => $state === 'submitted' ? 'Đã nộp' : 'Bản nháp')->color(fn (string $state): string => $state === 'submitted' ? 'success' : 'gray'),
                TextColumn::make('current_step')->label('Bước đang nhập'),
                TextColumn::make('submitted_at')->label('Ngày nộp')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('updated_at')->label('Cập nhật')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Trạng thái')->options(['draft' => 'Bản nháp', 'submitted' => 'Đã nộp']),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('exportExcel')->label('Xuất Excel')->icon('heroicon-o-arrow-down-tray')
                    ->action(fn (GhgDeclaration $record) => app(GhgDeclarationExcelExport::class)->downloadDeclaration($record)),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}
