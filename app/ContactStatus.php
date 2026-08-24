<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ContactStatus: string implements HasColor, HasLabel
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Resolved = 'resolved';
    case Spam = 'spam';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => 'Chờ xử lý (Mới)',
            self::InProgress => 'Đang liên hệ',
            self::Resolved => 'Đã hoàn tất',
            self::Spam => 'Spam / Rác',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New => 'warning',
            self::InProgress => 'info',
            self::Resolved => 'success',
            self::Spam => 'danger',
        };
    }
}
