<?php

namespace App\Jobs\Backups;

use App\Exceptions\BackupExceptions\HasNoValidBackupFileException;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileAttributes;

class CheckIfBackupsAreTaken implements ShouldQueue
{
    use Queueable;

    protected $minimumBackupInterval = 3600;
    protected $latestBackupFile = null;
    protected $latestBackupTime = null;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $files = Storage::disk('google')->listContents('/', true);

            foreach ($files as $file) {
                if ($file->isFile()) {
                    $fileModifiedTime = Carbon::parse($file->lastModified());

                    // Identify the most recently modified file
                    if (!$this->latestBackupTime || $fileModifiedTime->greaterThan($this->latestBackupTime)) {
                        $this->latestBackupTime = $fileModifiedTime;
                        $this->latestBackupFile = $file;
                    }
                }
            }

            // Return false if no file was found
            throw_if($this->hasNoValidBackupFile(),  new HasNoValidBackupFileException());

            // Check if the backup hasn't been taken in the specified interval
            if ($this->isBackupStale()) {
                // TODO Dispatch Notification
            }
        } catch (HasNoValidBackupFileException $e) {
            log_error($e);
        } catch (Exception $e) {
            log_error($e);
        }
    }

    private function hasNoValidBackupFile(): bool
    {
        return is_null($this->latestBackupFile) || !($this->latestBackupFile instanceof FileAttributes);
    }

    private function isBackupStale(): bool
    {
        return ($this->latestBackupTime->diffInSeconds(Carbon::now()) > $this->minimumBackupInterval);
    }
}
