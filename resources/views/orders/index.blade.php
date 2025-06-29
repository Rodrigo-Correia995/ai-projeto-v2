<x-layouts.main-content :title="__('Orders')"
    heading="List of Orders"
    subheading="Manage the available Orders">


<div class="max-w-6xl mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Lista de Encomendas</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <table class="w-full table-auto border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-3 py-2">ID</th>
                <th class="px-3 py-2">Member ID</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2">Total</th>
                <th class="px-3 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-t">
                <td class="px-3 py-2">{{ $order->id }}</td>
                <td class="px-3 py-2">{{ $order->member_id }}</td>
                <td class="px-3 py-2">{{ ucfirst($order->status) }}</td>
                <td class="px-3 py-2">{{ number_format($order->total, 2) }}€</td>
                <td class="px-3 py-2">{{ $order->date }}</td>
                @can('admin')


                <td class="px-3 py-2 space-x-2">
                    @if($order->status === 'pending')
                        <form action="{{ route('orders.complete', $order) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-block bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-green-600">
                                Completar
                            </button>
                        </form>

                        <a href="{{ route('orders.cancel.form', $order) }}"
                            class="inline-block bg-red-500 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-red-600 ml-2">
                                Cancelar
                        </a>
                        @endcan
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>

</x-layouts.main-content>
