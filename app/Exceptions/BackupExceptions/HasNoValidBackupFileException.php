<?php

namespace App\Exceptions\BackupExceptions;

use Exception;

class HasNoValidBackupFileException extends Exception
{
    protected $message = 'There is no valid backup file available.';
}
