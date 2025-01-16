<?php

/*
|------------------------------------------
|  Web Mix (guest, app) Routes :
|------------------------------------------
|   Prefix      =>   N/A
|   Name        =>   N/A
|   Example     =>   N/A
|__________________________________________
*/

use App\Enums\Exceptions\ExceptionCodeEnum;
use App\Enums\User\UserRoleEnum;
use App\Generators\ClinicCodeGenerator;
// use App\Exceptions\Test\TestException;
use App\Generators\PUIDGenerator;
use App\Http\Controllers\Auth\Socialite\FacebookSocialiteController;
use App\Http\Controllers\Auth\Socialite\GoogleSocialiteController;
use App\Http\Controllers\PWA\LaravelPWAController;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileAttributes;

// Home
Route::get('/', function () {
    if (Auth::check()) {
        return redirect(UserRoleEnum::authRedirectRouteBasedOnType());
    }

    return to_route('register');
});

// PWA
Route::group(['as' => 'laravelpwa.'], function (): void {
    // Instead of using the file generate file every time with the updated version from the laravelpwa config
    Route::get('/manifest.json', [LaravelPWAController::class, 'manifestJson'])->name('manifest');
    Route::get('offline', [LaravelPWAController::class, 'offline']);
});

// OAuth Socialite
Route::get('/auth/google/redirect', [GoogleSocialiteController::class, 'redirect'])->name('socialite.google.redirect');
Route::get('/auth/google/callback', [GoogleSocialiteController::class, 'callback']);

Route::get('/auth/facebook/redirect', [FacebookSocialiteController::class, 'redirect'])->name('socialite.facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookSocialiteController::class, 'callback']);

Route::get('welcome', fn () => view('welcome'));

// Test Routes
Route::get('test', function () {
    flash()->success('User saved successfully!');
    sweetalert()->error('There was an issue locking your account.');

    return to_route('register');
});

Route::get('speed', fn (): array => speedTest(fn () => DB::table('users')
    ->where('role', Patient::class)
    ->where(function ($query): void {
        $query->likeIn(['first_name', 'last_name', 'phone', 'other_phone'], 'i');
    })
    ->take(5)
    ->get(), 1000));

Route::view('testx', 'welcome');

// Route::get('/test', function (): void {
//     throw TestException::exception();
//     // throw \Exception('Hello world');
//     // trhow
// });

// Route::get('docs/exceptions/{code}', function ($code): void {
//     $code = ExceptionCodeEnum::from($code);
//     dd($code->getLink());
// })->name('docs.exceptions');

Route::get('check', fn (): string => PUIDGenerator::generate());
Route::get('check-2', fn (): string => ClinicCodeGenerator::generate());

// Route::get('test', function () {
//     $yamlFile = base_path('.github/workflows/tabib_pushflow.yml');
//     $fileContent = file_get_contents($yamlFile);
//     dd($fileContent);
// });

Route::get('/test-google-drive', function (): false|string {
    try {
        $minimumBackupInterval = 3600; // seconds

        $latestBackupFile = null;
        $latestBackupTime = null;

        $files = Storage::disk('google')->listContents('/', true);

        foreach ($files as $file) {
            if ($file->isFile()) {
                $fileModifiedTime = Carbon::parse($file->lastModified());

                // Identify the most recently modified file
                if (!$latestBackupTime instanceof \Carbon\Carbon || $fileModifiedTime->greaterThan($latestBackupTime)) {
                    $latestBackupTime = $fileModifiedTime;
                    $latestBackupFile = $file;
                }
            }
        }

        // Return false if no file was found
        if (is_null($latestBackupFile) || !($latestBackupFile instanceof FileAttributes)) {
            return false;
        }

        // Calculate time difference from the current time
        $lastModifiedTime = Carbon::parse($latestBackupFile->lastModified());
        $timeSinceLastBackupInSeconds = $lastModifiedTime->diffInSeconds(Carbon::now());

        // Check if the backup hasn't been taken in the specified interval
        $backupIsStale = ($timeSinceLastBackupInSeconds > $minimumBackupInterval);

        $readableBackupTime = $lastModifiedTime->diffForHumans();

        // dd($backupIsStale, $readableBackupTime);
        return 'File uploaded successfully!';
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
