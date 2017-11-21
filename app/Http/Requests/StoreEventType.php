<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Duration;

class StoreEventType extends FormRequest
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
            'name' => 'required|max:255',
            'slug' => 'required|alpha_dash|max:20',
            'duration' => ['required', 'integer', new Duration(15, 24*60)],
            'padding' => ['required', 'integer', new Duration(0, 8*60)],
        ];
    }
}
