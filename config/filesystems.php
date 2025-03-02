<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'profile_images' => [ // Need to be in the private visibility and private root folder
            'driver' => 'local',
            'root' => storage_path('app/private/profile_images'),
            'url' => env('APP_URL') . '/storage/private/profile_images',
            'visibility' => 'private',
        ],

        'tmp' => [
            'driver' => 'local',
            'root' => storage_path('app/private/tmp'),
            'visibility' => 'private',
        ],

        'livewire_tmp' => [
            'driver' => 'local',
            'root' => storage_path('app/private/livewire_tmp'),
            'serve' => true,
            'throw' => false,
        ],

        'media' => [
            'driver' => 'local',
            'root' => storage_path('app/private/media'),
            'url' => env('APP_URL') . '/storage/private/media',
            'visibility' => 'private',
            'throw' => false,
        ],

        'backups' => [
            'driver' => 'local',
            'root' => storage_path('backups/') . env('APP_NAME', 'laravel-backup') . '_backups',
            'serve' => true,
            'throw' => false,
        ],

        'google' => [
            'driver' => 'google',
            'clientId' => env('GOOGLE_DRIVE_CLIENT_ID', ''),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET', ''),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN', ''),
            'folder' => env('GOOGLE_DRIVE_FOLDER', ''),
            'sharedFolderId' => env('GOOGLE_DRIVE_SHARED_FOLDER_ID'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
