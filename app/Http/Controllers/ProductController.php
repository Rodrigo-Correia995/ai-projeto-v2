<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StockAdjustment;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $filterByName = $request->query('name');
        $filterByCategory = (string)$request->query('category');
        $filterByPriceMin = $request->query('priceMin');
        $filterByPriceMax = $request->query('priceMax');
        $onlyStockAlerts = $request->query('stockAlertOnly');

        $productQuery = Product::query();

        if ($filterByName) {
            $productQuery->where('name', 'like', '%' . $filterByName . '%');
        }

        if (!empty($filterByCategory)) {
            $productQuery->where('category_id', $filterByCategory);
        }

        if (!is_null($filterByPriceMin)) {
            $productQuery->where('price', '>=', $filterByPriceMin);
        }

        if (!is_null($filterByPriceMax)) {
            $productQuery->where('price', '<=', $filterByPriceMax);
        }

        if ($onlyStockAlerts) {
            $productQuery->where(function ($query) {
                $query->whereColumn('stock', '<', 'stock_lower_limit')
                    ->orWhereColumn('stock', '>', 'stock_upper_limit');
            });
        }
        $allProducts = $productQuery->orderBy('name')->paginate(20)->withQueryString();
        $listCategories = [0 => 'Any category'] + Categorie::orderBy('name')->pluck('name', 'id')->toArray();


        return view('products.index', compact(
            'allProducts',
            'filterByName',
            'filterByCategory',
            'filterByPriceMin',
            'filterByPriceMax',
            'listCategories'
        ));
    }

    public function create(): View
    {
        $product = new Product();
        $categories = Categorie::orderBy('name')->get();
        return view('products.create', compact('product', 'categories'));
    }


    public function store(ProductFormRequest $request): RedirectResponse
    {
        $newProduct = Product::create($request->validated());
        $url = route('products.show', ['product' => $newProduct]);
        $htmlMessage = "Product <a href='$url'><strong>{$newProduct->name}</strong></a> has been created successfully!";
        return redirect()->route('products.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Product $product): View
    {
        $categories = Categorie::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(ProductFormRequest $request, Product $product): RedirectResponse
    {
        $validatedData = $request->validated();
        $oldStock = (int)$product->stock;

        $product->update($validatedData);

        $newStock = (int)$product->stock;

        if ($request->has('stock') && $newStock !== $oldStock) {
            StockAdjustment::create([
                'product_id' => $product->id,
                'registered_by_user_id' => Auth::user()->id,
                'quantity_changed' => $newStock - $oldStock,
            ]);
        }

        $url = route('products.show', ['product' => $product]);
        $htmlMessage = "Product <a href='$url'><strong>{$product->name}</strong></a> has been updated successfully!";

        return redirect()->route('products.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index');
    }

    public function show(Product $product): View
    {
        $categories = Categorie::orderBy('name')->get();
        return view('products.show', compact('product', 'categories'));
    }
}
