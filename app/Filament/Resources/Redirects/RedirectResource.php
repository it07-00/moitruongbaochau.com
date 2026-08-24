<?php

namespace App\Filament\Resources\Redirects;

use App\Filament\Resources\Redirects\Pages\CreateRedirect;
use App\Filament\Resources\Redirects\Pages\EditRedirect;
use App\Filament\Resources\Redirects\Pages\ListRedirects;
use App\Models\Redirect;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string|UnitEnum|null $navigationGroup = 'Cấu hình & Hệ thống';

    protected static ?string $navigationLabel = 'Chuyển hướng (301/302)';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return 'Chuyển hướng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Chuyển hướng URL';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cấu hình chuyển hướng URL')
                    ->components([
                        TextInput::make('old_path')
                            ->label('Đường dẫn cũ (Old Path)')
                            ->placeholder('Ví dụ: /old-service.html hoặc /gioi-thieu.php')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('new_path')
                            ->label('Đường dẫn đích mới (New Path)')
                            ->placeholder('Ví dụ: /dich-vu hoặc https://...')
                            ->required()
                            ->maxLength(255),
                        Select::make('status_code')
                            ->label('Mã chuyển hướng HTTP (Status Code)')
                            ->options([
                                301 => '301 - Chuyển hướng vĩnh viễn (Permanent - Tốt cho SEO)',
                                302 => '302 - Chuyển hướng tạm thời (Temporary)',
                            ])
                            ->default(301)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Kích hoạt chuyển hướng')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('old_path')
                    ->label('Đường dẫn cũ')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('new_path')
                    ->label('Đường dẫn mới')
                    ->searchable(),
                TextColumn::make('status_code')
                    ->label('Mã HTTP')
                    ->badge()
                    ->color('info'),
                TextColumn::make('hit_count')
                    ->label('Lượt truy cập')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Trạng thái')
                    ->boolean(),
                TextColumn::make('last_hit_at')
                    ->label('Lần truy cập cuối')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make(),
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
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }
}
