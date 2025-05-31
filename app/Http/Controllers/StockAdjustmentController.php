<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProductFormRequest;
use App\Models\StockAdjustment;

class StockAdjustmentController extends Controller
{
    public function index(): View
    {
        $allStockAdjustments = StockAdjustment::with(['product', 'registeredBy'])->latest()->paginate(10);
        return view('stock_adjustments.index', [
            'stock_adjustments' => $allStockAdjustments
        ]);
    }

    public function show(StockAdjustment $stockAdjustment): View
    {
        return view('stockAdjustments.show', compact('stockAdjustment'));
    }
}
