<?php

use App\Http\Requests\Patient\CreatePatientRequest;
use Illuminate\Support\Facades\Validator;


beforeEach(function (): void {
    $this->clinicsIds = [1, 2, 3];
});

describe('validation rules', function () {
    it('should pass validation with valid data', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'clinic_id' => 1,
            'phone' => '01000000000',
            'gender' => 'male',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->passes())->toBeTrue();
    });

    it('should fail validation if first_name is missing', function () {
        $data = [
            'last_name' => 'Doe',
            'age' => 30,
            'clinic_id' => 1,
            'phone' => '01000000000',
            'gender' => 'male',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('first_name'))->toBeTrue();
    });

    it('should fail validation if last_name is missing', function () {
        $data = [
            'first_name' => 'John',
            'age' => 30,
            'clinic_id' => 1,
            'phone' => '01000000000',
            'gender' => 'male',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('last_name'))->toBeTrue();
    });

    it('should fail validation if age is missing', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'clinic_id' => 1,
            'phone' => '01000000000',
            'gender' => 'male',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('age'))->toBeTrue();
    });

    it('should fail validation if clinic_id is missing', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'phone' => '01000000000',
            'gender' => 'male',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('clinic_id'))->toBeTrue();
    });

    it('should fail validation if clinic_id is not in clinicsIds', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'clinic_id' => 4,
            'phone' => '01000000000',
            'gender' => 'male',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('clinic_id'))->toBeTrue();
    });

    it('should fail validation if phone is missing', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'clinic_id' => 1,
            'gender' => 'male',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('phone'))->toBeTrue();
    });

    it('should fail validation if gender is missing', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'clinic_id' => 1,
            'phone' => '01000000000',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('gender'))->toBeTrue();
    });

    it('should fail validation if gender is not in [male, female]', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'clinic_id' => 1,
            'phone' => '01000000000',
            'gender' => 'other',
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('gender'))->toBeTrue();
    });

    it('should pass validation for the photo if it is null', function () {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'clinic_id' => 1,
            'phone' => '01000000000',
            'gender' => 'male',
            'photo' => null
        ];

        $request = new CreatePatientRequest($this->clinicsIds);
        $validator = Validator::make($data, $request->rules());

        expect($validator->passes())->toBeTrue();
    });
});
