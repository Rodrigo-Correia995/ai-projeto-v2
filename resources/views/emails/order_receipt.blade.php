<x-mail::message>
# Encomenda Concluída

Olá {{ $order->member->name }},

A sua encomenda #{{ $order->id }} foi concluída e está a caminho.

Em anexo segue o recibo da sua compra.

Obrigado por comprar connosco!
</x-mail::message>
