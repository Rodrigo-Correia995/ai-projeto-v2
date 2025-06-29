<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\Payment;
use App\Models\Operation;
use App\Models\Order;

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
//funcao utilizada para carregar o cartao
public function charge(Request $request): RedirectResponse
{
    //recebe do fomulario 1 ou 2 variaveis
    $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'cvc_code' => 'nullable|digits:3'
    ]);
    //retira os dados de quem está logado
    $user = Auth::user();
    $card = $user->cardRef;

    $method = $user->default_payment_type;
    $data = $user->default_payment_reference;
    $cvc = $request->cvc_code;

    // valida pagamento aptraves da função payment fornecida
    $isValid = match ($method) {
        'Visa' => Payment::payWithVisa($data, $cvc),
        'PayPal' => Payment::payWithPaypal($data),
        'MB WAY' => Payment::payWithMBway($data),
        default => false,
    };
    //da erro se for invalido ou não estiver predefinido
    if (!$isValid) {
        return back()->withErrors(['payment' => 'Método de pagamento inválido. Ou não predefinido']);
    }

    // atualiza o balance
    $card->balance += $request->amount;
    $card->save();
    //cria a operação correspondente
    Operation::create([
                'card_id'           => $card->id,
                'type'              => 'credit',
                'value'            => $request->amount,
                'date'              => now(),
                'credit_type'       => 'payment',
           ]);
    //devolve mensagem cartão carregado com sucesso
    return back()->with('success', 'Cartão carregado com sucesso!');
}

}
