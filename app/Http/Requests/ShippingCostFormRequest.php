<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ShippingCost;

class ShippingCostFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for the form.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'min_value_threshold' => ['required', 'numeric', 'min:0', 'lt:max_value_threshold'],
            'max_value_threshold' => ['required', 'numeric', 'gt:min_value_threshold'],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $min = $this->input('min_value_threshold');
            $max = $this->input('max_value_threshold');
            $id = $this->route('shipping_cost')?->id;

            // Check if min_value_threshold falls inside an existing interval
            $minOverlap = ShippingCost::where('min_value_threshold', '<=', $min)
                ->where('max_value_threshold', '>=', $min)
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists();

            // Check if max_value_threshold falls inside an existing interval
            $maxOverlap = ShippingCost::where('min_value_threshold', '<=', $max)
                ->where('max_value_threshold', '>=', $max)
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists();

            // Check if new interval fully encloses an existing one
            $enclosesExisting = ShippingCost::where('min_value_threshold', '>=', $min)
                ->where('max_value_threshold', '<=', $max)
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists();

            if ($minOverlap) {
                $validator->errors()->add('min_value_threshold', 'The minimum value falls within an existing interval.');
            }
            if ($maxOverlap) {
                $validator->errors()->add('max_value_threshold', 'The maximum value falls within an existing interval.');
            }
            if ($enclosesExisting) {
                // If the new interval encloses any existing interval, add errors to both fields
                $validator->errors()->add('min_value_threshold', 'The interval overlaps an existing interval.');
                $validator->errors()->add('max_value_threshold', 'The interval overlaps an existing interval.');
            }
        });
    }
}
