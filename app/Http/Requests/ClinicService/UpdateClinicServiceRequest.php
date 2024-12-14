<?php

namespace App\Http\Requests\ClinicService;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicServiceRequest extends FormRequest
{
    public function __construct(protected array $clinicsIds)
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'clinic_id' => ['nullable', 'in:' . implode(',', $this->clinicsIds)],
            'description' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
        ];
    }
}
