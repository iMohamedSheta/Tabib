<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateDoctorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'regex:/^[a-z0-9_-]{3,15}$/', 'unique:users,username'],
            'password' => ['required', Password::default(),'string'],
            'specialization' => ['required', 'string'],
            // 'clinic_id' => ['required', 'in:'. implode(',', $this->clinics)],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'phone' => ['required', 'string',
            // 'regex:/^01[0125][0-9]{8}$/'
        ],
            'other_phone' => ['nullable', 'string',
            // 'regex:/^01[0125][0-9]{8}$/'
        ],
        ];
    }
}
