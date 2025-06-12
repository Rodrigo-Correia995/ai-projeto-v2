@props(['cart'])

<div class="cart-table">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-800">
                <th class="px-4 py-2 text-left">Product</th>
                <th class="px-4 py-2 text-left">Unit Price</th>
                <th class="px-4 py-2 text-left">Quantity</th>
                <th class="px-4 py-2 text-left">Subtotal</th>
                <th class="px-4 py-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart['products'] as $id => $item)
                @php
                    $product = $item['product'];
                    $quantity = $item['quantity'];
                    $unitPrice = $item['discounted_price'];
                    $subtotal = $unitPrice * $quantity;
                    $lowStock = $product->stock < $quantity;
                @endphp
                
                <tr class="border-b border-gray-200 dark:border-gray-700 {{ $lowStock ? 'bg-yellow-50' : '' }}">
                    <td class="px-4 py-2">
                        <div class="flex items-center">
                            
                            <div>
                                <p class="font-medium">{{ $product->name }}</p>
                                @if($lowStock)
                                    <span class="text-xs text-yellow-600">(Low stock: {{ $product->stock }} available)</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2">{{ number_format($unitPrice, 2) }} €</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('cart.update', $product) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $quantity }}" min="0" class="w-16 px-2 py-1 border rounded">
                            <button type="submit" class="ml-2 px-2 py-1 bg-blue-500 text-white rounded">Update</button>
                        </form>
                    </td>
                    <td class="px-4 py-2">{{ number_format($subtotal, 2) }} €</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('cart.remove', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>