<?php

namespace App\Support;

class RichContentNormalizer
{
    public static function normalizeLegacyFigures(?string $html): ?string
    {
        if (blank($html) || ! str_contains(strtolower($html), '<figure')) {
            return $html;
        }

        $html = preg_replace('/<figure\b([^>]*)>/i', '<div data-rich-content-figure="true"$1>', $html);
        $html = preg_replace('/<\/figure>/i', '</div>', $html);
        $html = preg_replace('/<figcaption\b([^>]*)>/i', '<p data-rich-content-caption="true"$1>', $html);

        return preg_replace('/<\/figcaption>/i', '</p>', $html);
    }
}
