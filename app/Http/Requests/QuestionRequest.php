<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'concept_id' => ['required', 'integer', 'exists:concepts,id'],
            'question'   => ['required', 'array'],
        ];
    }
}
