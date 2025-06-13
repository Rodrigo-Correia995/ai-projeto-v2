<x-layouts.main-content :title="__('CancelOrders')"
    heading="Order"
    subheading="Cancel this Order">

    <div class="max-w-xl mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Cancelar Encomenda #{{ $order->id }}</h2>

    <form action="{{ route('orders.cancel', $order) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="reason" class="block mb-1">Razão do Cancelamento</label>
            <textarea name="reason" id="reason" rows="4" required class="w-full border px-3 py-2 rounded"></textarea>
        </div>

        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Confirmar Cancelamento
        </button>
        <a href="{{ route('orders.index') }}" class="ml-4 text-gray-600 hover:underline">Voltar</a>
    </form>
    </div>

</x-layouts.main-content>