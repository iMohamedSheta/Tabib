<?php

namespace App\Exceptions\BackupExceptions;

class HasNoValidBackupFileException extends \Exception
{
    protected $message = 'There is no valid backup file available.';
}
