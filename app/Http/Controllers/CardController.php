<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CardController extends Controller
{
    public function index(): View
    {
        $cards = Card::paginate(10);
        return view('cards.index')->with('cards', $cards);
    }

    public function create(): View
    {
        $newcard = new Card();
        return view('cards.create')->with('card', $newcard);
    }

    public function store(Request $request): RedirectResponse
    {
        Card::create($request->all());
        return redirect()->route('cards.index');
    }

    public function edit(Card $card): View
    {
        return view('cards.edit')->with('card', $card);
    }
    public function update(Request $request, Card $card): RedirectResponse
    {
        $card->update($request->all());
        return redirect()->route('cards.index');
    }

    public function destroy(Card $card): RedirectResponse
    {
        $card->delete();
        return redirect()->route('cards.index');
    }

    public function show(Card $card): View
    {
        return view('cards.show')->with('card', $card);
    }
}
