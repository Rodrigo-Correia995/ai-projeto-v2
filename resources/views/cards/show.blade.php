<x-layouts.main-content :title="$card->id" :heading="'card ' . $card->card_number">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="mt-6 space-y-4">
                    @include('cards.partials.fields', ['mode' => 'show'])
                </div>
                </form>
            </section>
        </div>
    </div>
</x-layouts.main-content>
