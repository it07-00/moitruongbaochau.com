<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Ảnh / Logo')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->avatar ? (str_starts_with($record->avatar, 'http') ? $record->avatar : (str_starts_with($record->avatar, 'uploads/') ? asset('storage/'.$record->avatar) : asset('assets/images/'.$record->avatar))) : null),
                TextColumn::make('client_name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('client_company')
                    ->label('Công ty / Đơn vị')
                    ->searchable()
                    ->placeholder('Cá nhân'),
                TextColumn::make('rating')
                    ->label('Đánh giá')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Nội dung nhận xét')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->content),
                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
