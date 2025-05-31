@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
@endphp

<div class="w-full sm:w-96">
    <flux:input
        name="name"
        label="Name"
        value="{{ old('name', $product->name) }}"
        :disabled="$readonly" />
</div>

<div class="w-full sm:w-96">
    <flux:input
        type="number"
        step="0.01"
        name="price"
        label="Price (€)"
        value="{{ old('price', $product->price) }}"
        :disabled="$readonly" />
</div>

<div class="w-full sm:w-96">
    <flux:input
        type="number"
        name="stock"
        label="Stock"
        value="{{ old('stock', $product->stock) }}"
        :disabled="$readonly" />
</div>

<div class="w-full sm:w-96">
    <flux:input
        type="number"
        name="stock_lower_limit"
        label="Stock Lower Limit"
        value="{{ old('stock_lower_limit', $product->stock_lower_limit) }}"
        :disabled="$readonly" />
</div>

<div class="w-full sm:w-96">
    <flux:input
        type="number"
        name="stock_upper_limit"
        label="Stock Upper Limit"
        value="{{ old('stock_upper_limit', $product->stock_upper_limit) }}"
        :disabled="$readonly" />
</div>

<div class="w-full sm:w-96">
    <flux:input
        type="number"
        name="discount_min_qty"
        label="Minimum Quantity for Discount (optional)"
        value="{{ old('discount_min_qty', $product->discount_min_qty) }}"
        min="0"
        :disabled="$readonly"
        placeholder="Leave empty if no discount" />
</div>

<div class="w-full sm:w-96">
    <flux:input
        type="number"
        step="0.01"
        name="discount"
        label="Discount Amount (€) (optional)"
        value="{{ old('discount', $product->discount) }}"
        min="0"
        :disabled="$readonly"
        placeholder="Leave empty if no discount" />
</div>

<div class="w-full sm:w-96">
    <flux:select
        name="category_id"
        label="Category"
        :disabled="$readonly"
        :value="old('category_id', $product->category_id)">
        <option value="">Select category</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}"
            {{ old($product->category_id, $product->category_id) == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @endforeach
    </flux:select>
</div>

<div class="w-full sm:w-full">
    <flux:textarea
        name="description"
        label="Description"
        :disabled="$readonly"
        :resize="$readonly ? 'none' : 'vertical'"
        rows="auto">{{ old('description', $product->description) }}</flux:textarea>
</div>