<?php

return [
    'mode' => '',
    'format' => [89, 51], // Business card size in mm (3.5 x 2 inches)
    'orientation' => 'L',
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'tempDir' => storage_path('app/temp'),
    'allowed_html' => '', // Disable HTML restrictions
    'curlFollowLocation' => true,
    'curlAllowUnsafeSslRequests' => true,
    'ssl_verify_peer' => false,
    'ssl_verify_peer_name' => false,
    'ssl_allow_self_signed' => true,
    'fontDir' => [
        public_path('fonts'),
        storage_path('fonts'),
        base_path('vendor/mpdf/mpdf/ttfonts'),
    ],
    'fontdata' => [
        'montserrat' => [
            'R' => 'Montserrat-Regular.ttf',
            'B' => 'Montserrat-Bold.ttf',
        ],
        'fontawesome' => [
            'R' => 'fa-solid-900.ttf',
        ],
        'fontawesomebrands' => [
            'R' => 'fa-brands-400.ttf',
        ]
    ],
    'default_font' => 'montserrat',    'debug' => false,
    'allow_output_buffering' => true,
    'cache_dir' => storage_path('app/pdf-cache'),
    'allow_html_optional_tags' => false,
    'img_cache_ttl' => 86400, // 24 hours
    'enable_remote' => false,
    'setAutoTopMargin' => 'pad',
    'setAutoBottomMargin' => 'pad',
    'defaultheaderline' => 0,
    'defaultfooterfontsize' => 0,
];
