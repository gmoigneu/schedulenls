<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SettingsSlug extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => [
                'required',
                Rule::unique('users')->ignore(Auth::user()->id),
                'alpha_dash',
                'regex:/^[a-z0-9]*$/',
                'max:20',
                Rule::notIn(['www', 'root', 'null', 'admin', 'sql', 'https', 'http']),
            ]
        ];
    }
}
