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

use App\Enums\Ai\PromptTopicEnum;
use App\Enums\Exceptions\ExceptionCodeEnum;
use App\Enums\User\UserRoleEnum;
use App\Extractors\FileTextExtractor;
use App\Generators\ClinicCodeGenerator;
// use App\Exceptions\Test\TestException;
use App\Generators\PUIDGenerator;
use App\Http\Controllers\Auth\Socialite\FacebookSocialiteController;
use App\Http\Controllers\Auth\Socialite\GoogleSocialiteController;
use App\Http\Controllers\PWA\LaravelPWAController;
use App\Http\Controllers\Storage\PrivateStorageController;
use App\Models\Clinic;
use App\Models\Embedding;
use App\Models\Organization;
use App\Models\Patient;
use App\Services\External\Ai\Embedding\GenerateEmbeddingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileAttributes;
use Pgvector\Laravel\Distance;
use Pgvector\Laravel\SparseVector;
use Pgvector\Laravel\Vector;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

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
    Route::get('manifest.json', [LaravelPWAController::class, 'manifestJson'])->name('manifest');
    Route::get('offline', [LaravelPWAController::class, 'offline']);
});

// OAuth Socialite
Route::get('auth/google/redirect', [GoogleSocialiteController::class, 'redirect'])->name('socialite.google.redirect');
Route::get('auth/google/callback', [GoogleSocialiteController::class, 'callback'])->name('socialite.google.callback');

Route::get('auth/facebook/redirect', [FacebookSocialiteController::class, 'redirect'])->name('socialite.facebook.redirect');
Route::get('auth/facebook/callback', [FacebookSocialiteController::class, 'callback'])->name('socialite.facebook.callback');

Route::name('storage.private.tmp.')
    ->prefix('storage/private/')
    ->group(function (): void {
        Route::get('media/{encryptedMedia}', [PrivateStorageController::class, 'showMedia'])->name('media');
        Route::get('profile_picture/{profilePhotoPath}', [PrivateStorageController::class, 'showProfilePicture'])->name('profile_picture');
    });

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

Route::get('test-google-drive', function (): false|string {
    try {
        $minimumBackupInterval = 3600; // seconds

        $latestBackupFile = null;
        $latestBackupTime = null;

        $files = Storage::disk('google')->listContents('/', true);

        foreach ($files as $file) {
            if ($file->isFile()) {
                $fileModifiedTime = Carbon::parse($file->lastModified());

                // Identify the most recently modified file
                if (!$latestBackupTime instanceof Carbon || $fileModifiedTime->greaterThan($latestBackupTime)) {
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

Route::get('test', function () {
    $url = 'http://localhost:11434/api/generate';

    $response = Http::post($url, [
        'model' => 'Deepseek-R1:7B', // Use the correct model name
        'prompt' => 'Write a PHP function to connect to a database.',
        'stream' => false, // Set to true for streaming responses
    ]);

    return $response->json(); // Return response as JSON
});

// Route::get('a', fn() => PromptTopicEnum::PATIENT->prompt());
Route::get(
    'embedding',
    function (): string {
        $message = 'هل لديك مريض اسمه محمد يوسف شتا ؟';
        // $embeddingService = new GenerateEmbeddingService();
        // $queryVector = $embeddingService->handle($query);
        // // $magnitude = sqrt(array_sum(array_map(fn($val) => $val ** 2, $queryVector)));
        // // dd($magnitude);
        // // $results = Embedding::selectRaw('*, 1 - (embedding <#> ?) AS score', [$vector])
        // //     ->orderByDesc('score') // Higher similarity first
        // //     ->limit(100)
        // //     ->pluck('content')
        // //     ->toArray();
        // $results = Embedding::nearestNeighbors('embedding', new Vector($queryVector), Distance::InnerProduct)
        //     // ->orderByRaw('sparse_vector <#> ?', new SparseVector($queryVector, 30522))
        //     ->pluck('content')
        //     ->toArray();

        // // $results = Embedding::selectRaw('*, 1 - (sparse_vector <#> ?) AS score', [new SparseVector($queryVector, 30522)])
        // //     ->orderByDesc('score') // Higher similarity first
        // //     ->limit(100)
        // //     ->pluck('content')
        // //     ->toArray();

        $results = PromptTopicEnum::getSemanticTopic($message);

        // $exists = strpos($results, $message) !== false
        //     ? "{$message} does exist in the results."
        //     : "{$message} does not exist in the results!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";

        return $results;
    }
);

Route::get('patientseed', function (): void {
    $org = Organization::first();
    $clinic = Clinic::first();

    Patient::factory(500)->create([
        'organization_id' => $org->id,
        'clinic_id' => $clinic->id,
    ])->each(fn ($patient) => $patient->fireModelEvent('created', false)); // @phpstan-ignore-line
});

Route::get('totext', fn (): string => FileTextExtractor::extract(public_path('files/1.csv')));

Route::get('generator', function (): void {
    $inputFile = public_path('files/2.xlsx');
    $outputFile = public_path('files/ooooooooo.csv');
    $spreadsheet = IOFactory::load($inputFile);

    foreach ($spreadsheet->getSheetNames() as $index => $sheetName) {
        $spreadsheet->setActiveSheetIndex($index);

        $csvWriter = new Csv($spreadsheet);
        $csvWriter->setDelimiter(',');
        $csvWriter->setEnclosure('"');
        $csvWriter->setSheetIndex($index);

        $csvWriter->save($outputFile);
    }
});
