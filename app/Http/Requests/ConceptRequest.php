<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:2', 'max:100'],
            'description' => ['nullable', 'string'],
            'difficulty'  => ['required', 'in:junior,intermediate,senior'],
            'status'      => ['required', 'in:a_revoir,en_cours,maitrise'],
        ];
    }
}
