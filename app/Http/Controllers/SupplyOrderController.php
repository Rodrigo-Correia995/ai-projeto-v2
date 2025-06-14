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

        $product = Product::findOrFail($validated['product_id']);
        $futureStock = $product->stock + $validated['quantity'];
        $htmlMessage = "Error: Restocking would exceed the maximum stock limit of {$product->stock_upper_limit} for the product {$product->name}.";
        
        if ($futureStock > $product->stock_upper_limit) {
            

            return redirect()
                ->route('supply_orders.create', ['product' => $product->id])
                ->withInput()
                ->with('alert-type', 'danger')
                ->with('alert-msg', $htmlMessage);
        }
        
        $validated['status'] = 'requested';
        $validated['registered_by_user_id'] = Auth::id();

        SupplyOrder::create($validated);

        $productUrl = route('products.show', $product->id);
        $htmlMessage = "Supply order for product <a href='$productUrl'><strong>{$product->name}</strong></a> created successfully!";

        return redirect()
            ->route('products.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    
    public function updateStatus(Request $request, SupplyOrder $supplyOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:requested,completed',
        ]);

        $wasCompleted = $supplyOrder->status === 'completed';
        $product = $supplyOrder->product;
        $htmlMessage = "Error: Cannot exceed the maximum stock limit of {$product->stock_upper_limit} for the product {$product->name}.";

        if (!$wasCompleted && $validated['status'] === 'completed') {
            $newStock = $product->stock + $supplyOrder->quantity;

            if ($newStock > $product->stock_upper_limit) {
                return redirect()
                    ->back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', $htmlMessage);
            }

            $product->stock = $newStock;
            $product->save();
        }

        $supplyOrder->status = $validated['status'];
        $supplyOrder->save();

        return redirect()
            ->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Status updated successfully.');
    }

    
    public function destroy(SupplyOrder $supplyOrder)
    {
        if ($supplyOrder->status !== 'requested') {
            return redirect()->back()
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Only supply orders with status "requested" can be deleted.');
        }

        $supplyOrder->delete();

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Supply order deleted successfully.');
    }
}
