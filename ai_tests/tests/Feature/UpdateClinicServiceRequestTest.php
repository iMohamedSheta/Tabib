<?php

use App\Http\Requests\ClinicService\UpdateClinicServiceRequest;
use Illuminate\Support\Facades\Validator;


    it('validates name as required string', function () {
        $data = ['name' => null];
        $rules = (new UpdateClinicServiceRequest([]))->rules();
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('name'))->toBeTrue();
    });

    it('validates price as required numeric', function () {
        $data = ['price' => null];
        $rules = (new UpdateClinicServiceRequest([]))->rules();
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('price'))->toBeTrue();

        $data = ['price' => 'abc'];
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('price'))->toBeTrue();
    });

    it('validates clinic_id as nullable and in array of clinicsIds', function () {
        $clinicsIds = [1, 2, 3];
        $request = new UpdateClinicServiceRequest($clinicsIds);
        $rules = $request->rules();

        $data = ['clinic_id' => 4];
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('clinic_id'))->toBeTrue();

        $data = ['clinic_id' => null];
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeFalse();
    });

    it('validates description as nullable string', function () {
        $data = ['description' => 123];
        $rules = (new UpdateClinicServiceRequest([]))->rules();
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeFalse();

        $data = ['description' => null];
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeFalse();
    });

    it('validates color as nullable string', function () {
        $data = ['color' => 123];
        $rules = (new UpdateClinicServiceRequest([]))->rules();
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeFalse();

        $data = ['color' => null];
        $validator = Validator::make($data, $rules);

        expect($validator->fails())->toBeFalse();
    });
