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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Redirect After Login based on type
Route::get('/auth/app/redirect', function() {
    return redirect(UserRoleEnum::authRedirectRouteBasedOnType());
})->name('auth.app.redirect');

Route::get('/', function() {
    if (Auth::check()) {
        return to_route('auth.app.redirect');
    }
    return to_route('register');
});


Route::get('/auth/google/redirect', [GoogleSocialiteController::class, 'redirect'])->name('socialite.google.redirect');
Route::get('/auth/google/callback', [GoogleSocialiteController::class, 'callback']);

Route::get('/auth/facebook/redirect', [FacebookSocialiteController::class, 'redirect'])->name('socialite.facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookSocialiteController::class, 'callback']);
