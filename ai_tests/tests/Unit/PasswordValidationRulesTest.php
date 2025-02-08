<?php

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

uses(Tests\TestCase::class);


describe('PasswordValidationRules', function () {
    uses(PasswordValidationRules::class);

    it('contains required rule', function () {
        $rules = $this->passwordRules();
        expect($rules)->toContain('required');
    });

    it('contains string rule', function () {
        $rules = $this->passwordRules();
        expect($rules)->toContain('string');
    });

    it('contains confirmed rule', function () {
        $rules = $this->passwordRules();
        expect($rules)->toContain('confirmed');
    });

    it('contains a default Password rule instance', function () {
        $rules = $this->passwordRules();
        $hasPasswordRule = false;
        foreach ($rules as $rule) {
            if ($rule instanceof Password) {
                $hasPasswordRule = true;
                break;
            }
        }
        expect($hasPasswordRule)->toBeTrue();
    });

    it('validates a password successfully', function () {
        $password = 'P@$$wOrd';
        $rules = $this->passwordRules();

        $validator = Validator::make(['password' => $password, 'password_confirmation' => $password], ['password' => $rules]);
        expect($validator->passes())->toBeTrue();
    });

    it('fails validation if password does not meet requirements', function () {
        $password = 'password';
        $rules = $this->passwordRules();
        $validator = Validator::make(['password' => $password, 'password_confirmation' => $password], ['password' => $rules]);
        expect($validator->fails())->toBeTrue();
    });

    it('fails validation if password confirmation does not match', function () {
        $password = 'P@$$wOrd';
        $rules = $this->passwordRules();
        $validator = Validator::make(['password' => $password, 'password_confirmation' => 'differentPassword'], ['password' => $rules]);
        expect($validator->fails())->toBeTrue();
    });
});
