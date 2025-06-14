<x-layouts.main-content :title="__('Card')" heading="Your Card" subheading="View the details of your card">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-start">
            <div class="my-4 p-6 max-w-7xl mx-auto w-full">

                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300 overflow-x-auto">
                    <table class="table-auto border-collapse w-full max-w-7xl mx-auto">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                                <th class="px-4 py-3 text-left min-w-[80px]">ID</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Number</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Balance</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Owner</th>
                                <th class="px-4 py-3 text-left">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                                <td class="px-2 py-2 text-left">{{ $card->id }}</td>
                                <td class="px-2 py-2 text-left">{{ $card->card_number }}</td>
                                <td class="px-2 py-2 text-left">{{ $card->balance }}</td>

                                <td class="px-4 py-3">
                                    <a href="{{ route('cards.show', $card) }}">
                                        <flux:icon.eye class="size-5 hover:text-gray-600" />
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cards.charge') }}" method="POST">
            @csrf

            <div style="margin: 20px;">
                <label for="amount" style="display: block; margin-bottom: 5px;">Valor a carregar (€):</label>

                <input type="number" name="amount" id="amount" required
                    style="border: 1px solid #000; padding: 8px; width: 200px; border-radius: 4px; display: block;">
            </div>


            @if (Auth::user()->default_payment_type === 'Visa')
                <div id="cvc-container">
                    <label for="cvc_code">CVC:</label>
                    <input type="number" name="cvc_code" id="cvc_code" min="100" max="999" required
                        style="border: 1px solid #000; border-radius: 4px; padding: 6px;">
                </div>
            @endif
            <br>
            <x-button variant="primary" type="submit">
                Carregar Cartão
            </x-button>
        </form>
    </div>
</x-layouts.main-content>
