@php
    $readonly = false;
@endphp

<x-layouts.main-content 
    :title="'New Supply Order'" 
    heading="Create Supply Order" 
    subheading="Add a new supply order record"
>
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

        <div class="flex mt-6 items-center gap-4">
            <flux:button variant="primary" type="submit" class="uppercase">
                Create Request
            </flux:button>

            <flux:button variant="filled" class="uppercase" href="{{ url()->full() }}">
                Cancel
            </flux:button>
        </div>

        <div class="mt-6">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md"
            >
                ← Back to Products
            </a>
        </div>
    </form>
</x-layouts.main-content>
