<x-layouts.main-content title="Cart" heading="Shopping Cart" subheading="Products selected for purchase">
    <div class="container mx-auto px-4 py-8">
        @if(empty($cart['products']))
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-300">Your cart is empty</h2>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Continue Shopping
                </a>
            </div>
        @else
            <x-cart.table :cart="$cart" />
            
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Order Summary</h3>
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>{{ number_format($cart['subtotal'], 2) }} €</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span>{{ number_format($cart['shipping'], 2) }} €</span>
                    </div>
                    <div class="flex justify-between border-t pt-2 mt-2 font-bold text-lg">
                        <span>Total</span>
                        <span>{{ number_format($cart['total'], 2) }} €</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    @auth
                        @if(auth()->user())
                            <form action="{{ route('cart.confirm') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="nif" class="block mb-1">NIF</label>
                                        <input type="text" name="nif" id="nif" value="{{ old('nif', auth()->user()->nif ?? '') }}" 
                                               class="w-full px-3 py-2 border rounded">
                                    </div>
                                    <div>
                                        <label for="address" class="block mb-1">Delivery Address</label>
                                        <input type="text" name="address" id="address" 
                                               value="{{ old('address', auth()->user()->default_delivery_address ?? '') }}" 
                                               class="w-full px-3 py-2 border rounded">
                                    </div>
                                </div>
                                <button type="submit" class="w-full py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">
                                    Confirm Purchase
                                </button>
                            </form>
                        @else
                            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                                <p>Only club members can make purchases. Please contact support to upgrade your account.</p>
                            </div>
                            
                        @endif
                    @else
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4">
                            <p>You need to <a href="{{ route('login') }}" class="font-semibold hover:underline">login</a> as a club member to complete your purchase.</p>
                        </div>
                    @endauth
                    
                    <form action="{{ route('cart.destroy') }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-layouts.main-content>