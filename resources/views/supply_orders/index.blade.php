<x-layouts.main-content :title="'Supply Orders'" :heading="'Supply Orders'" subheading="Stock Order Management">
    <div class="flex flex-col gap-6 rounded-xl max-w-7xl mx-auto w-full p-6">

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-sm">
                <thead>
                    <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th class="px-4 py-3 text-left min-w-[150px]">Product</th>
                        <th class="px-4 py-3 text-left min-w-[100px]">Quantity</th>
                        <th class="px-4 py-3 text-left min-w-[120px]">Status</th>
                        <th class="px-4 py-3 text-left min-w-[150px]">Registered By</th>
                        <th class="px-4 py-3 text-left min-w-[160px]">Date</th>
                        <th class="px-4 py-3 text-left min-w-[160px]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($supplyOrders as $supplyOrder)
                    <tr class="border-b border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 font-medium">{{ $supplyOrder->product->name }}</td>
                        <td class="px-4 py-3">{{ $supplyOrder->quantity }}</td>
                        <td class="px-4 py-3 capitalize">{{ $supplyOrder->status }}</td>
                        <td class="px-4 py-3">{{ $supplyOrder->registeredBy?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $supplyOrder->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            @if ($supplyOrder->status === 'requested')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('supply_orders.updateStatus', $supplyOrder) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed" />
                                    <flux:button type="submit" variant="primary" size="sm" title="Approve" class="p-2">
                                        <flux:icon.check class="size-5" />
                                    </flux:button>
                                </form>

                                <form method="POST" action="{{ route('supply_orders.destroy', $supplyOrder) }}" onsubmit="return confirm('Are you sure you want to reject this supply order?');">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="danger" size="sm" title="Reject" class="p-2">
                                        <flux:icon.trash class="size-5" />
                                    </flux:button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-500">—</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                            No supply orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($supplyOrders, 'links'))
        <div class="mt-6">
            {{ $supplyOrders->links() }}
        </div>
        @endif

    </div>
</x-layouts.main-content>