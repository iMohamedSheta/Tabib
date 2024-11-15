<?php

return [
    'plugins' => [
        'sweetalert' => [
            'scripts' => [
                '/vendor/flasher/sweetalert2.min.js',
                '/vendor/flasher/flasher-sweetalert.min.js',
            ],
            'styles' => [
                '/vendor/flasher/sweetalert2.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                // 'position' => 'center'
            ],
        ],
        'flasher' => [
            'scripts' => [
                '/vendor/flasher/flasher.min.js',
            ],
            'styles' => [
                '/assets/css/flasher/flasher.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                'position' => 'top-right'
            ],
            'dark' => true
        ],
    ],
];
