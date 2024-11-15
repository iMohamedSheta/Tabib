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

use App\Enums\User\UserRoleEnum;
use App\Http\Controllers\Auth\Socialite\FacebookSocialiteController;
use App\Http\Controllers\Auth\Socialite\GoogleSocialiteController;
use App\Http\Controllers\PWA\LaravelPWAController;
use App\Models\Patient;
use App\Proxy\Query\DoctorQueryProxy;
use App\Services\User\GetProfilePhotoUrlService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

#Redirects - After Login based on type
Route::get('/auth/app/redirect', function() {
    return redirect(UserRoleEnum::authRedirectRouteBasedOnType());
})->name('auth.app.redirect');

# Home
Route::get('/', function() {
    if (Auth::check()) {
        return to_route('auth.app.redirect');
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


