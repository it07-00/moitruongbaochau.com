<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CtaType: string implements HasColor, HasLabel
{
    case Hotline = 'hotline';
    case Zalo = 'zalo';
    case Email = 'email';
    case Map = 'map';
    case Consultation = 'consultation';
    case Pdf = 'pdf';
    case FormSubmit = 'form_submit';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Hotline => 'Gọi Hotline',
            self::Zalo => 'Chat Zalo',
            self::Email => 'Gửi Email',
            self::Map => 'Xem Bản đồ',
            self::Consultation => 'Nút Tư vấn / Báo giá',
            self::Pdf => 'Hồ sơ năng lực / Tài liệu',
            self::FormSubmit => 'Gửi biểu mẫu thành công',
            self::Other => 'Khác',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Hotline => 'danger',
            self::Zalo => 'info',
            self::Email => 'gray',
            self::Map => 'warning',
            self::Consultation => 'primary',
            self::Pdf => 'info',
            self::FormSubmit => 'success',
            self::Other => 'gray',
        };
    }
}
