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

use App\Enums\User\UserRoleEnum;
use App\Livewire\App\Calendar\Calendar;
use App\Livewire\App\Clinic\ClinicTable;
use App\Livewire\App\ClinicService\ClinicServiceTable;
use App\Livewire\App\Doctor\DoctorTable;
use App\Livewire\App\Patient\PatientTable;
use App\Livewire\App\Queue\QueueTable;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    // 'verified',
])->group(function ()
{
    // #Redirects - After Login based on type
    Route::get('/auth/app/redirect', function() {
        return redirect(UserRoleEnum::authRedirectRouteBasedOnType());
    })->name('auth.app.redirect');

    Route::get('dashboard', function ()
    {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('clinic')->name('clinic.')->group(function(){
        Route::get('', ClinicTable::class)->name('index');
    });

    Route::prefix('doctor')->name('doctor.')->group(function(){
        Route::get('', DoctorTable::class)->name('index');
    });

    Route::prefix('patient')->name('patient.')->group(function(){
        Route::get('', PatientTable::class)->name('index');
    });

    Route::prefix('calendar')->name('calendar.')->group(function(){
        Route::get('', Calendar::class)->name('index');
    });

    Route::prefix('queue')->name('queue.')->group(function(){
        Route::get('', QueueTable::class)->name('index');
    });

    Route::prefix('clinic/service')->name('clinic.service.')->group(function(){
        Route::get('', ClinicServiceTable::class)->name('index');
    });
});

