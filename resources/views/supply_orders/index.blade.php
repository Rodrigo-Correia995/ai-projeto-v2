<x-layouts.main-content title="Ordens de Reabastecimento" heading="Reabastecimentos" subheading="Gestão de pedidos de stock">

<div class="overflow-x-auto">
    <table class="table w-full text-sm">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Estado</th>
                <th>Registado por</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($supplyOrders as $order)
                <tr>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>
                        <form method="POST" action="{{ route('supply_orders.updateStatus', $order) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select text-sm">
                                <option value="requested" {{ $order->status === 'requested' ? 'selected' : '' }}>Pedido</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Concluído</option>
                                <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $order->registeredBy?->name ?? 'N/A' }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if ($order->status === 'requested')
                            <form method="POST" action="{{ route('supply_orders.destroy', $order) }}" onsubmit="return confirm('Eliminar esta ordem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Sem ordens de reabastecimento.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $supplyOrders->links() }}
</div>

</x-layouts.main-content>
