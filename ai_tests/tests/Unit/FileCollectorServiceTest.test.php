<?php

use App\Services\Internal\Collector\FileCollectorService;
use Illuminate\Support\Facades\File;

uses(Tests\TestCase::class);


beforeEach(function (): void {
    $this->fileCollectorService = new FileCollectorService();

    // Create temporary directories and files for testing.
    File::makeDirectory(base_path('temp_folder_1'));
    File::makeDirectory(base_path('temp_folder_2'));
    File::put(base_path('temp_folder_1/temp_file_1.txt'), 'Test content');
    File::put(base_path('temp_folder_1/temp_file_2.txt'), 'Test content');
    File::put(base_path('temp_file_3.txt'), 'Test content');
});


afterEach(function (): void {
    // Clean up temporary directories and files.
    File::deleteDirectory(base_path('temp_folder_1'));
    File::deleteDirectory(base_path('temp_folder_2'));
    File::delete(base_path('temp_file_3.txt'));
});


describe('collectFiles', function (): void {
    it('collects files from specified folders', function (): void {
        $foldersInput = 'temp_folder_1,temp_folder_2';
        $files = $this->fileCollectorService->collectFiles($foldersInput);

        expect($files)->toBeInstanceOf(\Illuminate\Support\Collection::class)
            ->and($files->count())->toBe(2);

        // Check if the collected files are instances of SplFileInfo and have the correct paths.
        foreach ($files as $file) {
            expect($file)->toBeInstanceOf(\SplFileInfo::class);
        }

        $filePaths = $files->map(fn ($file) => $file->getRealPath())->toArray();
        expect($filePaths)->toContain(base_path('temp_folder_1/temp_file_1.txt'))
            ->and($filePaths)->toContain(base_path('temp_folder_1/temp_file_2.txt'));
    });

    it('collects specific files', function (): void {
        $filesInput = 'temp_file_3.txt';
        $files = $this->fileCollectorService->collectFiles('', $filesInput);

        expect($files)->toBeInstanceOf(\Illuminate\Support\Collection::class)
            ->and($files->count())->toBe(1);

        // Check if the collected files are instances of SplFileInfo and have the correct paths.
        foreach ($files as $file) {
            expect($file)->toBeInstanceOf(\SplFileInfo::class);
        }

        expect($files->first()->getRealPath())->toBe(base_path('temp_file_3.txt'));
    });

    it('collects files from both folders and specific files', function (): void {
        $foldersInput = 'temp_folder_1';
        $filesInput = 'temp_file_3.txt';
        $files = $this->fileCollectorService->collectFiles($foldersInput, $filesInput);

        expect($files)->toBeInstanceOf(\Illuminate\Support\Collection::class)
            ->and($files->count())->toBe(3);

        $filePaths = $files->map(fn ($file) => $file->getRealPath())->toArray();

        expect($filePaths)->toContain(base_path('temp_folder_1/temp_file_1.txt'))
            ->and($filePaths)->toContain(base_path('temp_folder_1/temp_file_2.txt'))
            ->and($filePaths)->toContain(base_path('temp_file_3.txt'));
    });

    it('handles duplicate files correctly', function (): void {
        $foldersInput = 'temp_folder_1';
        $filesInput = 'temp_folder_1/temp_file_1.txt';

        $files = $this->fileCollectorService->collectFiles($foldersInput, $filesInput);

        expect($files)->toBeInstanceOf(\Illuminate\Support\Collection::class)
            ->and($files->count())->toBe(2);
    });

    it('handles non-existent folders and files gracefully', function (): void {
        $foldersInput = 'non_existent_folder';
        $filesInput = 'non_existent_file.txt';

        $files = $this->fileCollectorService->collectFiles($foldersInput, $filesInput);

        expect($files)->toBeInstanceOf(\Illuminate\Support\Collection::class)
            ->and($files->count())->toBe(0);
    });

    it('collects an empty collection when no folders or files are provided', function (): void {
        $files = $this->fileCollectorService->collectFiles();

        expect($files)->toBeInstanceOf(\Illuminate\Support\Collection::class)
            ->and($files->count())->toBe(0);
    });
});
