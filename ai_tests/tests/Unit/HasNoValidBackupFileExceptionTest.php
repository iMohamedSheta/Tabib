<?php

use App\Exceptions\BackupExceptions\HasNoValidBackupFileException;

it('can be instantiated', function () {
    $exception = new HasNoValidBackupFileException();

    expect($exception)->toBeInstanceOf(HasNoValidBackupFileException::class);
});

it('has a default message', function () {
    $exception = new HasNoValidBackupFileException();

    expect($exception->getMessage())->toBe('There is no valid backup file available.');
});

it('can override the default message', function () {
    $customMessage = 'Custom exception message.';
    $exception = new HasNoValidBackupFileException($customMessage);

    expect($exception->getMessage())->toBe($customMessage);
});
