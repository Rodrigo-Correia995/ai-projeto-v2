<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recibo da Encomenda #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h1>Recibo de Encomenda</h1>
    <p><strong>ID:</strong> {{ $order->id }}</p>
    <p><strong>Data:</strong> {{ $order->date }}</p>
    <p><strong>Cliente:</strong> {{ $order->member->name }} ({{ $order->member->email }})</p>

    <h3>Produtos:</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} €</td>
                    <td>{{ number_format($item->subtotal, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> {{ number_format($order->total, 2) }} €</p>
</body>
</html>