<?php

namespace App\Enums\Media;

enum MediaCollectionEnum: string
{
    case IMAGES = 'images';
    case VIDEOS = 'videos';
    case DOCUMENTS = 'documents';
    case AUDIOS = 'AUDIOS';
    case ARCHIVES = 'archives';
    case OTHERS = 'others';

    public static function determineCollection(string $mimeType): self
    {
        $imageMimes = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/svg+xml', 'image/webp'];
        $videoMimes = ['video/mp4', 'video/mov', 'video/avi', 'video/wmv'];
        $audioMimes = ['audio/mp3', 'audio/wav', 'audio/m4a', 'audio/wma'];
        $documentMimes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'text/csv', 'text/xml', 'application/json'];
        $archiveMimes = ['application/zip', 'application/x-zip-compressed', 'application/x-rar-compressed'];

        return match (true) {
            in_array($mimeType, $imageMimes) => self::IMAGES,
            in_array($mimeType, $videoMimes) => self::VIDEOS,
            in_array($mimeType, $audioMimes) => self::AUDIOS,
            in_array($mimeType, $documentMimes) => self::DOCUMENTS,
            in_array($mimeType, $archiveMimes) => self::ARCHIVES,
            default => self::OTHERS,
        };
    }

    public static function getCollection(string $collectionValue): self
    {
        return match ($collectionValue) {
            self::IMAGES->value => self::IMAGES,
            self::VIDEOS->value => self::VIDEOS,
            self::DOCUMENTS->value => self::DOCUMENTS,
            self::OTHERS->value => self::OTHERS,
            default => self::OTHERS,
        };
    }
}
