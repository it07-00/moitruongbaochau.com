<?php

namespace App\Filament\Resources\PageViews;

use App\Filament\Resources\PageViews\Pages\ListPageViews;
use App\Models\PageView;
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

class PageViewResource extends Resource
{
    protected static ?string $model = PageView::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEye;

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Thống kê lượt xem';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return 'Lượt xem trang';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Thống kê lượt xem trang';
    }

    public static function getNavigationBadge(): ?string
    {
        $todayCount = static::getEloquentQuery()->whereDate('created_at', today())->count();

        return $todayCount > 0 ? (string) $todayCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_type')
                    ->label('Phân loại trang')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'landing' => 'success',
                        'service' => 'warning',
                        'project' => 'info',
                        'post' => 'primary',
                        'job_posting' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'landing' => 'Landing Page',
                        'page' => 'Trang chính',
                        'service' => 'Dịch vụ',
                        'project' => 'Dự án',
                        'post' => 'Bài viết',
                        'job_posting' => 'Tuyển dụng',
                        default => 'Khác',
                    }),
                TextColumn::make('page_title')
                    ->label('Tiêu đề trang')
                    ->searchable()
                    ->weight('bold')
                    ->limit(55),
                TextColumn::make('page_url')
                    ->label('Đường dẫn (URL)')
                    ->searchable()
                    ->limit(45),
                TextColumn::make('referrer')
                    ->label('Nguồn truy cập (Referrer)')
                    ->searchable()
                    ->placeholder('Trực tiếp (Direct)')
                    ->limit(40)
                    ->toggleable(),
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
                SelectFilter::make('page_type')
                    ->label('Lọc theo loại trang')
                    ->options([
                        'landing' => 'Landing Page',
                        'page' => 'Trang chính',
                        'service' => 'Dịch vụ',
                        'project' => 'Dự án',
                        'post' => 'Bài viết',
                        'job_posting' => 'Tuyển dụng',
                    ]),
                SelectFilter::make('page_key')
                    ->label('Lọc nhanh trang trọng điểm')
                    ->options([
                        'landing:ghg-service' => 'Landing Page: Kiểm kê Khí nhà kính',
                        'page:home' => 'Trang chủ',
                        'page:about' => 'Trang Giới thiệu',
                        'page:capability-profile' => 'Hồ sơ năng lực',
                        'page:services' => 'Danh sách Dịch vụ',
                        'page:projects' => 'Danh sách Dự án',
                        'page:posts' => 'Danh sách Tin tức',
                        'page:recruitment' => 'Danh sách Tuyển dụng',
                        'page:contact' => 'Trang Liên hệ',
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
            'index' => ListPageViews::route('/'),
        ];
    }
}
