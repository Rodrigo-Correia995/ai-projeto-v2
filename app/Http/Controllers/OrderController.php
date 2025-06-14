<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Operation;
use App\Models\Product;
use App\Mail\OrderCompletedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
        public function index()
    {
        
         $orders = Order::with('member')  // Eager load para evitar N+1
                    ->latest()
                    ->paginate(20); //20  por página
        
        return view('orders.index', compact('orders'));
    }

    public function complete(Order $order)
    {
        
        if ($order->status !== 'pending') {
            return back()->with('alert-msg', "A encomenda não pode ser completada.")
            ->with('alert-type', 'danger');
        }

        $outOfStock = $order->items()->with('product')->get()->filter(function ($item) {
            return $item->product->stock < $item->quantity;
        });

        if ($outOfStock->isNotEmpty()) {
            return back()->with('alert-msg', "A encomenda contém produtos sem stock suficiente.")
                ->with('alert-type', 'danger');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();
            }

            $order->status = 'completed';
            $order->save();

            
        });
        $pdf = Pdf::loadView('orders.receipt', ['order' => $order]);
        $fileName = $order->id . '_receipt.pdf';
        $filePath = 'receipts/' . $fileName;

        // Guardar PDF
        Storage::disk('public')->put($filePath, $pdf->output());

        // Guardar caminho na base de dados
        $order->pdf_receipt = $fileName;
        $order->save();

        // Enviar email com PDF em anexo
        Mail::to($order->member->email)->send(new OrderCompletedMail($order));

        
        return back()->with('alert-msg', "Encomenda completada com sucesso!")
                        ->with('alert-type', 'success');
    }

    public function cancel(Request $request, Order $order)
    {
         $request->validate([
        'reason' => 'required|string|max:1000',
        ]);

        if ($order->status !== 'pending') {
            return back()->with('alert-msg', "A encomenda não pode ser cancelada.")
                ->with('alert-type', 'danger');
        }

        DB::transaction(function () use ($order, $request) {
            $order->status = 'canceled';
            $order->cancel_reason = $request->reason;
            $order->save();

            $card = $order->member->cardRef;
            $card->balance += $order->total;
            $card->save();

            Operation::create([
                'card_id'           => $card->id,
                'type'              => 'credit',
                'value'            => $order->total,
                'date'              => now(),
                'credit_type'       => 'order_cancellation',
                'order_id'          => $order->id,
                
                
            ]);
    });

    return redirect()->route('orders.index')->with('alert-msg', "Encomenda cancelada com sucesso!")
                        ->with('alert-type', 'success');
    }


    public function showCancelForm(Order $order)
{
    if ($order->status !== 'pending') {
        return back()->with('error', 'Só é possível cancelar encomendas pendentes.');
    }

    return view('orders.cancel', compact('order'));
}
































}