<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PrivateStorageController extends Controller
{
    public function showMedia(Media $media): BinaryFileResponse
    {
        if (!auth()->user()->can('view', $media)) {
            abort(403, 'Unauthorized access');
        }

        $filePath = $media->getPath();

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'inline',
        ]);
    }

    public function showProfilePicture(string $encryptedPath): BinaryFileResponse
    {
        $profilePhotoPath = decrypt($encryptedPath);

        if (!auth()->user()->can('view', auth()->user())) {
            abort(403, 'Unauthorized access');
        }

        $disk = \Storage::disk(config('jetstream.profile_photo_disk', 'public'));

        $fullPath = $disk->path($profilePhotoPath);

        // Check if the file exists
        if (!$disk->exists($profilePhotoPath)) {
            abort(404, 'File not found');
        }

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline',
        ]);
    }
}
