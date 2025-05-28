<x-layouts.main-content :title="$categorie->name" :heading="'Category: '. $categorie->name">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="mt-6 space-y-4">
                    @include('categories.partials.fields', ['mode' => 'show'])
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>