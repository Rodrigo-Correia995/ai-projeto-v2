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
        // Validação e autorização já feitas pela FormRequest
        $validated = $request->validated();

        $supplyOrder = new SupplyOrder($validated);
        $supplyOrder->registered_by_user_id = Auth::id();
        $supplyOrder->save();

        // A criação de ordens não deve alterar stock — será feito apenas quando status for alterado para 'completed'

        return redirect()
            ->route('products.show', $supplyOrder->product_id)
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Ordem de reabastecimento criada com sucesso.');
    }

    public function updateStatus(Request $request, SupplyOrder $supplyOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:requested,completed,canceled',
        ]);

        // Se o estado já for 'completed', evitar duplicar stock
        $wasCompleted = $supplyOrder->status === 'completed';

        $supplyOrder->status = $validated['status'];
        $supplyOrder->save();

        // Atualiza stock apenas se for alterado para 'completed' pela primeira vez
        if (!$wasCompleted && $supplyOrder->status === 'completed') {
            $product = $supplyOrder->product;
            $product->stock += $supplyOrder->quantity;
            $product->save();
        }

        return redirect()
            ->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Estado atualizado com sucesso.');
    }

    public function destroy(SupplyOrder $supplyOrder)
    {
        if ($supplyOrder->status !== 'requested') {
            return redirect()->back()->with('alert-type', 'error')->with('alert-msg', 'Só é possível eliminar ordens com estado "requested".');
        }

        $supplyOrder->delete();

        return redirect()->back()->with('alert-type', 'success')->with('alert-msg', 'Ordem eliminada com sucesso.');
    }
}
