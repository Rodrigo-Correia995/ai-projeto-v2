<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplyOrderFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Podes meter lógica de permissões se quiseres no futuro
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:requested,completed',
        ];
    }
}
