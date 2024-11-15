<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateDoctorRequest extends FormRequest
{

    public function __construct(protected $doctor, protected array $clinics)
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'regex:/^[a-z0-9_-]{3,15}$/', 'unique:users,username,'. $this->doctor->user_id],
            'password' => ['nullable', 'string'],
            'specialization' => ['required', 'string'],
            'clinic_id' => ['required', 'in:'. implode(',', $this->clinics)],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/^01[0125][0-9]{8}$/'],
            'other_phone' => ['nullable', 'string', 'regex:/^01[0125][0-9]{8}$/'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'password' => ['nullable', Password::default(), 'confirmed','string'],
            'password_confirmation' => ['present_with:password', 'nullable','string', 'same:password']
        ];
    }
}
