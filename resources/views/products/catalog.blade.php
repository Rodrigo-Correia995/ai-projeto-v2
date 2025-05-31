<x-layouts.main-content :title="__('Catalog')" heading="Product Catalog" subheading="Browse our products">

    <form method="GET" action="{{ route('products.catalog') }}" class="flex flex-wrap gap-4 mb-6 items-end">

        <x-products.filter-card-catalog
            :categories="$listCategories"
            :category="old('category', request('category'))"
            :name="old('name', request('name'))"
            :price-min="old('priceMin', request('priceMin'))"
            :price-max="old('priceMax', request('priceMax'))"
            :stock-alert-only="old('stockAlertOnly', request('stockAlertOnly'))"
            :filter-action="route('products.catalog')"
            :reset-url="route('products.catalog')"
            class="w-full max-w-lg" />

    </form>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                    <th class="px-4 py-3 text-left min-w-[200px]">Name</th>
                    <th class="px-4 py-3 text-right min-w-[120px] hidden sm:table-cell">Stock</th>
                    <th class="px-4 py-3 text-right min-w-[180px]">Price (€)</th>
                    <th class="px-4 py-3 text-left min-w-[120px] hidden sm:table-cell">Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="border-b border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">

                    <td class="px-4 py-3 font-semibold">{{ $product->name }}</td>

                    <td class="px-4 py-3 text-right hidden sm:table-cell">
                        {{ $product->stock }}
                        @if($product->isBelowMinimumStock())
                        <span class="text-red-600 font-semibold ml-2">(Low stock)</span>
                        @elseif($product->isAboveMaximumStock())
                        <span class="text-yellow-600 font-semibold ml-2">(Overstock)</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-right">
                        @if ($product->discount && $product->discount_min_qty)
                            <div class="text-sm text-gray-500 line-through">
                                {{ number_format($product->price, 2, ',', '.') }} €
                            </div>
                            <div class="text-lg font-semibold text-green-600">
                                {{ number_format($product->price - $product->discount, 2, ',', '.') }} €
                            </div>
                            <div class="text-xs text-orange-600 mt-1 italic">
                                -{{ number_format($product->discount, 2, ',', '.') }} € a partir de {{ $product->discount_min_qty }} unidades
                            </div>
                        @else
                            <span>{{ number_format($product->price, 2, ',', '.') }} €</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-left hidden sm:table-cell">{{ $product->category?->name ?? '-' }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

</x-layouts.main-content>
