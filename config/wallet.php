<?php

return [
    // Base URL of the Wallet API; override via WALLET_API_BASE_URL in .env
    'base_url' => env('WALLET_API_BASE_URL', 'http://localhost:8080'),

    // OpenAPI spec URL; defaults to {base_url}/v3/api-docs
    'openapi_url' => env('WALLET_OPENAPI_URL', null),

    // Define known endpoints to display on the dashboard.
    // Update this list to match your wallet service.
    'endpoints' => [
        [
            'key' => 'health',
            'name' => 'Health',
            'method' => 'GET',
            'path' => '/health',
            'description' => 'Service health check',
            'body' => null,
        ],
        [
            'key' => 'balance',
            'name' => 'Get Balance',
            'method' => 'GET',
            'path' => '/api/wallet/balance',
            'description' => 'Fetch current wallet balance',
            'body' => null,
        ],
        [
            'key' => 'transactions',
            'name' => 'List Transactions',
            'method' => 'GET',
            'path' => '/api/wallet/transactions',
            'description' => 'List recent transactions',
            'body' => null,
        ],
        [
            'key' => 'transfer',
            'name' => 'Transfer Funds',
            'method' => 'POST',
            'path' => '/api/wallet/transfer',
            'description' => 'Transfer funds between accounts',
            'body' => [
                'to' => '',
                'amount' => 0,
                'currency' => 'USD',
            ],
        ],
    ],
];
