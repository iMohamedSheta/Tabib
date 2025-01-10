<?php

namespace App\Http\Requests\Clinic;

use App\Enums\Clinic\ClinicTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateClinicRequest extends FormRequest
{
    public function rules(): array
    {
        return array_merge($this->stepOneRules(), $this->stepTwoRules(), $this->stepThreeRules());
    }

    public function stepOneRules(): array
    {
        return [
            'name' => ['required', 'string'],
            'type' => ['required', 'in:' . implode(',', $this->getClinicTypesArray())],
            'policy' => ['required', 'boolean', 'in:' . true],
        ];
    }

    public function stepTwoRules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/^01[0125][0-9]{8}$/'],
        ];
    }

    public function stepThreeRules(): array
    {
        return [
            'username' => ['required', 'string', 'regex:/^[a-z0-9_-]{3,15}$/', 'unique:users,username'],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ];
    }

    private function getClinicTypesArray(): array
    {
        return array_map(fn ($case) => $case->value, ClinicTypeEnum::cases());
    }
}
