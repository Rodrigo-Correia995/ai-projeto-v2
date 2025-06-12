<x-layouts.main-content :title="$operation->id" :heading="'operation ' . $operation->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="mt-6 space-y-4">
                    @include('operations.partials.fields', ['mode' => 'show'])
                </div>
                </form>
            </section>
        </div>
    </div>
</x-layouts.main-content>
