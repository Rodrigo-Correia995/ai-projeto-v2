<x-layouts.main-content :title="__('New Category')"
    heading="Create Category"
    subheading="Register a new category in the system">
    
    <div class="w-full max-w-4xl mx-auto">
        <form method="POST" action="{{ route('categories.store') }}" class="flex flex-col gap-4">
            @csrf

            {{-- Campos partilhados --}}
            @include('categories.partials.fields', ['mode' => 'create'])

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    Save Category
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.main-content>
