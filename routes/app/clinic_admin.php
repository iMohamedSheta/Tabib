<?php

/*
|------------------------------------------
|  Clinic Admin Routes :
|------------------------------------------
|   Prefix      =>  'admin'
|   Name        =>  'app.admin.'
|   Example     =>  'app.admin.dashboard'
|__________________________________________
*/

use App\Http\Controllers\Clinic\ClinicController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function ()
{
    Route::get('dashboard', function ()
    {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('clinic')->name('clinic.')->group(function(){
        Route::get('', [ClinicController::class, 'index'])->name('index');
    });
});

