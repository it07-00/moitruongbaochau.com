<?php

return [
    'recaptcha_site_key' => env('GHG_RECAPTCHA_SITE_KEY', '6LfqxectAAAAAHwdnorG3o6h0sVdToB3s39nEaZw'),
    'recaptcha_secret_key' => env('GHG_RECAPTCHA_SECRET_KEY'),
    'recaptcha_min_score' => (float) env('GHG_RECAPTCHA_MIN_SCORE', 0.5),
];
