<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function index()
    {
        $pagSeguro = new \App\Service\PagSeguro();

        $paymentParams = [
            'customer' => [
                'phone' => [
                    'country' => '+55',
                    'area' => '98',
                    'number' => '989071497'
                ],
                'name' => 'Camila Luiza da Silva',
                'email' => 'camila@gmail.com',
                'tax_id' => '12345678909'
            ],
            'items' => [
                [
                    'reference_id' => '1',
                    'name' => 'Almoço',
                    'description' => 'Almoço',
                    'quantity' => 1,
                    'unit_amount' => 728
                ]
            ],
        ];
        
        $checkout = $pagSeguro->createCheckout($paymentParams);

        $payment = \App\Models\Payment::create([
            'code' => $checkout['code'],
            'reference_id' => $checkout['reference_id'],
            'status' => 'WAITING',
            'payment_link' => $checkout['payment_link']
        ]);

        dd($payment);
    }

    public function notification(Request $request)
    {
        // Escrever em log o retorno da notificação do PagSeguro
        \Log::info('Notificação recebida');
        \Log::info(json_decode($request->all()));
    }

    public function paymentNotification(Request $request)
    {
        \Log::info('Notificação de pagamento recebida');
        \Log::info('Dados recebidos', ['data' => $request->all()]);

        $orderId = $request->input('id');
        $referenceId = $request->input('reference_id');
        $chargeStatus = $request->input('charges.0.status');
        $chargeCode = $request->input('charges.0.id');
        $paymentMethod = $request->input('charges.0.payment_method.type');

        \Log::info("Pedido processado", [
            'order_id' => $orderId,
            'reference_id' => $referenceId,
            'charge_status' => $chargeStatus,
            'charge_code' => $chargeCode,
            'payment_method' => $paymentMethod
        ]);

        return response()->json(['message' => 'Notificação processada com sucesso'], 200);
    }
}
