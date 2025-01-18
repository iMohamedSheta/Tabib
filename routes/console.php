<?php

/*
|------------------------------------------
|  Commands Routes :
|------------------------------------------
|   Prefix      =>   N/A
|   Name        =>   N/A
|   Example     =>   N/A
|__________________________________________
*/

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('files', function (): void {
    $command = 'bash testcommand.sh';

    $descriptor = [
        ['pipe', 'r'],
        ['pipe', 'w'],
        ['pipe', 'w'],
    ];

    $process = proc_open($command, $descriptor, $pipes);

    while (!feof($pipes[1])) {
        $line = fgets($pipes[1]);
        if (false !== $line) {
            echo trim($line) . PHP_EOL;
        }
    }

    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);
})->purpose('Display an inspiring quote')->hourly();
