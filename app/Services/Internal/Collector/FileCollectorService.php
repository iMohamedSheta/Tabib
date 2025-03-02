<?php

declare(strict_types=1);

namespace App\Services\Internal\Collector;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class FileCollectorService
{
    /**
     * Collect files based on provided folders and/or specific files.
     *
     * @param string      $foldersInput comma-separated list of folders
     * @param string|null $filesInput   comma-separated list of specific files
     *
     * @return Collection<\SplFileInfo>
     */
    public function collectFiles(string $foldersInput = '', ?string $filesInput = null): Collection
    {
        $files = collect();

        // Collect specific files if provided.
        if (!empty($filesInput)) {
            $filesList = array_map('trim', explode(',', $filesInput));

            foreach ($filesList as $filePath) {
                $absolutePath = base_path($filePath);

                if (!File::exists($absolutePath)) {
                    // TODO Log or warn here if a file doesn't exist.
                    continue;
                }
                // For consistency, pushing files to an SplFileInfo object.
                $files->push(new \SplFileInfo($absolutePath));
            }
        }

        // Collect files from the provided folders.
        if (!empty($foldersInput)) {
            $folderPaths = array_map('trim', explode(',', $foldersInput));

            foreach ($folderPaths as $folder) {
                $absoluteFolder = base_path($folder);

                if (!File::exists($absoluteFolder)) {
                    // TODO Log or warn here if a folder doesn't exist.
                    continue;
                }

                // File::allFiles returns an array of SplFileInfo objects.
                $folderFiles = File::allFiles($absoluteFolder);
                $files = $files->merge($folderFiles);
            }
        }

        // remove duplicate files (if a file is specified both ways).
        $files = $files->unique(fn ($file) => $file instanceof \SplFileInfo
            ? $file->getRealPath()
            : $file);

        return $files;
    }
}
