<x-layouts.main-content title="New Product"
    heading="Create a Product"
    subheading='Click on "Save" button to store the information.'>
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    <div class="mt-6 space-y-4">
                        @include('products.partials.fields', ['mode' => 'create'])
                    </div>
                    <div class="flex mt-6">
                        <flux:button variant="primary" type="submit"
                            class="uppercase">Save</flux:button>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md">
                            ← Back to Products
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layouts.main-content>