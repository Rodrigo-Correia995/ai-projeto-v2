<x-layouts.main-content :title="$operation->name" :heading="'Edit operation ' . $operation->name"
    subheading='Click on "Save" button to store the information.'>
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <form method="POST" action="{{ route('operations.update', ['operation' => $operation]) }}">
                    @csrf
                    @method('PUT')
                    <div class="mt-6 space-y-4">
                        @include('operations.partials.fields', ['mode' => 'edit'])
                    </div>
                    <div class="flex mt-6">
                        <flux:button variant="primary" type="submit" class="uppercase">
                            Save</flux:button>
                        <flux:button variant="filled" class="uppercase ms-4" href="{{ url()->full() }}">
                            Cancel</flux:button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layouts.main-content>
