<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $method = strtolower($this->getMethod());
       if ($method === 'put' || $method === 'patch') {
        return $this->user()->can('update', $this->route('user'));
    }else{
        return true;
    }


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'gender' => ['required', 'in:M,F'],
            'default_delivery_address' => ['nullable', 'string', 'max:255'],
            'nif' => ['nullable', 'string', 'max:9'],
            'default_payment_reference' => ['nullable', 'string', 'max:255'],
            'default_payment_type' => ['nullable', 'in:Visa,MB WAY,PayPal'],
            'type' => ['required', 'in:member,employee,pending_member'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.max' => 'Name may not be greater than 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken.',
            'email.max' => 'Email may not be greater than 255 characters.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either M or F.',
            'default_delivery_address.max' => 'Delivery address may not exceed 255 characters.',
            'nif.max' => 'NIF must not exceed 9 characters.',
            'default_payment_reference.max' => 'Payment reference may not exceed 255 characters.',
            'default_payment_type.in' => 'Payment type must be one of: Visa, MB WAY, or PayPal.',
        ];
    }
}
