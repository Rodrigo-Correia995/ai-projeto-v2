<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;

class CategorieController extends Controller
{
    public function index(): View
    {
        $allCategories = Categorie::paginate(5); 
        return view('categories.index')->with('categories', $allCategories);
    }

    public function create(): View
    {
        $newCategorie = new Categorie();
        return view('categories.create')->with('categorie', $newCategorie);
    }

    

    public function store(Request $request): RedirectResponse
    {
        Categorie::create($request->all());
        return redirect()->route('categories.index');
    }

    public function edit(Categorie $categorie): View
    {
        return view('categories.edit')->with('categorie', $categorie);
    }

    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $categorie->update($request->all());
        return redirect()->route('categories.index');
    }

    public function destroy(Categorie $categorie): RedirectResponse
    {
        $categorie->delete();
        return redirect()->route('categories.index');
    }

    public function show(Categorie $categorie): View
    {
        return view('categories.show')->with('categorie', $categorie);
    }
}
