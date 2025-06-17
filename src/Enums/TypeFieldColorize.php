<?php

namespace Ermakk\MoonshineTableColorize\Enums;

enum TypeFieldColorize: string
{
    case VALUE = '1';
    case TARGET = '2';
    case BOOL = '3';

    public function toString(): string
    {
        return match ($this) {
            self::VALUE => 'Статичное значение',
            self::TARGET => 'Сравнить с полем',
            self::BOOL => 'Логическое значение',
        };
    }
}
