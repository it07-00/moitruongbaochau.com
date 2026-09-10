<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin Banner / Slide')
                    ->schema([
                        TextInput::make('title')
                            ->label('Tiêu đề banner')
                            ->maxLength(255),
                        TextInput::make('caption')
                            ->label('Mô tả phụ / Slogan')
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->label('Hình ảnh banner')
                            ->image()
                            ->disk('public')
                            ->directory('uploads/sliders')
                            ->automaticallyResizeImagesMode('cover')
                            ->required()
                            ->helperText('Khuyên dùng banner ngang khoảng 2.7:1 (1920×720 hoặc 1536×568 px). Ảnh được thu vừa khung trên điện thoại, không cắt nội dung.'),
                        TextInput::make('link')
                            ->label('Đường dẫn khi click (URL)')
                            ->placeholder('vd: /dich-vu hoặc https://...')
                            ->maxLength(255),
                        Toggle::make('open_in_new_tab')
                            ->label('Mở trong tab mới')
                            ->default(false),
                        TextInput::make('sort_order')
                            ->label('Thứ tự hiển thị')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Hiển thị trên website')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }
}
