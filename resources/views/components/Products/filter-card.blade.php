<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <flux:select name="category" label="Category">
                        @foreach ($listCategories as $value => $description)
                        <flux:select.option value="{{ $value }}" :selected="(string) $category === (string) $value">
                            {{ $description }}
                        </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:input name="name" label="Product name" class="grow" value="{{ $name }}" />
                </div>

                <div class="flex space-x-3">
                    <div class="flex-1/2">
                        <flux:input type="number" step="0.01" name="priceMin" label="Min price" class="grow" value="{{ $priceMin }}" />
                    </div>
                    <div class="flex-1/2">
                        <flux:input type="number" step="0.01" name="priceMax" label="Max price" class="grow" value="{{ $priceMax }}" />
                    </div>
                </div>

                <div>
                    <label class="flex items-center space-x-2 pt-2">
                        <input
                            type="checkbox"
                            name="stockAlertOnly"
                            value="1"
                            {{ request()->get('stockAlertOnly') == '1' ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-blue-600 transition duration-150 ease-in-out" />
                        <span class="text-sm text-gray-700">Show products with problematic stock</span>
                    </label>
                </div>

                <div>
                    <label class="flex items-center space-x-2 pt-2">
                        <input
                            type="checkbox"
                            name="has_discount"
                            value="1"
                            @if(request()->get('has_discount') == '1') checked @endif
                            class="form-checkbox h-5 w-5 text-green-600 transition duration-150 ease-in-out" />
                        <span class="text-sm text-gray-700">Show only products with discount</span>
                    </label>
                </div>
                
            </div>

            <div class="grow-0 flex flex-col space-y-3 justify-start">
                <div class="pt-6">
                    <flux:button variant="primary" type="submit">Filter</flux:button>
                </div>
                <div>
                    <flux:button :href="$resetUrl">Cancel</flux:button>
                </div>
            </div>
        </div>
    </form>
</div>