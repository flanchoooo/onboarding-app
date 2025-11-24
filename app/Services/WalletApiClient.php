<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class WalletApiClient
{
    protected PendingRequest $client;

    public function __construct()
    {
        $client = Http::baseUrl(config('wallet.base_url'))
            ->acceptJson()
            ->asJson();

        if ($token = env('WALLET_API_TOKEN')) {
            $client = $client->withToken($token);
        }

        $this->client = $client;
    }

    public function request(string $method, string $path, array $data = [], array $query = [])
    {
        $method = strtoupper($method);
        $client = $this->client;
        if (!empty($query)) {
            $client = $client->withQueryParameters($query);
        }
        if ($method === 'GET') {
            return $client->get($path, $data);
        }
        return $client->{$this->methodToFunction($method)}($path, $data);
    }

    protected function methodToFunction(string $method): string
    {
        return match ($method) {
            'POST' => 'post',
            'PUT' => 'put',
            'PATCH' => 'patch',
            'DELETE' => 'delete',
            default => 'post',
        };
    }
}
