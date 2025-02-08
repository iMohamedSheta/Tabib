<?php

use App\Services\Internal\Ai\AiFileGenerationService;
use App\Services\Internal\Collector\FileCollectorService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

uses(Tests\TestCase::class)->in('Feature');

beforeEach(function () {
    $this->fileCollectorService = Mockery::mock(FileCollectorService::class);
    $this->aiFileGenerationService = Mockery::mock(AiFileGenerationService::class);

    $this->app->bind(FileCollectorService::class, function () {
        return $this->fileCollectorService;
    });
    $this->app->bind(AiFileGenerationService::class, function () {
        return $this->aiFileGenerationService;
    });

    Storage::fake('ai_tests');
});

it('displays an error message when no files are found', function () {
    $this->fileCollectorService->shouldReceive('collectFiles')
        ->once()
        ->with(null, null)
        ->andReturn(collect([]));

    Artisan::call('ai:generate')
        ->expectsOutput('No files found in any of the specified folders.')
        ->assertExitCode(0);
});

it('displays the total number of files found', function () {
    $files = collect(['file1.php', 'file2.php']);
    $this->fileCollectorService->shouldReceive('collectFiles')
        ->once()
        ->with(null, null)
        ->andReturn($files);

    $this->aiFileGenerationService->shouldReceive('processFiles')
        ->once()
        ->with($files, 'TEST_GENERATOR', 5)
        ->andReturn([]);

    Artisan::call('ai:generate')
        ->expectsOutput('Total files found: 2')
        ->assertExitCode(0);
});

it('processes files successfully and displays a success message', function () {
    $files = collect(['file1.php', 'file2.php']);
    $this->fileCollectorService->shouldReceive('collectFiles')
        ->once()
        ->with(null, null)
        ->andReturn($files);

    $this->aiFileGenerationService->shouldReceive('processFiles')
        ->once()
        ->with($files, 'TEST_GENERATOR', 5)
        ->andReturn(['response1', 'response2']);

    Artisan::call('ai:generate')
        ->expectsOutput('AI generation completed successfully.')
        ->assertExitCode(0);
});

it('processes files but all fail and return failure message', function () {
    $files = collect(['file1.php', 'file2.php']);
    $this->fileCollectorService->shouldReceive('collectFiles')
        ->once()
        ->with(null, null)
        ->andReturn($files);

    $this->aiFileGenerationService->shouldReceive('processFiles')
        ->once()
        ->with($files, 'TEST_GENERATOR', 5)
        ->andReturn([]);

    Artisan::call('ai:generate')
        ->expectsOutput('AI generation failed for all file chunks.')
        ->assertExitCode(0);
});

it('accepts folders and system-prompt options', function () {
    $folders = 'app\Folder1,app\Folder2';
    $systemPrompt = 'CUSTOM_PROMPT';

    $files = collect(['file1.php', 'file2.php']);
    $this->fileCollectorService->shouldReceive('collectFiles')
        ->once()
        ->with($folders, null)
        ->andReturn($files);

    $this->aiFileGenerationService->shouldReceive('processFiles')
        ->once()
        ->with($files, $systemPrompt, 5)
        ->andReturn(['response1', 'response2']);

    Artisan::call('ai:generate', [
        '--folders' => $folders,
        '--system-prompt' => $systemPrompt,
    ])
        ->expectsOutput('AI generation completed successfully.')
        ->assertExitCode(0);
});

it('accepts files and chunk-size options', function () {
    $filesInput = 'app/File1.php,app/File2.php';

    $files = collect(['file1.php', 'file2.php']);
    $this->fileCollectorService->shouldReceive('collectFiles')
        ->once()
        ->with(null, $filesInput)
        ->andReturn($files);

    $this->aiFileGenerationService->shouldReceive('processFiles')
        ->once()
        ->with($files, 'TEST_GENERATOR', 2)
        ->andReturn(['response1', 'response2']);

    Artisan::call('ai:generate', [
        '--files' => $filesInput,
        '--chunk-size' => 2,
    ])
        ->expectsOutput('AI generation completed successfully.')
        ->assertExitCode(0);
});
