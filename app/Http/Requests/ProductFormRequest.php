<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação para o formulário.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|max:1000',
            'stock_lower_limit' => 'required|integer|min:0',
            'stock_upper_limit' => 'required|integer|min:0|gte:stock_lower_limit',
            'discount_min_qty' => 'nullable|integer|min:1|required_with:discount',
            'discount' => 'nullable|numeric|min:0|required_with:discount_min_qty',


        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $price = $this->input('price');
            $discount = $this->input('discount');

            if (!is_null($discount) && $discount >= $price) {
                $validator->errors()->add('discount', 'The discount must be less than the product price.');
            }
        });
    }
    //Validaçao de que o produto nao pode ter um desconto maior que o seu preço.
}
