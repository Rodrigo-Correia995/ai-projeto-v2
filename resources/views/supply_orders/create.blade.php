@php
    $readonly = false;
@endphp

<x-layouts.main-content :title="'New Supply Order'" heading="Create Supply Order" subheading="Add a new supply order record">
    <form action="{{ route('supply_orders.store') }}" method="POST" class="flex flex-col gap-6 w-full sm:w-96">
        @csrf

        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="w-full sm:w-96">
            <flux:input
                name="product_name"
                label="Product"
                value="{{ $product->name }}"
                disabled
            />
        </div>

        <div class="w-full sm:w-96">
            <flux:input
                type="number"
                name="quantity"
                label="Quantity"
                value="{{ old('quantity') }}"
                min="1"
                required
                :disabled="$readonly"
            />
            @error('quantity')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn btn-primary">Create Request</button>
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</x-layouts.main-content>
