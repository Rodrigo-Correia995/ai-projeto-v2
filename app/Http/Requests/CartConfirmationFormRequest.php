<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CartConfirmationFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Permitir membros ou board
        return Auth::check() && in_array(Auth::user()->type, ['member', 'board']);
    }

    public function rules(): array
    {
        return [
            'nif' => ['required', 'digits:9'],
            'delivery_address' => ['required', 'string', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'nif.required' => 'O NIF é obrigatório.',
            'nif.digits' => 'O NIF deve ter exatamente 9 dígitos.',
        ];
    }
}
