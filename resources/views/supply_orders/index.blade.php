<x-layouts.main-content title="Supply Orders" heading="Supply Orders" subheading="Stock Order Management">

    <div class="overflow-x-auto">
        <table class="table w-full text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Product</th>
                    <th class="px-4 py-2 text-left">Quantity</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Registered By</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supplyOrders as $order)
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="font-medium">{{ $order->product->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $order->quantity }}</td>
                        <td class="px-4 py-3 capitalize">{{ $order->status }}</td> <!-- apenas mostra o estado -->
                        <td class="px-4 py-3">{{ $order->registeredBy?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            @if ($order->status === 'requested')
                                <div class="flex gap-2">
                                    <!-- Botão para Aprovar -->
                                    <form method="POST" action="{{ route('supply_orders.updateStatus', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-success" title="Approve">Approve</button>
                                    </form>

                                    <!-- Botão para Recusar -->
                                    <form method="POST" action="{{ route('supply_orders.destroy', $order) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" title="Reject">Reject</button>
</form>
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">No supply orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $supplyOrders->links() }}
    </div>

</x-layouts.main-content>
