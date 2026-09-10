<?php

namespace App\Filament\Resources\Menus;

use App\Filament\Resources\Menus\Pages\CreateMenu;
use App\Filament\Resources\Menus\Pages\EditMenu;
use App\Filament\Resources\Menus\Pages\ListMenus;
use App\Models\Menu;
use App\Models\MenuItem;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3;

    protected static string|UnitEnum|null $navigationGroup = 'Cấu hình & Hệ thống';

    protected static ?string $navigationLabel = 'Menu điều hướng';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Menu';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Menu điều hướng';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin Menu')
                    ->components([
                        TextInput::make('name')
                            ->label('Tên Menu')
                            ->required()
                            ->maxLength(191),
                        TextInput::make('location')
                            ->label('Vị trí hiển thị (Location Key)')
                            ->placeholder('Ví dụ: primary, footer...')
                            ->helperText('Header sử dụng menu có vị trí primary.')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Kích hoạt')
                            ->default(true),
                    ])->columns(3),

                Section::make('Các mục trong Menu (Menu Items)')
                    ->description('Kéo thả để sắp xếp. Chọn mục cha để tạo menu con; để trống để hiển thị trên thanh chính. Với mục cha mới, lưu menu trước rồi chọn lại.')
                    ->components([
                        Repeater::make('items')
                            ->label('Danh sách liên kết')
                            ->relationship('items')
                            ->orderColumn('sort_order')
                            ->components([
                                TextInput::make('label')
                                    ->label('Nhãn hiển thị')
                                    ->required()
                                    ->maxLength(191),
                                Select::make('parent_id')
                                    ->label('Mục cha')
                                    ->placeholder('Thanh menu chính')
                                    ->options(function ($record, $livewire): array {
                                        $menu = $livewire->getRecord();

                                        return $menu instanceof Menu
                                            ? self::parentOptions($menu, $record instanceof MenuItem ? $record : null)
                                            : [];
                                    })
                                    ->searchable(),
                                TextInput::make('url')
                                    ->label('Đường dẫn URL tùy chỉnh')
                                    ->maxLength(191)
                                    ->regex('/^(https?:\/\/|mailto:|tel:|\/(?!\/)|#)/i')
                                    ->placeholder('/du-an hoặc https://...'),
                                TextInput::make('route_name')
                                    ->label('Hoặc tên Route Laravel')
                                    ->placeholder('home, services.index, about...'),
                                Select::make('target')
                                    ->label('Mở liên kết trong')
                                    ->options([
                                        '_self' => 'Cùng tab (_self)',
                                        '_blank' => 'Tab mới (_blank)',
                                    ])
                                    ->default('_self'),
                                Toggle::make('is_active')
                                    ->label('Hiển thị')
                                    ->default(true),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên Menu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('location')
                    ->label('Vị trí (Location)')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('items_count')
                    ->label('Số mục')
                    ->counts('items')
                    ->badge(),
                IconColumn::make('is_active')
                    ->label('Trạng thái')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
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

    /** @return array<int, string> */
    private static function parentOptions(Menu $menu, ?MenuItem $item): array
    {
        $items = $menu->loadMissing('items')->items->keyBy('id');

        return $items->filter(function (MenuItem $candidate) use ($items, $item): bool {
            $current = $candidate;
            $visited = [];

            while ($current !== null) {
                if ($current->id === $item?->id || in_array($current->id, $visited, true)) {
                    return false;
                }
                $visited[] = $current->id;
                $current = $items->get($current->parent_id);
            }

            return true;
        })->mapWithKeys(fn (MenuItem $candidate): array => [
            $candidate->id => $candidate->label.' (#'.$candidate->id.')',
        ])->all();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMenus::route('/'),
            'create' => CreateMenu::route('/create'),
            'edit' => EditMenu::route('/{record}/edit'),
        ];
    }
}
