<?php

namespace App\Enums;

enum PageFormat: string
{
    case Wysiwyg = 'wysiwyg';
    case Markdown = 'md';
    case Raw = 'raw';

    public function label(): string
    {
        return match ($this) {
            self::Wysiwyg => 'Rich Editor',
            self::Markdown => 'Markdown',
            self::Raw => 'Raw HTML',
        };
    }
}
