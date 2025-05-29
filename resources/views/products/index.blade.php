<x-layouts.main-content :title="__('Products')" heading="List of Products" subheading="Manage the available Products">
    <div class="flex flex-col gap-6 rounded-xl max-w-7xl mx-auto w-full p-6">

        <div class="flex items-center justify-between mb-4">
            <flux:button variant="primary" href="{{ route('products.create') }}">
                Create a new product
            </flux:button>

            <x-products.filter-card
                :filterAction="route('products.index')"
                :resetUrl="route('products.index')"
                :categories="$listCategories"
                :category="old('category', request('category'))"
                :name="old('name', request('name'))"
                :price-min="old('priceMin', request('priceMin'))"
                :price-max="old('priceMax', request('priceMax'))"
                class="w-full max-w-lg" />
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th class="px-4 py-3 text-left min-w-[200px]">Name</th>
                        <th class="px-4 py-3 text-right min-w-[120px] hidden sm:table-cell">Stock</th>
                        <th class="px-4 py-3 text-right min-w-[120px] hidden sm:table-cell">Price (€)</th>
                        <th class="px-4 py-3 text-left min-w-[180px]">Category</th>
                        <th class="px-4 py-3 text-left min-w-[220px]">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allProducts as $product)
                    <tr class="border-b border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3">{{ $product->name }}</td>

                        <td class="px-4 py-3 text-right hidden sm:table-cell">
                            <span>{{ $product->stock }}</span>
                            @if($product->isBelowMinimumStock())
                            <span class="text-red-600 font-semibold ml-2">(Below min)</span>
                            @elseif($product->isAboveMaximumStock())
                            <span class="text-yellow-600 font-semibold ml-2">(Above max)</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-right hidden sm:table-cell">
                            {{ number_format($product->price, 2, ',', '.') }}
                        </td>

                        <td class="px-4 py-3">{{ $product->category?->name ?? '-' }}</td>

                        <td class="px-4 py-3 flex flex-wrap items-center gap-3">
                            <a href="{{ route('products.show', $product) }}" aria-label="View product details">
                                <flux:icon.eye class="size-5 hover:text-gray-600" />
                            </a>
                            <a href="{{ route('products.edit', $product) }}" aria-label="Edit product">
                                <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                            </a>

                            <form method="POST" action="{{ route('products.destroy', $product) }}"
                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                class="inline"
                                aria-label="Delete product">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="focus:outline-none">
                                    <flux:icon.trash class="size-5 hover:text-red-600" />
                                </button>
                            </form>
                            <a href="{{ route('supply_orders.create', ['product' => $product->id]) }}"
                                class="text-sm px-3 py-1 border border-green-600 text-green-600 rounded hover:bg-green-600 hover:text-white transition"
                                aria-label="Create supply order">
                                Reabastecer
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $allProducts->links() }}
        </div>
    </div>
</x-layouts.main-content>