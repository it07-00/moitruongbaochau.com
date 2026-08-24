<?php

namespace App\Models\Concerns;

trait HasSeoAttributes
{
    /**
     * @return array<int, string>
     */
    public static function seoFillable(): array
    {
        return [
            'meta_title',
            'meta_description',
            'canonical_url',
            'robots',
            'og_title',
            'og_description',
            'og_image',
            'twitter_title',
            'twitter_description',
            'twitter_image',
        ];
    }
}
