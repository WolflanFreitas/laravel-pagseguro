<?php

return [
    'sandbox' => [
        'email' => env('PAGSEGURO_SANDBOX_EMAIL'),
        'token' => env('PAGSEGURO_SANDBOX_TOKEN'),
        'url' => 'https://sandbox.api.pagseguro.com/checkouts',
        'redirect_url' => 'https://vendas.sescma.com.br/cliente/listar/pedidos',
    ],
    'production' => [
        'email' => env('PAGSEGURO_PRODUCTION_EMAIL'),
        'token' => env('PAGSEGURO_PRODUCTION_TOKEN'),
        'url' => 'https://api.pagseguro.com/checkouts',
        'redirect_url' => 'https://vendas.sescma.com.br/cliente/listar/pedidos',
    ],
];