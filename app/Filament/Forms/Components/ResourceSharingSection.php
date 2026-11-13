<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ResourceSharingSection
{
    public static function make(): Section
    {
        return Section::make('Key / Mật khẩu hiển thị cuối trang')
            ->description('Hiển thị một dòng key/mật khẩu ở cuối bài viết để người xem sao chép nhanh (để trống nếu không dùng).')
            ->schema([
                TextInput::make('resource_password_hint')
                    ->label('Tiêu đề / Nhãn hiển thị')
                    ->placeholder('Ví dụ: Key / Mật khẩu giải nén:')
                    ->maxLength(255),
                TextInput::make('resource_password')
                    ->label('Key / Mật khẩu')
                    ->placeholder('Ví dụ: MBC-2026-KEY')
                    ->maxLength(120),
            ])
            ->columns(2)
            ->collapsed();
    }
}
