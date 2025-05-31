<?php

namespace App\Http\Controllers;

use App\Models\ShippingCost;
use App\Http\Requests\ShippingCostFormRequest;

class ShippingCostController extends Controller
{
    public function index()
    {
        $shippingCosts = ShippingCost::orderBy('min_value_threshold')->get();
        return view('shipping_costs.index', compact('shippingCosts'));
    }

    public function create()
    {
        return view('shipping_costs.create');
    }

    public function store(ShippingCostFormRequest $request)
    {
        ShippingCost::create($request->validated());

        return redirect()->route('shipping_costs.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shipping cost added successfully!');
    }

    public function edit(ShippingCost $shipping_cost)
    {
        return view('shipping_costs.edit', compact('shipping_cost'));
    }

    public function update(ShippingCostFormRequest $request, ShippingCost $shipping_cost)
    {
        $shipping_cost->update($request->validated());

        return redirect()->route('shipping_costs.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shipping cost updated successfully!');
    }

    public function destroy(ShippingCost $shipping_cost)
    {
        $shipping_cost->delete();

        return redirect()->route('shipping_costs.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shipping cost deleted successfully!');
    }
}
