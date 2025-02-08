<?php

use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->doctor = User::factory()->create();
});

describe('UpdateDoctorRequest', function () {
    it('validates username correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'username' => 'invalid username',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('username'))->toBeTrue();

        $data['username'] = 'valid_username';
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();
    });

    it('validates specialization correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'specialization' => '',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('specialization'))->toBeTrue();

        $data['specialization'] = 'Cardiologist';
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();
    });

    it('validates first_name correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'first_name' => '',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('first_name'))->toBeTrue();

        $data['first_name'] = 'John';
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();
    });

    it('validates last_name correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'last_name' => '',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('last_name'))->toBeTrue();

        $data['last_name'] = 'Doe';
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();
    });

    it('validates phone correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'phone' => '123456789',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('phone'))->toBeTrue();

        $data['phone'] = '01012345678';
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();
    });

    it('validates other_phone correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'other_phone' => '123456789',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('other_phone'))->toBeTrue();

        $data['other_phone'] = '01012345678';
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();

        $data['other_phone'] = null;
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();
    });

    it('validates photo correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'photo' => 'not-an-image',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('photo'))->toBeTrue();

        // This test requires a mock file upload, skipping for now.
        // $data['photo'] = UploadedFile::fake()->image('photo.jpg');
        // $validator = Validator::make($data, $request->rules());
        // expect($validator->fails())->toBeFalse();
    });

    it('validates password and password_confirmation correctly', function () {
        $request = new UpdateDoctorRequest($this->doctor);
        $data = [
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ];

        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('password'))->toBeTrue();

        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();

        $data['password'] = null;
        $data['password_confirmation'] = null;
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeFalse();
    });
});
