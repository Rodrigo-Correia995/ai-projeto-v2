<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OperationController extends Controller
{
    public function index(Request $request): View
    {
        $filterById = $request->query('id');
        $filterByCardId = $request->query('card_id');

        $operationQuery = Operation::query();

        if ($filterByCardId) {
            $operationQuery->where('card_id', $filterByCardId);
        }
        if ($filterById) {
            $operationQuery->where('id', $filterById);
        }

        $operations = $operationQuery->orderBy('id')->paginate(10)->withQueryString();
        return view('operations.index', compact(
            'operations',
            'filterByCardId',
            'filterById',
        ));
    }

    public function create(): View
    {
        $newOperation = new Operation();
        return view('operations.create')->with('operation', $newOperation);
    }

    public function store(Request $request): RedirectResponse
    {
        Operation::create($request->all());
        return redirect()->route('operations.index');
    }

    public function edit(Operation $operation): View
    {
        return view('operations.edit')->with('operation', $operation);
    }
    public function update(Request $request, Operation $operation): RedirectResponse
    {
        $operation->update($request->all());
        return redirect()->route('operations.index');
    }

    public function destroy(Operation $operation): RedirectResponse
    {
        $operation->delete();
        return redirect()->route('operations.index');
    }

    public function show(Operation $operation): View
    {
        return view('operations.show')->with('operation', $operation);
    }
}
