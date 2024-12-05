<?php

namespace App\Service;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;

class PagSeguro
{
    public function createCheckout($paymentParams)
    {   
        $client = new Client();

        $expirationDate = Carbon::now()->addYear()->format('Y-m-d\TH:i:sP');

        $sandbox = true;

        if ($sandbox) {
            $url = config('pagseguro.sandbox.url');
            $token = config('pagseguro.sandbox.token');
            $redirectUrl = config('pagseguro.sandbox.redirect_url');
        } else {
            $url = config('pagseguro.production.url');
            $token = config('pagseguro.production.token');
            $redirectUrl = config('pagseguro.production.redirect_url');
        }

        $body = [
            'customer' => $paymentParams['customer'],
            'reference_id' => Str::uuid(),
            'expiration_date' => $expirationDate,
            'customer_modifiable' => false,
            'items' => $paymentParams['items'],
            'soft_descriptor' => 'SescMA',
            'redirect_url' => $redirectUrl,
            'notification_urls' => ['https://hn7sdi.tunnel.pyjam.as/api/notification'],
            'payment_notification_urls' => ['https://hn7sdi.tunnel.pyjam.as/api/payment-notification'],
        ];

        $response = $client->request('POST', $url, [
            'body' => json_encode($body),
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-type' => 'application/json',
                'accept' => '*/*',
            ],
        ]);

        $response = json_decode($response->getBody()->getContents());

        $checkout = [
            'payment_link' => $response->links[1]->href,
            'reference_id' => $response->reference_id,
            'code' => $response->id,
        ];

        return $checkout;
    }
}
