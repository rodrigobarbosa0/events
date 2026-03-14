<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Http;

class RegistrationController extends Controller
{
    public function subscribe(Event $event)
    {
        $user = auth()->user();

    // cria inscrição pendente
        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'amount' => $event->price,
            'status' => 'pending'
        ]);

        // cria pedido na pagar.me
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('PAGARME_SECRET_KEY') . ':'),
            'Content-Type' => 'application/json',
        ])->post('https://api.pagar.me/core/v5/orders', [
            "items" => [
                [
                    "amount" => $event->price,
                    "description" => "Inscrição no evento {$event->title}",
                    "quantity" => 1
                ]
            ],
            "customer" => [
                "name" => $user->name,
                "email" => $user->email,
                "type" => "individual",
            ],
            "payments" => [
                [
                    "payment_method" => "pix",
                    "pix" => [
                        "expires_in" => 3600
                    ]
                ]
            ]
        ]);

        $data = $response->json();

        $registration->update([
            'pagarme_order_id' => $data['id']
        ]);

        return response()->json([
            'qr_code' => $data['charges'][0]['last_transaction']['qr_code'],
            'qr_code_url' => $data['charges'][0]['last_transaction']['qr_code_url']
        ]);
    }
}
