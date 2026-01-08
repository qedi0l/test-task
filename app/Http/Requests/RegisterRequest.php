<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nickname' => ['required', 'string', 'max:255'],
            'avatar' => ['required','image','mimes:jpg','max:8192'],
        ];
    }
}
