<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SupplyOrder;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SupplyOrderFormRequest;
use Illuminate\Http\Request;

class SupplyOrderController extends Controller
{

    public function index()
    {
        $supplyOrders = SupplyOrder::with('product', 'registeredBy')->latest()->paginate(10);

        return view('supply_orders.index', compact('supplyOrders'));
    }

    public function create(Request $request)
    {
        $productId = $request->query('product');
        $product = Product::findOrFail($productId);

        return view('supply_orders.create', compact('product'));
    }

  public function store(SupplyOrderFormRequest $request)
{
    $validated = $request->validated();

    $validated['status'] = 'requested';
    $validated['registered_by_user_id'] = Auth::user()->id;



    $newSupplyOrder = SupplyOrder::create($validated);

    $productUrl = route('products.show', $validated['product_id']);
    $htmlMessage = "Ordem de reabastecimento para o produto <a href='$productUrl'><strong>{$newSupplyOrder->product->name}</strong></a> criada com sucesso!";

    return redirect()
        ->route('products.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
}



    public function updateStatus(Request $request, SupplyOrder $supplyOrder)
{
    $validated = $request->validate([
        'status' => 'required|in:requested,completed,canceled',
    ]);

    // Evita duplicar stock se já estiver 'completed'
    $wasCompleted = $supplyOrder->status === 'completed';

    $product = $supplyOrder->product;

    if (!$wasCompleted && $validated['status'] === 'completed') {
        $newStock = $product->stock + $supplyOrder->quantity;

        if ($newStock > $product->stock_upper_limit) {
            return redirect()
                ->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Error: Can´t exceed upper limit stock of({$product->stock_upper_limit}) in the product ({$product->name}).");
        }

        $product->stock = $newStock;
        $product->save();
    }

    $supplyOrder->status = $validated['status'];
    $supplyOrder->save();

    return redirect()
        ->back()
        ->with('alert-type', 'success')
        ->with('alert-msg', 'Estado atualizado com sucesso.');
}

    public function destroy(SupplyOrder $supplyOrder)
{
    if ($supplyOrder->status !== 'requested') {
        return redirect()->back()->with('alert-type', 'error')->with('alert-msg', 'Only requested orders can be deleted.');
    }

    $supplyOrder->delete();

    return redirect()->back()->with('alert-type', 'success')->with('alert-msg', 'Order deleted successfully.');
}
}
