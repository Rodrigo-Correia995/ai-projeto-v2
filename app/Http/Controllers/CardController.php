<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index(Request $request): View
    {
        $filterById = $request->query('id');
        $filterByCardNumber = $request->query('card_number');

        $cardQuery = Card::query();

        if ($filterByCardNumber) {
            $cardQuery->where('card_number', $filterByCardNumber);
        }
        if ($filterById) {
            $cardQuery->where('id', $filterById);
        }

        $cards = $cardQuery->orderBy('id')->paginate(10)->withQueryString();

       return view('cards.index', compact(
            'cards',
            'filterByCardNumber',
            'filterById',
        ));
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

 public function mycard()
{
    $user = Auth::user();

    $card = $user->cardRef;

    return view('cards.mycard', compact('card'));
}

}
