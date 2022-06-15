<?php

namespace FilamentAddons\Enums;

enum Status
{
    case Draft;
    case Review;
    case Published;

    public function color(): string
    {
        return match ($this) {
            Status::Draft => 'danger',
            Status::Review => 'warning',
            Status::Published => 'success',
        };
    }

    public static function colors(): array
    {
        return [
            'danger' => 'Draft',
            'warning' => 'Review',
            'success' => 'Published',
        ];
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::names(), self::names());
    }
}
