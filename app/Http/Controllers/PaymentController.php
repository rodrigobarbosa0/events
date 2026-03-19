<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;

class PaymentController extends Controller
{
    public function showPayment($id){
        $event = Event::findOrFail($id);
        return view('events.payment', compact('event'));
    }

    public function processPayment(Request $request){
        // validação
        $request->validate([
            'token' => 'required',
            'payment_method_id' => 'required',
            'email' => 'required|email',
            'event_id' => 'required|exists:events,id'
        ]);

        try{
        $event = Event::findOrFail($request->event_id);
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
        
        $client = new PaymentClient();

        $payment = $client->create([
            "transaction_amount" => (float) $event->price,
            "token" => $request->token,
            "description" => "Pagamento evento: " . $event->title,
            "installments" => 1,
            "payment_method_id" => $request->payment_method_id,
            "payer" => [
                "email" => $request->email,
            ],
        ]);

        if ($payment->status === 'approved') {
            $event->users()->syncWithoutDetaching([auth()->id()]);
        }

        return response()->json([
                'status' => $payment->status,
                'payment_id' => $payment->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}