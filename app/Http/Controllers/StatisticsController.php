<?php

namespace App\Http\Controllers;



use App\Models\Product;
use App\Models\Categorie;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(): View
{
    $user = Auth::user();

    //Parte admin
    $totalProducts = Product::count();
    $totalCategories = Categorie::count();

    $numAdminsAtivos = User::where('type', 'board')->count();
    $numEmployeesAtivos = User::where('type', 'employee')->count();
    $numCustomersAtivos = User::where('type', 'member')->count();
    $numDeUserBloqueados = User::onlyTrashed()->count();

    $usersMasculino = User::where('gender', 'M')->count();
    $usersFeminino = User::where('gender', 'F')->count();

    $categories = Categorie::withCount('productRef')->get();
    $categoryLabels = $categories->pluck('name')->toArray();
    $categoryCounts = $categories->pluck('product_ref_count')->toArray();

    $purchasesData = Order::select(
        DB::raw('MONTH(date) as month'),
        DB::raw('YEAR(date) as year'),
        DB::raw('SUM(total) as total')
    )
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    $purchaseLabels = [];
    $purchaseTotals = [];

    foreach ($purchasesData as $row) {
        $purchaseLabels[] = Carbon::createFromDate($row->year, $row->month, 1)->format('M Y');
        $purchaseTotals[] = $row->total;
    }

   //Parte pessoal
    $orders = $user->orders()->with('items.product')->get();

    $totalSpent = $orders->sum('total');
    $totalOrders = $orders->count();
    $averagePerOrder = $totalOrders > 0 ? round($totalSpent / $totalOrders, 2) : 0;

    $productQuantities = [];
    foreach ($orders as $order) {
        foreach ($order->items as $item) {
            if ($item->product) {
                $productName = $item->product->name;
                $qty = $item->quantity;
                if (isset($productQuantities[$productName])) {
                    $productQuantities[$productName] += $qty;
                } else {
                    $productQuantities[$productName] = $qty;
                }
            }
        }
    }
    

    $monthlySpending = $orders->groupBy(function ($order) {
        return $order->date->format('Y-m');
    })->map(function ($group) {
        return $group->sum('total');
    });

    $monthlyLabels = $monthlySpending->keys()->map(function ($key) {
        return Carbon::createFromFormat('Y-m', $key)->format('M Y');
    })->toArray();
    $monthlyTotals = array_values($monthlySpending->toArray());

    return view('statistics.index', compact(
        // Globais
        'totalProducts',
        'totalCategories',
        'numAdminsAtivos',
        'numEmployeesAtivos',
        'numCustomersAtivos',
        'numDeUserBloqueados',
        'usersMasculino',
        'usersFeminino',
        'categoryLabels',
        'categoryCounts',
        'purchaseLabels',
        'purchaseTotals',

        // Pessoais
        'totalSpent',
        'totalOrders',
        'averagePerOrder',
        'productQuantities',
        'monthlyLabels',
        'monthlyTotals',
        'orders'
    ));
}

    
}
