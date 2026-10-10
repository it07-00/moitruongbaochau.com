<?php

return [
    'recaptcha_site_key' => env('GHG_RECAPTCHA_SITE_KEY', '6LfqxectAAAAAHwdnorG3o6h0sVdToB3s39nEaZw'),
    'recaptcha_secret_key' => env('GHG_RECAPTCHA_SECRET_KEY'),
    'sheets_webhook_url' => env('GHG_SHEETS_WEBHOOK_URL'),
    'sheets_webhook_token' => env('GHG_SHEETS_WEBHOOK_TOKEN'),
    'sheets_spreadsheet_id' => env('GHG_SHEETS_SPREADSHEET_ID', '1dQgYELFqBrDCY2Z-9V9hV6xOpirtQ6A4r8O3ugJ6pzI'),
    'sheets_tab_name' => env('GHG_SHEETS_TAB_NAME', 'Trang tính1'),
    'recaptcha_min_score' => (float) env('GHG_RECAPTCHA_MIN_SCORE', 0.5),
];
