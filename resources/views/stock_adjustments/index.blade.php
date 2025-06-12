<x-layouts.main-content :title="__('Stock Adjustments')"
    heading="Stock Adjustment History"
    subheading="Audit log of all manual changes to product stock">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="my-4 p-6 max-w-7xl mx-auto w-full">
            <div class="overflow-x-auto">
                <table class="table-auto border-collapse w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-400 bg-gray-100 dark:bg-gray-800">
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Adjusted By</th>
                            <th class="px-4 py-3 text-right">Quantity Changed</th>
                            <th class="px-4 py-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stock_adjustments as $adjustment)
                            <tr class="border-b border-gray-300">
                                <td class="px-4 py-2">
                                    {{ $adjustment->product->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $adjustment->registeredBy->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <span class="{{ $adjustment->quantity_changed > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $adjustment->quantity_changed > 0 ? '+' : '' }}{{ $adjustment->quantity_changed }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $adjustment->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No stock adjustments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $stock_adjustments->links() }}
            </div>
        </div>
    </div>
</x-layouts.main-content>
