<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:255'],
            'umur'   => ['required', 'integer', 'between:1,120'],
            'bio'    => ['nullable', 'string', 'max:1000'],
            'alamat' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
