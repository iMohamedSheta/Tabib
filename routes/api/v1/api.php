<?php

/*
|------------------------------------------
|  Clinic Admin Routes :
|------------------------------------------
|   Prefix      =>  'api/v1'
|   Name        =>   N/A
|   Example     =>   N/A
|__________________________________________
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
