<?php

namespace App\Http\Controllers\PWA;

use App\Http\Controllers\Controller;
use App\Services\PWA\ManifestService;

class LaravelPWAController extends Controller
{
    public function manifestJson()
    {
        $output = (new ManifestService)->generate();

        return response()->json($output);
    }

    public function offline()
    {
        return view('vendor.laravelpwa.offline');
    }
}
