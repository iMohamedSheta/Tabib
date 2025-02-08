<?php

use App\Exceptions\BackupExceptions\HasNoValidBackupFileException;
use App\Jobs\Backups\VerifyBackupsAreRecentJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;


use function Pest\Faker\fake;


beforeEach(function (): void {
    Storage::fake('google');
    $this->job = new VerifyBackupsAreRecentJob();
});

it('successfully handles the job when a recent backup exists', function (): void {
    $now = Carbon::now();
    $filePath = 'backups/latest.zip';

    Storage::disk('google')->put($filePath, 'backup content');

    $file = new class($filePath, $now->timestamp) extends FileAttributes {
        public function __construct(private string $path, private int $timestamp) {}

        public function path(): string
        {
            return $this->path;
        }

        public function lastModified(): int
        {
            return $this->timestamp;
        }
    };

    Storage::shouldReceive('disk->listContents')
        ->once()
        ->with('/', true)
        ->andReturn([$file]);

    $this->job->handle();

    expect(true)->toBeTrue();
});

it('logs an error when no valid backup file is found', function (): void {
    Storage::shouldReceive('disk->listContents')
        ->once()
        ->with('/', true)
        ->andReturn([]);

    Log::shouldReceive('error')
        ->once()
        ->with(Mockery::type(HasNoValidBackupFileException::class));

    $this->job->handle();
});

it('checks if the backup is stale', function (): void {
    $staleTime = Carbon::now()->subHours(2);
    $filePath = 'backups/old.zip';

    Storage::disk('google')->put($filePath, 'old backup content');

     $file = new class($filePath, $staleTime->timestamp) extends FileAttributes {
        public function __construct(private string $path, private int $timestamp) {}

        public function path(): string
        {
            return $this->path;
        }

        public function lastModified(): int
        {
            return $this->timestamp;
        }
    };

    Storage::shouldReceive('disk->listContents')
        ->once()
        ->with('/', true)
        ->andReturn([$file]);

    // Mock log error method
    Log::shouldReceive('error')->once();

    $this->job->handle();

    expect(true)->toBeTrue();
});
