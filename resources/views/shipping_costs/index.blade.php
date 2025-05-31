<x-layouts.main-content :title="'Shipping Costs'" :heading="'Manage Shipping Costs'" subheading="Define price intervals and their shipping costs.">
    <div class="flex flex-col gap-6 rounded-xl max-w-7xl mx-auto w-full p-6">

        <div class="flex items-center justify-between mb-4">
            <flux:button variant="primary" href="{{ route('shipping_costs.create') }}">
                + Add Shipping Cost Interval
            </flux:button>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th class="px-4 py-3 text-left min-w-[180px]">Min Threshold (€)</th>
                        <th class="px-4 py-3 text-left min-w-[180px]">Max Threshold (€)</th>
                        <th class="px-4 py-3 text-left min-w-[180px]">Shipping Cost (€)</th>
                        <th class="px-4 py-3 text-left min-w-[180px]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shippingCosts as $cost)
                        <tr class="border-b border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3">{{ number_format($cost->min_value_threshold, 2, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ number_format($cost->max_value_threshold, 2, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ number_format($cost->shipping_cost, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 flex flex-wrap items-center gap-3">
                                <a href="{{ route('shipping_costs.edit', $cost) }}" aria-label="Edit shipping cost">
                                    <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                                </a>

                                <form method="POST" action="{{ route('shipping_costs.destroy', $cost) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this shipping cost?');"
                                      class="inline"
                                      aria-label="Delete shipping cost">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="focus:outline-none">
                                        <flux:icon.trash class="size-5 hover:text-red-600" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                                No shipping costs defined.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($shippingCosts, 'links'))
            <div class="mt-6">
                {{ $shippingCosts->links() }}
            </div>
        @endif
    </div>
</x-layouts.main-content>
