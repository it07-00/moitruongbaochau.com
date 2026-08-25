<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin khách hàng & Nhận xét')
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Họ tên khách hàng')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('client_company')
                            ->label('Công ty / Đơn vị')
                            ->maxLength(255),
                        TextInput::make('client_role')
                            ->label('Chức vụ')
                            ->placeholder('vd: Giám đốc, Trưởng phòng Kỹ thuật...')
                            ->maxLength(255),
                        FileUpload::make('avatar')
                            ->label('Ảnh đại diện / Logo công ty')
                            ->image()
                            ->disk('public')
                            ->directory('uploads/testimonials')
                            ->imageResizeMode('cover'),
                        Textarea::make('content')
                            ->label('Nội dung đánh giá / nhận xét')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Select::make('rating')
                            ->label('Đánh giá sao')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ (5 sao)',
                                4 => '⭐⭐⭐⭐ (4 sao)',
                                3 => '⭐⭐⭐ (3 sao)',
                            ])
                            ->default(5)
                            ->required(),
                        TextInput::make('source')
                            ->label('Nguồn đánh giá')
                            ->default('Google Reviews')
                            ->required(),
                        TextInput::make('source_url')
                            ->label('Đường dẫn đánh giá gốc (URL)')
                            ->placeholder('https://maps.app.goo.gl/...'),
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
