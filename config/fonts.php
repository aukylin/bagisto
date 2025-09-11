<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 字体加载策略
    |--------------------------------------------------------------------------
    |
    | 可选值: 'cdn', 'local', 'hybrid'
    | cdn: 使用Google Fonts CDN
    | local: 使用本地字体文件
    | hybrid: CDN优先，失败时回退到本地字体
    |
    */
    'strategy' => env('FONT_STRATEGY', 'cdn'),

    /*
    |--------------------------------------------------------------------------
    | 字体加载超时时间
    |--------------------------------------------------------------------------
    |
    | 单位：毫秒
    |
    */
    'timeout' => env('FONT_TIMEOUT', 3000),

    /*
    |--------------------------------------------------------------------------
    | 字体配置
    |--------------------------------------------------------------------------
    */
    'fonts' => [
        'poppins' => [
            'family' => 'Poppins',
            'weights' => '400;500;600;700;800',
            'cdn_url' => 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',
            'local_path' => '/fonts/poppins-local.css',
        ],
        'dm_serif' => [
            'family' => 'DM Serif Display',
            'weights' => '400',
            'cdn_url' => 'https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap',
            'local_path' => '/fonts/dm-serif-display-local.css',
        ],
        'inter' => [
            'family' => 'Inter',
            'weights' => '400;500;600;700',
            'cdn_url' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
            'local_path' => '/fonts/inter-local.css',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 回退字体栈
    |--------------------------------------------------------------------------
    */
    'fallback' => [
        'sans-serif' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
        'serif' => 'Georgia, "Times New Roman", Times, serif',
    ],
];