<?php

namespace App\Http\Requests;

use app\Domain\Enums\Agency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SpyCreateRequest extends FormRequest
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
            'name' => 'required|string|unique:spies,name',
            'surname' => 'required|string|unique:spies,surname',
            'agency' => ['string', new Enum(Agency::class)],
            'country_of_operation' => 'nullable|string',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
            'date_of_death' => 'nullable|date|date_format:Y-m-d|after:date_of_birth',
        ];
    }
}
