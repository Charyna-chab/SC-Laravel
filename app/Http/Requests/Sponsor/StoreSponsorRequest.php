<?php

namespace App\Http\Requests\Sponsor;

use Illuminate\Foundation\Http\FormRequest;

class StoreSponsorRequest extends FormRequest
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
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'link' => 'required|string',
        ];
    }
}
