<x-layouts.main-content :title="$categorie->name"
    :heading="'Edit category ' . $categorie->name"
    subheading='Click on "Save" button to store the information.'>

    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <form method="POST" action="{{ route('categories.update', ['categorie' => $categorie]) }}">
                    @csrf
                    @method('PUT')
                    <div class="mt-6 space-y-4">
                        @include('categories.partials.fields', ['mode' => 'edit'])
                    </div>
                    <div class="flex mt-6">
                        <flux:button variant="primary" type="submit" class="uppercase">
                            Save
                        </flux:button>
                        <flux:button variant="filled" class="uppercase ms-4" href="{{ url()->full() }}">
                            Cancel
                        </flux:button>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('categories.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md">
                            ← Back to Categories
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layouts.main-content>