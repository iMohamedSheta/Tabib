<?php

namespace App\Services\Internal\PWA;

class ManifestService
{
    /**
     * @return mixed[]
     */
    public function generate(): array
    {
        $basicManifest = [
            'name' => config('laravelpwa.manifest.name'),
            'short_name' => config('laravelpwa.manifest.short_name'),
            'start_url' => asset(config('laravelpwa.manifest.start_url')),
            'display' => config('laravelpwa.manifest.display'),
            'theme_color' => config('laravelpwa.manifest.theme_color'),
            'background_color' => config('laravelpwa.manifest.background_color'),
            'orientation' => config('laravelpwa.manifest.orientation'),
            'status_bar' => config('laravelpwa.manifest.status_bar'),
            'splash' => config('laravelpwa.manifest.splash'),
        ];

        foreach (config('laravelpwa.manifest.icons') as $size => $file) {
            $fileInfo = pathinfo((string) $file['path']);
            $basicManifest['icons'][] = [
                'src' => $file['path'],
                'type' => 'image/' . $fileInfo['extension'],
                'sizes' => $file['sizes'] ?? $size,
                'purpose' => $file['purpose'],
            ];
        }

        if (config('laravelpwa.manifest.shortcuts')) {
            foreach (config('laravelpwa.manifest.shortcuts') as $shortcut) {
                if (array_key_exists('icons', $shortcut)) {
                    $fileInfo = pathinfo((string) $shortcut['icons']['src']);
                    $icon = [
                        'src' => $shortcut['icons']['src'],
                        'type' => 'image/' . $fileInfo['extension'],
                        'sizes' => $file['sizes'] ?? $size,
                        'purpose' => $shortcut['icons']['purpose'],
                    ];
                    if (isset($shortcut['icons']['sizes'])) {
                        $icon['sizes'] = $shortcut['icons']['sizes'];
                    }
                } else {
                    $icon = [];
                }

                $basicManifest['shortcuts'][] = [
                    'name' => trans($shortcut['name']),
                    'description' => trans($shortcut['description']),
                    'url' => $shortcut['url'],
                    'icons' => [
                        $icon,
                    ],
                ];
            }
        }

        foreach (config('laravelpwa.manifest.custom') as $tag => $value) {
            $basicManifest[$tag] = $value;
        }

        return $basicManifest;
    }
}
