<?php

namespace App\Filament\Resources\CtaClicks;

use App\CtaType;
use App\Filament\Resources\CtaClicks\Pages\ListCtaClicks;
use App\Models\CtaClick;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class CtaClickResource extends Resource
{
    protected static ?string $model = CtaClick::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCursorArrowRays;

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Thống kê nút CTA';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return 'Lượt tương tác CTA';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Thống kê tương tác CTA';
    }

    public static function getNavigationBadge(): ?string
    {
        $todayCount = static::getEloquentQuery()->whereDate('created_at', today())->count();

        return $todayCount > 0 ? (string) $todayCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Kênh / Loại CTA')
                    ->badge()
                    ->sortable(),
                TextColumn::make('label')
                    ->label('Nút / Nội dung')
                    ->searchable()
                    ->weight('bold')
                    ->limit(50),
                TextColumn::make('position')
                    ->label('Vị trí')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'header' => 'Đầu trang (Header)',
                        'floating' => 'Nút nổi (Floating)',
                        'cta_section' => 'Khối kêu gọi (CTA)',
                        'footer' => 'Chân trang (Footer)',
                        'modal' => 'Cửa sổ (Modal)',
                        'sidebar' => 'Cột bên (Sidebar)',
                        'contact_form', 'inline-consultation', 'inline-callback', 'modal-consultation', 'modal-callback' => 'Biểu mẫu tư vấn',
                        'job_application_form' => 'Biểu mẫu tuyển dụng',
                        default => 'Nội dung trang',
                    }),
                TextColumn::make('page_url')
                    ->label('Trang nguồn')
                    ->searchable()
                    ->limit(45),
                TextColumn::make('target_url')
                    ->label('Đích đến')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Thời gian')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Lọc theo kênh CTA')
                    ->options(CtaType::class),
                SelectFilter::make('position')
                    ->label('Lọc theo vị trí')
                    ->options([
                        'header' => 'Đầu trang (Header)',
                        'floating' => 'Nút nổi (Floating)',
                        'cta_section' => 'Khối kêu gọi (CTA)',
                        'footer' => 'Chân trang (Footer)',
                        'modal' => 'Cửa sổ (Modal)',
                        'sidebar' => 'Cột bên (Sidebar)',
                        'content' => 'Nội dung trang',
                        'contact_form' => 'Biểu mẫu tư vấn',
                        'job_application_form' => 'Biểu mẫu tuyển dụng',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCtaClicks::route('/'),
        ];
    }
}

