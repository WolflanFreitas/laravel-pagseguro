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
}
