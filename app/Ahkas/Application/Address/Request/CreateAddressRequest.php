<?php

namespace App\Ahkas\Application\Address\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @author SOPHEAK
 */
class CreateAddressRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required',
            'address' => 'required',
        ];
    }
}
