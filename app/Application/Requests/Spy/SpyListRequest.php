<?php

namespace App\Application\Requests\Spy;

use Illuminate\Foundation\Http\FormRequest;

class SpyListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'integer',
            'itemsPerPage' => 'integer',
            'sortBy' => 'string',
            'sortByDesc' => 'string',
            'age' => 'string',
            'name' => 'string',
        ];
    }
}
