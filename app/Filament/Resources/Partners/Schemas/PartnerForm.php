<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin Đối tác / Báo chí')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên đơn vị / Tên bài báo')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Phân loại')
                            ->options([
                                'partner' => '🏢 Khách hàng & Đối tác',
                                'press' => '📰 Báo chí & Truyền thông',
                            ])
                            ->default('partner')
                            ->required(),
                        FileUpload::make('logo')
                            ->label('Hình ảnh Logo')
                            ->image()
                            ->disk('public')
                            ->directory('uploads/partners')
                            ->required(),
                        TextInput::make('link')
                            ->label('Đường dẫn website / bài báo (URL)')
                            ->placeholder('https://...')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Thứ tự hiển thị')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Hiển thị trên website')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
