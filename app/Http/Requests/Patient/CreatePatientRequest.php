<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
{
    public function __construct(protected array $clinicsIds)
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'age' => ['required', 'integer'],
            'clinic_id' => ['required', 'in:'.implode(',', $this->clinicsIds)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'phone' => [
                'required',
                'string',
                // 'regex:/^01[0125][0-9]{8}$/'
            ],
            'other_phone' => [
                'nullable',
                'string',
                // 'regex:/^01[0125][0-9]{8}$/'
            ],
            'nationality' => ['nullable', 'integer'],
            'gender' => ['required', 'string', 'in:male,female'],
            'address' => ['nullable', 'string'],
            'allergies' => ['nullable', 'string'],
            'height' => ['nullable', 'integer'],
            'weight' => ['nullable', 'integer'],
            'national_card_id' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
