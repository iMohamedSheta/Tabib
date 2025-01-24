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
use App\Livewire\App\Patient\ShowPatient;
use App\Livewire\App\Queue\QueueTable;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    // 'verified',
])->group(function (): void {
    // #Redirects - After Login based on type
    Route::get('/auth/app/redirect', fn () => redirect(UserRoleEnum::authRedirectRouteBasedOnType()))->name('auth.app.redirect');

    Route::get('dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::prefix('clinic')->name('clinic.')->group(function (): void {
        Route::get('', ClinicTable::class)->name('index');
    });

    Route::prefix('doctor')->name('doctor.')->group(function (): void {
        Route::get('', DoctorTable::class)->name('index');
    });

    Route::prefix('patient')->name('patient.')->group(function (): void {
        Route::get('', PatientTable::class)->name('index');
        Route::get('show/{patient}', ShowPatient::class)->name('show');
    });

    Route::prefix('calendar')->name('calendar.')->group(function (): void {
        Route::get('', Calendar::class)->name('index');
    });

    Route::prefix('queue')->name('queue.')->group(function (): void {
        Route::get('', QueueTable::class)->name('index');
    });

    Route::prefix('clinic/service')->name('clinic.service.')->group(function (): void {
        Route::get('', ClinicServiceTable::class)->name('index');
    });
});
