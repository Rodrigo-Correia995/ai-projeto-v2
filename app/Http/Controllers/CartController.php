<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\CartConfirmationFormRequest;

class CartController extends Controller
{
    public function show(): View
    {
        
        $cart = session('cart', []);
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
    
        $cart['shipping'] =  5.00;// Valor fixo ou cálculo dinâmico
        $cart['total'] = $cart['subtotal'] + $cart['shipping'];
    }

    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session()->get('cart', ['products' => []]); // Inicializa corretamente

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

        return back()->with('success', 'Product added to cart!');
         

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
        ->with('alert-msg', "Product \"{$productName}\" was removed from cart")
        ->with('alert-type', 'success');
    }

    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session()->get('cart', ['products' => []]);
    
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
                return back()->with('error', 'Quantidade excede o estoque disponível');
            }
        }
    
        // Recalcula totais
        $this->calculateTotals($cart);
    
        session()->put('cart', $cart);
    
        return back()->with('success', 'Carrinho atualizado');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $newCart = [
        'products' => [],
        'subtotal' => 0,
        'shipping' => 5.00, // Valor padrão do frete
        'total' => 5.00
        ];
    
        session(['cart' => $newCart]);
    
        return back()->with('success', 'Cart cleared successfully');

    }

    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
        
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to complete your purchase');
        }

        // Verificação atualizada
        if ($user->type == 'employee') {
            return back()->with('error', 'Only club members can make purchases');
        }
    }
}