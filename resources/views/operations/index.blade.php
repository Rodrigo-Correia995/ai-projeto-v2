<x-layouts.main-content :title="__('Operations')"
    heading="List of Operations"
    subheading="Manage the available Operations">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-start">
            <div class="my-4 p-6 max-w-7xl mx-auto w-full">
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('operations.create') }}">
                        Create a new Operation
                    </flux:button>
                </div>

                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300 overflow-x-auto">
                    <table class="table-auto border-collapse w-full max-w-7xl mx-auto">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                                <th class="px-2 py-2 text-left">ID</th>
                                <th class="px-2 py-2 text-left">card_id</th>
                                <th class="px-2 py-2 text-left hidden sm:table-cell">Type</th>
                                <th class="px-2 py-2 text-right hidden sm:table-cell">Value</th>
                                <th class="px-2 py-2 text-right hidden sm:table-cell">Debit Type</th>
                                <th class="px-2 py-2 text-right hidden sm:table-cell">Credit Type</th>
                                <th class="px-2 py-2 text-right hidden sm:table-cell">Payment Type</th>
                                <th class="px-2 py-2 text-right hidden sm:table-cell">Payment Reference</th>
                                <th class="px-2 py-2 text-right hidden sm:table-cell">Order ID</th>
                                <th class="px-4 py-3 text-left">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operations as $operation)
                                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                                    <td class="px-2 py-2 text-left">{{ $operation->id }}</td>
                                    <td class="px-2 py-2 text-left">{{ $operation->card_id }}</td>
                                    <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $operation->type }}</td>
                                    <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $operation->value }}</td>
                                    <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $operation->debit_type }}</td>
                                    <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $operation->credit_type }}</td>
                                    <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $operation->payment_type }}</td>
                                    <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $operation->payment_reference }}</td>
                                    <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $operation->order_id }}</td>
                                    <td class="px-4 py-3 flex space-x-4">
                                        <a href="{{ route('operations.show', $operation) }}">
                                            <flux:icon.eye class="size-5 hover:text-gray-600" />
                                        </a>
                                        <a href="{{ route('operations.edit', $operation) }}">
                                            <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                                        </a>
                                        <form method="POST" action="{{ route('operations.destroy', $operation) }}" onsubmit="return confirm('Are you sure?');">
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
                    {{ $operations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
