<x-layouts.main-content :title="__('Products')"
    heading="List of Products"
    subheading="Manage the available Products">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-start">
            <div class="my-4 p-6 max-w-7xl mx-auto w-full">
                <div class="flex items-center gap-4 mb-4">


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
                        class="mb-6" />


                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300 overflow-x-auto">
                    <table class="table-auto border-collapse w-full max-w-7xl mx-auto">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                                <th class="px-4 py-3 text-left min-w-[200px]">Name</th>

                                <th class="px-4 py-3 text-right min-w-[120px] hidden sm:table-cell">Stock</th>
                                <th class="px-4 py-3 text-right min-w-[120px] hidden sm:table-cell">Price (€)</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Category</th>
                                <th class="px-4 py-3 text-left">Options</th>
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allProducts as $product)
                            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                                <td class="px-4 py-3">{{ $product->name }}</td>

                                <td class="px-4 py-3 text-right hidden sm:table-cell">{{ $product->stock }}</td>
                                <td class="px-4 py-3 text-right hidden sm:table-cell">{{ number_format($product->price, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $product->category?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('products.show', $product) }}">
                                        <flux:icon.eye class="size-5 hover:text-gray-600" />
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('products.edit', $product) }}">
                                        <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('products.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <flux:icon.trash class="size-5 hover:text-red-600" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $allProducts->links() }}
                </div>
            </div>
        </div>
    </div>
    </x-layouts.app>