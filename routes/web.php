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

use App\Enums\Ai\AiModelEnum;
use App\Enums\Exceptions\ExceptionCodeEnum;
use App\Enums\User\UserRoleEnum;
use App\Generators\ClinicCodeGenerator;
// use App\Exceptions\Test\TestException;
use App\Generators\PUIDGenerator;
use App\Http\Controllers\Auth\Socialite\FacebookSocialiteController;
use App\Http\Controllers\Auth\Socialite\GoogleSocialiteController;
use App\Http\Controllers\PWA\LaravelPWAController;
use App\Http\Controllers\Storage\PrivateStorageController;
use App\Models\Patient;
use App\Services\HuggingFaceService;
use App\Services\Internal\VideoStream;
use Carbon\Carbon;
use EchoLabs\Prism\Prism;
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

Route::name('storage.private.tmp.')
    ->prefix('storage/private/')
    ->group(function (): void {
        Route::get('/media/{encryptedMedia}', [PrivateStorageController::class, 'showMedia'])->name('media');
        Route::get('profile_picture/{profilePhotoPath}', [PrivateStorageController::class, 'showProfilePicture'])->name('profile_picture');
    });

Route::get('files', function (): void {
    $command = 'bash testcommand.sh';

    $descriptor = [
        ['pipe', 'r'],
        ['pipe', 'w'],
        ['pipe', 'w'],
    ];

    $process = proc_open($command, $descriptor, $pipes);

    while (!feof($pipes[1])) {
        $line = fgets($pipes[1]);
        if (false !== $line) {
            echo $line . '\n';
        }
    }

    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);
});

// Route::get('video/steamed', function () {
//     $videosDir = storage_path('app/private');

//     $filename = 'sasaasa.mp4';

//     if (file_exists($filePath = $videosDir . "/" . $filename)) {

//         $stream = new VideoStream($filePath);

//         return response()->stream(function () use ($stream) {
//             $stream->start();
//         });
//     }
// })->name('video.streamed');

Route::get('ai', function (): void {
    // ->withSystemPrompt('You are an AI assistant for a SaaS company called "كونكت فور عرب" (Connect for Arab) that provides solutions for network administrators in Egypt. Your primary role is to assist network admins with their networks by:
    //     Creating a cloud-based RADIUS server for authentication and authorization.
    //     Setting up VPN connections to securely connect to their networks.
    //     Helping them manage billing and access their network devices remotely.
    //     Assisting with AAA (Authentication, Authorization, and Accounting) for their users.
    //     You communicate fluently in Arabic to guide and support the network administrators effectively.

    //     ')
    $prism = Prism::text()
        ->withSystemPrompt('
        You are an AI assistant for a SaaS company called "مدكلينكس" (MedClinux) that provides solutions for clinics, doctors, nurses, and clinic managers in Egypt. Your primary role is to assist doctors and clinic managers with their patients by:
    
        You communicate fluently in Arabic to guide and support the doctors and clinic managers effectively.
    
        Your capabilities include:
        1. **Patient Management**: Help doctors and clinic managers manage patient records, appointments, and treatment plans.
        2. **Appointment Scheduling**: Assist in scheduling or rescheduling appointments based on availability.
        3. **Medication Guidance**: Provide guidance on prescriptions and treatment plans.
        4. **Reporting and Analytics**: Generate detailed reports on patient statistics and clinic performance.
        5. **Arabic Communication**: Communicate fluently in Arabic with Egyptian clinics and healthcare professionals.
        6. **Regulatory Compliance**: Ensure all suggestions comply with Egyptian medical regulations and standards.
    ')
        ->using('custom.gemini_sssssssssssssssssssssssss', AiModelEnum::GEMINI_2_0_FLASH_EXP->value)
        ->usingProviderConfig([
            'temperature' => 1,
            'topK' => 40,
            'topP' => 0.95,
            'maxOutputTokens' => 8192,
            'responseMimeType' => 'text/plain',
        ])
        ->withPrompt('مرحبا المريض يشتكي من حساسية مفرطة في الرقبة ماذا قد يكون سبب ذالك؟');

    // Log the request payload

    $response = $prism->generate();

    dd($response->text);
});

Route::get('hugging-face', function (): void {
    $inputText = 'is hugging face free or not';
    $huggingFaceService = new HuggingFaceService();

    $result = $huggingFaceService->generateText($inputText);

    dd($result);
});

Route::get('test', fn() => view('test'));
