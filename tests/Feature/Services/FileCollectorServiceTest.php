<?php

use App\Services\Internal\Collector\FileCollectorService;
use Illuminate\Support\Facades\File;

describe('FileCollectorService [Service]', function (): void {
    beforeEach(function (): void {
        $this->service = new FileCollectorService();

        // Create dummy files and folders for testing
        File::ensureDirectoryExists(base_path('test_folder'));
        File::put(base_path('test_file.txt'), 'test content');
        File::put(base_path('test_folder/file1.txt'), 'file1 content');
        File::put(base_path('test_folder/file2.txt'), 'file2 content');
        File::ensureDirectoryExists(base_path('test_folder_empty'));
    });

    afterEach(function (): void {
        // Clean up dummy files and folders
        File::delete(base_path('test_file.txt'));
        File::deleteDirectory(base_path('test_folder'));
        File::deleteDirectory(base_path('test_folder_empty'));
    });

    it('collects specified files', function (): void {
        $files = $this->service->collectFiles(filesInput: 'test_file.txt');

        expect($files)->toHaveCount(1);
        expect($files->first())->toBeInstanceOf(SplFileInfo::class);
        expect($files->first()->getRealPath())->toBe(base_path('test_file.txt'));
    });

    it('collects files from specified folders', function (): void {
        $files = $this->service->collectFiles(foldersInput: 'test_folder');
        expect($files->toArray())->toHaveCount(2);

        $filePaths = $files
            ->map(fn ($file) => str_replace('\\', '/', $file->getRealPath()))
            ->toArray();

        $expectedFile1 = str_replace('\\', '/', base_path('test_folder/file1.txt'));
        $expectedFile2 = str_replace('\\', '/', base_path('test_folder/file2.txt'));

        expect($filePaths)->toContain($expectedFile1);
        expect($filePaths)->toContain($expectedFile2);
    });

    it('collects files from both files and folders', function (): void {
        $files = $this->service->collectFiles(foldersInput: 'test_folder', filesInput: 'test_file.txt');
        expect($files)->toHaveCount(3);

        $filePaths = $files
            ->map(fn ($file) => str_replace('\\', '/', $file->getRealPath()))
            ->toArray();

        $expectedFile1 = str_replace('\\', '/', base_path('test_folder/file1.txt'));
        $expectedFile2 = str_replace('\\', '/', base_path('test_folder/file2.txt'));
        $expectedFile3 = str_replace('\\', '/', base_path('test_file.txt'));

        expect($filePaths)->toContain($expectedFile1);
        expect($filePaths)->toContain($expectedFile2);
        expect($filePaths)->toContain($expectedFile3);
    });

    it('handles missing files or folders without errors', function (): void {
        $files = $this->service->collectFiles(foldersInput: 'non_existing_folder', filesInput: 'non_existing_file.txt');
        expect($files)->toBeEmpty();

        $files = $this->service->collectFiles(foldersInput: 'test_folder,non_existing_folder', filesInput: 'test_file.txt,non_existing_file.txt');
        expect($files)->toHaveCount(3);
    });

    it('removes duplicate files', function (): void {
        $files = $this->service->collectFiles(foldersInput: 'test_folder', filesInput: 'test_folder/file1.txt,test_file.txt');
        expect($files)->toHaveCount(3);

        $filePaths = $files
            ->map(fn ($file) => str_replace('\\', '/', $file->getRealPath()))
            ->toArray();

        $expectedFile1 = str_replace('\\', '/', base_path('test_folder/file1.txt'));
        $expectedFile2 = str_replace('\\', '/', base_path('test_folder/file2.txt'));
        $expectedFile3 = str_replace('\\', '/', base_path('test_file.txt'));

        expect($filePaths)->toContain($expectedFile1);
        expect($filePaths)->toContain($expectedFile2);
        expect($filePaths)->toContain($expectedFile3);
    });

    it('handles empty folder', function (): void {
        $files = $this->service->collectFiles(foldersInput: 'test_folder_empty');
        expect($files)->toBeEmpty();
    });

    it('handles empty inputs', function (): void {
        $files = $this->service->collectFiles();
        expect($files)->toBeEmpty();
    });
});
