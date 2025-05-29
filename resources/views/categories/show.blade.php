<x-layouts.main-content :title="$categorie->name" :heading="'Category: '. $categorie->name">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="mt-6 space-y-4">
                    @include('categories.partials.fields', ['mode' => 'show'])
                </div>
                <div class="mt-6">
                    <a href="{{ route('categories.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md">
                        ← Back to Categories
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>