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
use App\Livewire\App\Ai\Prompt;
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
])->group(function (): void {
    Route::get('/auth/app/redirect', fn () => redirect(UserRoleEnum::authRedirectRouteBasedOnType()))->name('app.admin.auth.app.redirect');

    Route::get('dashboard', fn () => view('dashboard'))->name('app.admin.dashboard');

    Route::prefix('clinic')->group(function (): void {
        Route::get('', ClinicTable::class)->name('app.admin.clinic.index');
    });

    Route::prefix('doctor')->group(function (): void {
        Route::get('', DoctorTable::class)->name('app.admin.doctor.index');
    });

    Route::prefix('patient')->group(function (): void {
        Route::get('', PatientTable::class)->name('app.admin.patient.index');
        Route::get('show/{patient}', ShowPatient::class)->name('app.admin.patient.show');
    });

    Route::prefix('calendar')->group(function (): void {
        Route::get('', Calendar::class)->name('app.admin.calendar.index');
    });

    Route::prefix('queue')->group(function (): void {
        Route::get('', QueueTable::class)->name('app.admin.queue.index');
    });

    Route::prefix('clinic/service')->group(function (): void {
        Route::get('', ClinicServiceTable::class)->name('app.admin.clinic.service.index');
    });

    Route::prefix('ai/prompt')->group(function (): void {
        Route::get('', Prompt::class)->name('app.admin.ai.prompt.index');
    });
});
