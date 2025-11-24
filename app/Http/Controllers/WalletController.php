<?php

namespace App\Http\Controllers;

use App\Services\WalletApiClient;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $endpoints = collect(config('wallet.endpoints'));
        return view('dashboard', [
            'endpoints' => $endpoints,
            'baseUrl' => config('wallet.base_url'),
        ]);
    }

    public function register()
    {
        // Serve a dedicated registration page
        return view('register');
    }

    public function call(Request $request, WalletApiClient $client)
    {
        $endpointKey = $request->string('key');
        $endpoints = collect(config('wallet.endpoints'));
        $endpoint = $endpoints->firstWhere('key', $endpointKey);

        if (!$endpoint) {
            return back()->with('error', 'Endpoint not found.');
        }

        $method = $endpoint['method'] ?? 'GET';
        $path = $endpoint['path'] ?? '/';
        $body = $request->input('body', $endpoint['body'] ?? []);

        $payload = is_array($body) ? $body : [];
        $query = $method === 'GET' ? $payload : [];
        $response = $client->request($method, $path, $method === 'GET' ? [] : $payload, $query);

        $payload = [
            'status' => $response->status(),
            'ok' => $response->successful(),
            'headers' => $response->headers(),
            'body' => $this->safeJson($response->json(), $response->body()),
        ];

        return back()->with([
            'result' => $payload,
            'lastEndpoint' => $endpointKey,
        ]);
    }

    protected function safeJson($json, string $fallback)
    {
        return $json ?? $fallback;
    }
}
