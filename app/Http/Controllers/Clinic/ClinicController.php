<?php

namespace App\Http\Controllers\Clinic;

use App\Enums\User\UserRoleEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        return view("app.backend.clinic.index");
    }
}
