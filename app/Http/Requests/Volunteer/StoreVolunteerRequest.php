<?php

namespace App\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
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
            'name' => 'required|string',
            'nationality' => 'required|string',
            'description' => 'required|string',
            'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
