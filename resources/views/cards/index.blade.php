<x-layouts.main-content :title="__('Cards')"
    heading="List of Cards"
    subheading="Manage the available Cards">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-start">
            <div class="my-4 p-6 max-w-7xl mx-auto w-full">
                <x-cards.filter-card
                    :filterAction="route('cards.index')"
                    :resetUrl="route('cards.index')"
                    :id="old('id', $filterById)"
                    :card_number="old('card_number', $filterByCardNumber)"
                    class="w-full max-w-lg"
                    />
                    <br>
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('cards.create') }}">
                        Create a new Card
                    </flux:button>
                </div>

                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300 overflow-x-auto">
                    <table class="table-auto border-collapse w-full max-w-7xl mx-auto">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                                <th class="px-4 py-3 text-left min-w-[80px]">ID</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Number</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Balance</th>
                                <th class="px-4 py-3 text-left">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cards as $card)
                                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                                     <td class="px-2 py-2 text-left">{{ $card->id}}</td>
                                    <td class="px-2 py-2 text-left">{{ $card->card_number }}</td>
                                    <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $card->balance }}</td>
                                    <td class="px-4 py-3 flex space-x-4">
                                        <a href="{{ route('cards.show', $card) }}">
                                            <flux:icon.eye class="size-5 hover:text-gray-600" />
                                        </a>
                                        <a href="{{ route('cards.edit', $card) }}">
                                            <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                                        </a>
                                        <form method="POST" action="{{ route('cards.destroy', $card) }}" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <flux:icon.trash class="size-5 hover:text-red-600" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $cards->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
