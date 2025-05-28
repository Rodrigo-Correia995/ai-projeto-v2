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