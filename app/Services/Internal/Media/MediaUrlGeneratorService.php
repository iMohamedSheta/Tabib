<?php

namespace App\Services\Internal\Media;

use App\Models\Media;
use Illuminate\Support\Facades\URL;

class MediaUrlGeneratorService
{
    /**
     * Generates a URL for a given media item.
     *
     * @param Media $media        the media item to generate a URL for
     * @param int   $ttlInMinutes the time to live for the URL in minutes
     *
     * @return string the temporary URL
     */
    public function handle(int $mediaId, int $ttlInMinutes = 10): string
    {
        // if ('s3' === $media->disk) {
        //     return $media->getTemporaryUrl(now()->addMinutes($ttlInMinutes));
        // }

        return URL::route('storage.private.tmp.media', ['encryptedMedia' => encrypt($mediaId)]);
    }
}
