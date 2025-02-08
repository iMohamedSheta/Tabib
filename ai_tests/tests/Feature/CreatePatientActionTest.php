<?php

use App\Actions\Patient\CreatePatientAction;
use App\DTOs\Patient\CreatePatientDTO;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->action = app(CreatePatientAction::class);

    // Mock Gate::allows to return true by default, override in specific tests if needed
    Gate::shouldReceive('allows')->with('create', Patient::class)->andReturn(true);
});

describe('CreatePatientAction', function () {
    it('successfully creates a patient', function () {
        // Arrange
        $userData = [
            'username' => 'testuser',
            'password' => 'password',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '1234567890',
            'role' => Patient::class,
        ];

        $patientData = [
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
        ];

        $createPatientDTO = new CreatePatientDTO(
            username: $userData['username'],
            password: $userData['password'],
            first_name: $userData['first_name'],
            last_name: $userData['last_name'],
            phone: $userData['phone'],
            gender: $patientData['gender'],
            date_of_birth: $patientData['date_of_birth'],
            photo: null // Provide a mock UploadedFile if needed
        );

        // Act
        $response = $this->action->handle($createPatientDTO);

        // Assert
        expect($response->isSuccess())->toBeTrue();
        expect($response->message)->toBe('تم انشاء المريض بنجاح');

        $user = User::where('username', 'testuser')->first();
        expect($user)->not()->toBeNull();
        expect($user->first_name)->toBe('Test');

        $patient = Patient::where('user_id', $user->id)->first();
        expect($patient)->not()->toBeNull();
        expect($patient->gender)->toBe('male');
        expect($patient->date_of_birth->format('Y-m-d'))->toBe('2000-01-01');

        $this->assertDatabaseHas('users', ['username' => 'testuser']);
        $this->assertDatabaseHas('patients', ['user_id' => $user->id]);
    });

    it('handles authorization failure', function () {
        // Arrange
        Gate::shouldReceive('allows')->with('create', Patient::class)->andReturn(false);
        $userData = [
            'username' => 'testuser',
            'password' => 'password',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '1234567890',
            'role' => Patient::class,
        ];

        $patientData = [
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
        ];

        $createPatientDTO = new CreatePatientDTO(
            username: $userData['username'],
            password: $userData['password'],
            first_name: $userData['first_name'],
            last_name: $userData['last_name'],
            phone: $userData['phone'],
            gender: $patientData['gender'],
            date_of_birth: $patientData['date_of_birth'],
            photo: null
        );

        // Act
        $response = $this->action->handle($createPatientDTO);

        // Assert
        expect($response->isSuccess())->toBeFalse();
        expect($response->message)->toBe('غير مسموح لك باضافة المريض!!');
    });

    it('handles database transaction failure', function () {
        // Arrange

        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('rollBack')->once();
        DB::shouldReceive('commit')->never();

        User::shouldReceive('create')->andThrow(new Exception('Database error'));

        $userData = [
            'username' => 'testuser',
            'password' => 'password',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '1234567890',
            'role' => Patient::class,
        ];

        $patientData = [
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
        ];

        $createPatientDTO = new CreatePatientDTO(
            username: $userData['username'],
            password: $userData['password'],
            first_name: $userData['first_name'],
            last_name: $userData['last_name'],
            phone: $userData['phone'],
            gender: $patientData['gender'],
            date_of_birth: $patientData['date_of_birth'],
            photo: null // Provide a mock UploadedFile if needed
        );

        // Act
        $response = $this->action->handle($createPatientDTO);

        // Assert
        expect($response->isSuccess())->toBeFalse();
        expect($response->message)->toBe('حدث خطأ في عملية أنشاء الطبيب، الرجاء المحاولة لاحقاً');
    });

    it('can create a patient with a profile photo', function () {
        Storage::fake('public');
        $photo = UploadedFile::fake()->image('avatar.jpg');

        $userData = [
            'username' => 'testuser',
            'password' => 'password',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '1234567890',
            'role' => Patient::class,
        ];

        $patientData = [
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
        ];

        $createPatientDTO = new CreatePatientDTO(
            username: $userData['username'],
            password: $userData['password'],
            first_name: $userData['first_name'],
            last_name: $userData['last_name'],
            phone: $userData['phone'],
            gender: $patientData['gender'],
            date_of_birth: $patientData['date_of_birth'],
            photo: $photo
        );

        $response = $this->action->handle($createPatientDTO);

        expect($response->isSuccess())->toBeTrue();

        $user = User::where('username', 'testuser')->first();
        expect($user)->not()->toBeNull();
        Storage::disk('public')->assertExists('profile-photos/' . $photo->hashName());
    });
});
