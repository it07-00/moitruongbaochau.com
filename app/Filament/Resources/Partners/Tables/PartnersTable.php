<?php

namespace App\Filament\Resources\Partners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->defaultImageUrl(fn ($record) => $record->logo ? (str_starts_with($record->logo, 'http') ? $record->logo : (str_starts_with($record->logo, 'uploads/') ? asset('storage/'.$record->logo) : asset('assets/images/'.$record->logo))) : null)
                    ->width(100)
                    ->height(50),
                TextColumn::make('name')
                    ->label('Tên đơn vị')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->label('Phân loại')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'press' => 'Báo chí & Truyền thông',
                        default => 'Khách hàng & Đối tác',
                    })
                    ->color(fn ($state) => match ($state) {
                        'press' => 'info',
                        default => 'success',
                    }),
                TextColumn::make('link')
                    ->label('Liên kết')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('Không có'),
                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Phân loại')
                    ->options([
                        'partner' => 'Khách hàng & Đối tác',
                        'press' => 'Báo chí & Truyền thông',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
