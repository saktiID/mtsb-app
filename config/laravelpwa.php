<?php

return [
    'name' => 'MTsB-APP',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'MTsB',
        'start_url' => '/',
        'background_color' => '#97cde0',
        'theme_color' => '#000000',
        'display_override' => ['fullscreen'],
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => '#97cde0',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/default/icon-72x72.png',
                'purpose' => 'any',
            ],
            '96x96' => [
                'path' => '/images/icons/default/icon-96x96.png',
                'purpose' => 'any',
            ],
            '128x128' => [
                'path' => '/images/icons/default/icon-128x128.png',
                'purpose' => 'any',
            ],
            '144x144' => [
                'path' => '/images/icons/default/icon-144x144.png',
                'purpose' => 'any',
            ],
            '152x152' => [
                'path' => '/images/icons/default/icon-152x152.png',
                'purpose' => 'any',
            ],
            '192x192' => [
                'path' => '/images/icons/default/icon-192x192.png',
                'purpose' => 'any',
            ],
            '384x384' => [
                'path' => '/images/icons/default/icon-384x384.png',
                'purpose' => 'any',
            ],
            '512x512' => [
                'path' => '/images/icons/default/icon-512x512.png',
                'purpose' => 'any',
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'MTsB',
                'description' => 'Shortcut MTsB Application',
                'url' => '/home',
                'icons' => [
                    'src' => '/images/icons/default/icon-96x96.png',
                    'sizes' => '96x96',
                    'purpose' => 'any',
                ],
            ],
        ],
        'custom' => [
            'screenshots' => [
                [
                    'src' => '/images/icons/default/icon-512x512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'form_factor' => 'wide',
                    'label' => 'MTsB Application',
                ],
                [
                    'src' => '/images/icons/default/icon-384x384.png',
                    'sizes' => '384x384',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'MTsB Application',
                ],
            ],
            'shortcuts' => [
                [
                    'name' => 'MTsB',
                    'description' => 'Shortcut MTsB Application',
                    'url' => '/home',
                    'icons' => [
                        [
                            'src' => '/images/icons/default/icon-96x96.png',
                            'type' => 'image/png',
                            'sizes' => '96x96',
                            'purpose' => 'any',
                        ],
                    ],
                ],
            ],
            'description' => 'Aplikasi untuk sarana belajar di MTsB',
            'orientation' => 'portrait',
        ],
    ],
];
