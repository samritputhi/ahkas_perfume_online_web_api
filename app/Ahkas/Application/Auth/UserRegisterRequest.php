<?php

namespace App\Ahkas\Application\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// use Illuminate\Validation\Rule;

/**
 * @author SOPHEAK
 */
class UserRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|digits_between:9,12',
            'name' => 'required|min:4|unique:users,name',
            'password' => 'required|min:6|confirmed',
            'device_name' => 'required',
        ];
    }
}
