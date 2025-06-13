<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\ItemOrder;
use App\Models\Operation;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CartConfirmationFormRequest;

class CartController extends Controller
{

    public function show(): View
    {
        
        $cart = session('cart',  ['products' => [], 'subtotal' => 0, 'shipping' => 0, 'total' => 0]);
        foreach ($cart['products'] as $id => &$item) {
            if (is_numeric($id) && is_array($item)) {
                $product = Product::find($id);
                if ($product) {
                    $item['product'] = $product;
                    if($item['quantity'] >= $product->discount_min_qty){
                        $item['discounted_price'] = $product->price - $product->discount;

                    }else{
                         $item['discounted_price'] = $product->price;

                    }
                    
                }
            }
        }
    
        $this->calculateTotals($cart);
        session(['cart' => $cart]);
        return view('cart.show', compact('cart'));
        
    
    }

    private function calculateTotals(&$cart)
    {
        $cart['subtotal'] = 0;
        $cart['total'] = 0;
    
        foreach ($cart['products'] as $item) {
            $cart['subtotal'] += $item['discounted_price'] * $item['quantity'];
        }
    
        $cart['shipping'] = \App\Models\ShippingCost::getShippingCostForOrderTotal($cart['subtotal']);
        $cart['total'] = $cart['subtotal'] + $cart['shipping'];
    }

    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session()->get('cart',  ['products' => [], 'subtotal' => 0, 'shipping' => 0, 'total' => 0]); // Inicializa corretamente

        // Verifica se o produto já está no carrinho
        if (isset($cart['products'][$product->id])) {
            $cart['products'][$product->id]['quantity']++;
        } else {
            $cart['products'][$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discounted_price' => $product->price * (1 - ($product->discount / 100)),
                'quantity' => 1,
                
            ];
        }

        // Recalcula totais
        $this->calculateTotals($cart);

            // Guarda na sessão
        session()->put('cart', $cart);

        return back()->with('alert-msg', "Produto adicionado ao carrinho com sucesso!")
                        ->with('alert-type', 'success');
         

    }

    public function removeFromCart(Request $request, Product $product): RedirectResponse
    {
        // Obtém o carrinho da sessão ou inicializa um novo
    $cart = session()->get('cart', ['products' => [], 'subtotal' => 0, 'shipping' => 0, 'total' => 0]);
    
    // Verifica se o produto existe no carrinho
    if (!isset($cart['products'][$product->id])) {
        return back()
            ->with('alert-msg', 'Product not found in cart')
            ->with('alert-type', 'error');
    }
    
    // Armazena o nome do produto para a mensagem
    $productName = $cart['products'][$product->id]['name'];
    
    // Remove o produto do array
    unset($cart['products'][$product->id]);
    
    // Recalcula os totais
    $this->calculateTotals($cart);
    
    // Atualiza o carrinho na sessão
    session()->put('cart', $cart);
    
    // Retorna com mensagem de sucesso
    return back()
        ->with('alert-msg', "Product \"{$productName}\" was removed from cart!")
        ->with('alert-type', 'success');
    }

    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session()->get('cart', ['products' => [], 'subtotal' => 0, 'shipping' => 0, 'total' => 0]);
    
        $newQuantity = $request->quantity;
    
        // Se quantidade for zero ou negativa, remove o item
        if ($newQuantity <= 0) {
            unset($cart['products'][$product->id]);
        } 
        // Se quantidade positiva, atualiza
        else {
            $cart['products'][$product->id]['quantity'] = $newQuantity;
        
            // Opcional: validar contra o estoque máximo
            $maxStock = $product->stock + $cart['products'][$product->id]['quantity']; // Permitir mais que o estoque com aviso
            if ($newQuantity > $maxStock) {
                return back()->with('error', 'Quantidade excede o estoque disponível!');
            }
        }
    
        // Recalcula totais
        $this->calculateTotals($cart);
    
        session()->put('cart', $cart);
    
        return back()->with('success', 'Carrinho atualizado');
    }

    public function destroy(Request $request): RedirectResponse
    {
   
    
        session()->forget('cart');
    
        return back()->with('success', 'Cart cleared successfully');

    }

    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
  
        $user = auth()->user();
        $cart = session('cart', ['products' => [], 'subtotal' => 0, 'shipping' => 0, 'total' => 0]);

        // 1. Verificar se é membro
        if (!in_array($user->type, ['member', 'board']) ) {
            return back()->with('alert-msg', "Apenas membros podem concluir compras.")
        ->with('alert-type', 'danger');
        }
        

        // 2. Verificar saldo do cartão
        $card = auth()->user()->cardRef;
      
        if (!$card || $card->balance < $cart['total']) {
            return back()->with('alert-msg', "Saldo insuficiente no cartão virtual.")->with('alert-type', 'danger');
        }

        try {
            DB::beginTransaction();

            // 3. Criar order
            $order = Order::create([
            'member_id'        => $user->id,
            'status'           => 'pending',
            'date'             => now(),
            'total_items'      => collect($cart['products'])->sum('quantity'),
            'shipping_cost'    => $cart['shipping'],
            'total'            => $cart['total'],
            'nif'              => $request->nif,
            'delivery_address' => $request->delivery_address,
            ]);

            // 4. Adicionar itens à order
            foreach ($cart['products'] as $item) {
            ItemOrder::create([
                'order_id'    => $order->id,
                'product_id'  => $item['product_id'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['price'],
                'discount'    => $item['discounted_price'],
                'subtotal'    => $item['discounted_price'] * $item['quantity'],
            ]);
            }

            // 5. Debitar saldo
            $card->balance -= $cart['total'];
            $card->save();

            // 6. Registrar operação
            Operation::create([
            'card_id'           => $card->id,
            'type'              => 'debit',
            'value'            => $cart['total'],
            'date'              => now(),
            'debit_type'       => 'order',
            'order_id'          => $order->id,
            
            ]);

            DB::commit();

            // 7. Limpar carrinho
            $this->destroy($request);

          
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('alert-msg', "Erro ao confirmar a compra :" . $e->getMessage())->with('alert-type', 'danger');
        }
        return redirect()->route('cart.show', $order->id)
                            ->with('alert-msg', "Compra confirmada com sucesso! A sua compra está a ser preparada!")
                            ->with('alert-type', 'success');

    
        
    }

    
    

   


}