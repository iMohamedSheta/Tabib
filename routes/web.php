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
use App\Exceptions\Test\TestException;
use App\Http\Controllers\Auth\Socialite\FacebookSocialiteController;
use App\Http\Controllers\Auth\Socialite\GoogleSocialiteController;
use App\Http\Controllers\PWA\LaravelPWAController;
use App\Models\Patient;
use App\Proxy\Query\DoctorQueryProxy;
use App\Services\User\GetProfilePhotoUrlService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


# Home
Route::get('/', function() {
    if (Auth::check()) {
        return redirect(UserRoleEnum::authRedirectRouteBasedOnType());
    }
    return to_route('register');
});

# PWA
Route::group(['as' => 'laravelpwa.'], function()
{
    // Instead of using the file generate file every time with the updated version from the laravelpwa config
    Route::get('/manifest.json', [LaravelPWAController::class, 'manifestJson'])->name('manifest');
    Route::get('offline', [LaravelPWAController::class, 'offline']);
});

# OAuth Socialite
Route::get('/auth/google/redirect', [GoogleSocialiteController::class, 'redirect'])->name('socialite.google.redirect');
Route::get('/auth/google/callback', [GoogleSocialiteController::class, 'callback']);

Route::get('/auth/facebook/redirect', [FacebookSocialiteController::class, 'redirect'])->name('socialite.facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookSocialiteController::class, 'callback']);




# Test Routes
Route::get('test', function() {
    flash()->success('User saved successfully!');
    sweetalert()->error('There was an issue locking your account.');

    return to_route('register');
});

Route::get('speed', function () {
    return speedTest(function () {
        return  DB::table('users')
                    ->where('role', Patient::class)
                    ->where(function ($query) {
                        $query->likeIn(['first_name', 'last_name', 'phone', 'other_phone'], 'i');
                    })
                    ->take(5)
                    ->get();
    }, 1000);
});

Route::view('testx', 'welcome');


Route::get('/test', function () {
    throw TestException::exception();
    // throw \Exception('Hello world');
    // trhow
});

Route::get('docs/exceptions/{code}', function ($code) {
    $code = ExceptionCodeEnum::from($code);
    dd($code->getLink());
})->name('docs.exceptions');
