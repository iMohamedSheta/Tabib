<?php

use App\Services\Internal\PWA\ManifestService;

uses(Tests\TestCase::class);


describe('ManifestService', function () {
    it('generates the manifest array with default configurations', function () {
        // Mock the config values to ensure consistent testing
        config([ 'laravelpwa.manifest.name' => 'Test App' ]);
        config([ 'laravelpwa.manifest.short_name' => 'Test' ]);
        config([ 'laravelpwa.manifest.start_url' => '/start' ]);
        config([ 'laravelpwa.manifest.display' => 'standalone' ]);
        config([ 'laravelpwa.manifest.theme_color' => '#FFFFFF' ]);
        config([ 'laravelpwa.manifest.background_color' => '#000000' ]);
        config([ 'laravelpwa.manifest.orientation' => 'portrait' ]);
        config([ 'laravelpwa.manifest.status_bar' => 'default' ]);
        config([ 'laravelpwa.manifest.splash' => [] ]);
        config([ 'laravelpwa.manifest.icons' => [] ]);
        config([ 'laravelpwa.manifest.shortcuts' => [] ]);
        config([ 'laravelpwa.manifest.custom' => [] ]);

        $service = new ManifestService();
        $manifest = $service->generate();

        expect($manifest)->toBeArray();
        expect($manifest['name'])->toBe('Test App');
        expect($manifest['short_name'])->toBe('Test');
        expect($manifest['start_url'])->toBe(asset('/start'));
        expect($manifest['display'])->toBe('standalone');
        expect($manifest['theme_color'])->toBe('#FFFFFF');
        expect($manifest['background_color'])->toBe('#000000');
        expect($manifest['orientation'])->toBe('portrait');
        expect($manifest['status_bar'])->toBe('default');

        expect($manifest)->not()->toHaveKey('icons');
        expect($manifest)->not()->toHaveKey('shortcuts');
    });

    it('includes icons in the manifest if configured', function () {
        // Mock the config values including icons
        config([ 'laravelpwa.manifest.name' => 'Test App' ]);
        config([ 'laravelpwa.manifest.short_name' => 'Test' ]);
        config([ 'laravelpwa.manifest.start_url' => '/start' ]);
        config([ 'laravelpwa.manifest.display' => 'standalone' ]);
        config([ 'laravelpwa.manifest.theme_color' => '#FFFFFF' ]);
        config([ 'laravelpwa.manifest.background_color' => '#000000' ]);
        config([ 'laravelpwa.manifest.orientation' => 'portrait' ]);
        config([ 'laravelpwa.manifest.status_bar' => 'default' ]);
        config([ 'laravelpwa.manifest.splash' => [] ]);
        config([ 'laravelpwa.manifest.icons' => [
            '72x72' => ['path' => '/images/icons/72x72.png', 'sizes' => '72x72', 'purpose' => 'maskable'],
            '96x96' => ['path' => '/images/icons/96x96.png', 'sizes' => '96x96', 'purpose' => 'any'],
        ]]);
        config([ 'laravelpwa.manifest.shortcuts' => [] ]);
        config([ 'laravelpwa.manifest.custom' => [] ]);

        $service = new ManifestService();
        $manifest = $service->generate();

        expect($manifest)->toBeArray();
        expect($manifest)->toHaveKey('icons');
        expect($manifest['icons'])->toBeArray();
        expect($manifest['icons'])->toHaveCount(2);

        expect($manifest['icons'][0]['src'])->toBe('/images/icons/72x72.png');
        expect($manifest['icons'][0]['type'])->toBe('image/png');
        expect($manifest['icons'][0]['sizes'])->toBe('72x72');
        expect($manifest['icons'][0]['purpose'])->toBe('maskable');

        expect($manifest['icons'][1]['src'])->toBe('/images/icons/96x96.png');
        expect($manifest['icons'][1]['type'])->toBe('image/png');
        expect($manifest['icons'][1]['sizes'])->toBe('96x96');
        expect($manifest['icons'][1]['purpose'])->toBe('any');

    });

    it('includes shortcuts in the manifest if configured', function () {
        // Mock the config values including shortcuts
        config([ 'laravelpwa.manifest.name' => 'Test App' ]);
        config([ 'laravelpwa.manifest.short_name' => 'Test' ]);
        config([ 'laravelpwa.manifest.start_url' => '/start' ]);
        config([ 'laravelpwa.manifest.display' => 'standalone' ]);
        config([ 'laravelpwa.manifest.theme_color' => '#FFFFFF' ]);
        config([ 'laravelpwa.manifest.background_color' => '#000000' ]);
        config([ 'laravelpwa.manifest.orientation' => 'portrait' ]);
        config([ 'laravelpwa.manifest.status_bar' => 'default' ]);
        config([ 'laravelpwa.manifest.splash' => [] ]);
        config([ 'laravelpwa.manifest.icons' => [] ]);
        config([ 'laravelpwa.manifest.shortcuts' => [
            [
                'name' => 'Shortcut 1',
                'description' => 'Description 1',
                'url' => '/shortcut1',
                'icons' => ['src' => '/images/icons/shortcut1.png', 'sizes' => '192x192', 'purpose' => 'any'],
            ],
            [
                'name' => 'Shortcut 2',
                'description' => 'Description 2',
                'url' => '/shortcut2',
                'icons' => ['src' => '/images/icons/shortcut2.png', 'sizes' => '512x512', 'purpose' => 'maskable'],
            ],
        ]]);
        config([ 'laravelpwa.manifest.custom' => [] ]);

        $service = new ManifestService();
        $manifest = $service->generate();

        expect($manifest)->toBeArray();
        expect($manifest)->toHaveKey('shortcuts');
        expect($manifest['shortcuts'])->toBeArray();
        expect($manifest['shortcuts'])->toHaveCount(2);

        expect($manifest['shortcuts'][0]['name'])->toBe('Shortcut 1');
        expect($manifest['shortcuts'][0]['description'])->toBe('Description 1');
        expect($manifest['shortcuts'][0]['url'])->toBe('/shortcut1');
        expect($manifest['shortcuts'][0]['icons'][0]['src'])->toBe('/images/icons/shortcut1.png');
        expect($manifest['shortcuts'][0]['icons'][0]['sizes'])->toBe('192x192');
        expect($manifest['shortcuts'][0]['icons'][0]['purpose'])->toBe('any');
        expect($manifest['shortcuts'][0]['icons'][0]['type'])->toBe('image/png');

        expect($manifest['shortcuts'][1]['name'])->toBe('Shortcut 2');
           expect($manifest['shortcuts'][1]['description'])->toBe('Description 2');
        expect($manifest['shortcuts'][1]['url'])->toBe('/shortcut2');
        expect($manifest['shortcuts'][1]['icons'][0]['src'])->toBe('/images/icons/shortcut2.png');
        expect($manifest['shortcuts'][1]['icons'][0]['sizes'])->toBe('512x512');
        expect($manifest['shortcuts'][1]['icons'][0]['purpose'])->toBe('maskable');
           expect($manifest['shortcuts'][1]['icons'][0]['type'])->toBe('image/png');
    });

    it('includes custom tags in the manifest if configured', function () {
        // Mock the config values including custom tags
        config([ 'laravelpwa.manifest.name' => 'Test App' ]);
        config([ 'laravelpwa.manifest.short_name' => 'Test' ]);
        config([ 'laravelpwa.manifest.start_url' => '/start' ]);
        config([ 'laravelpwa.manifest.display' => 'standalone' ]);
        config([ 'laravelpwa.manifest.theme_color' => '#FFFFFF' ]);
        config([ 'laravelpwa.manifest.background_color' => '#000000' ]);
        config([ 'laravelpwa.manifest.orientation' => 'portrait' ]);
        config([ 'laravelpwa.manifest.status_bar' => 'default' ]);
        config([ 'laravelpwa.manifest.splash' => [] ]);
        config([ 'laravelpwa.manifest.icons' => [] ]);
        config([ 'laravelpwa.manifest.shortcuts' => [] ]);
        config([ 'laravelpwa.manifest.custom' => ['custom_tag' => 'custom_value'] ]);

        $service = new ManifestService();
        $manifest = $service->generate();

        expect($manifest)->toBeArray();
        expect($manifest)->toHaveKey('custom_tag');
        expect($manifest['custom_tag'])->toBe('custom_value');
    });
});
