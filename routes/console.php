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
