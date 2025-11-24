<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OpenApiSpec;
use App\Services\WalletApiClient;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(OpenApiSpec $spec)
    {
        try {
            // Attempt to find operations tagged as 'user' (case-insensitive)
            $ops = $spec->operationsByTag('user');
            if (empty($ops)) {
                // also try 'users'
                $ops = $spec->operationsByTag('users');
            }
        } catch (\Throwable $e) {
            return view('admin.users', [
                'ops' => [],
                'baseUrl' => config('wallet.base_url'),
            ])->with('error', 'Failed to load OpenAPI: '.$e->getMessage());
        }

        return view('admin.users', [
            'ops' => $ops,
            'baseUrl' => config('wallet.base_url'),
        ]);
    }

    public function call(Request $request, OpenApiSpec $spec, WalletApiClient $client)
    {
        $operationId = $request->string('operationId');
        $op = $spec->findOperation($operationId);
        if (!$op) {
            return back()->with('error', 'Operation not found.');
        }

        $path = $this->injectPathParams($op['path'], $request->input('path', []));
        $query = $request->input('query', []);
        $body = $this->resolveBody($op['requestBody'] ?? null, $request->input('body'));

        $method = $op['method'];
        $response = $client->request($method, $path, $method === 'GET' ? [] : ($body ?? []), $query);

        $payload = [
            'status' => $response->status(),
            'ok' => $response->successful(),
            'headers' => $response->headers(),
            'body' => $response->json() ?? $response->body(),
        ];

        return back()->with([
            'result' => $payload,
            'lastOperationId' => $operationId,
        ]);
    }

    public function tags(OpenApiSpec $spec)
    {
        try {
            $tags = $spec->tags();
        } catch (\Throwable $e) {
            return view('admin.tags', ['tags' => []])->with('error', 'Failed to load OpenAPI: '.$e->getMessage());
        }
        return view('admin.tags', ['tags' => $tags]);
    }

    public function byTag(string $tag, OpenApiSpec $spec)
    {
        try {
            $ops = $spec->operationsByTag($tag);
        } catch (\Throwable $e) {
            return view('admin.users', ['ops' => [], 'baseUrl' => config('wallet.base_url')])->with('error', 'Failed to load OpenAPI: '.$e->getMessage());
        }
        return view('admin.users', ['ops' => $ops, 'baseUrl' => config('wallet.base_url')]);
    }

    // Curated executor for explicit UserController endpoints
    public function exec(Request $request, WalletApiClient $client)
    {
        $action = $request->string('action');

        try {
            switch ($action) {
                case 'register':
                    $validated = $request->validate([
                        'type' => 'required|string|in:INDIVIDUAL,CORPORATE',
                        'email' => 'required|string',
                        'firstName' => 'nullable|string',
                        'lastName' => 'nullable|string',
                        'companyName' => 'nullable|string',
                        'phone' => 'nullable|string',
                    ]);
                    $payload = array_filter([
                        'type' => $validated['type'],
                        'email' => $validated['email'],
                        'firstName' => $validated['firstName'] ?? null,
                        'lastName' => $validated['lastName'] ?? null,
                        'companyName' => $validated['companyName'] ?? null,
                        'phone' => $validated['phone'] ?? null,
                    ], fn($v) => !is_null($v) && $v !== '');
                    $resp = $client->request('POST', '/api/users', $payload);
                    break;

                case 'get':
                    $id = $request->string('id');
                    if ($id->isEmpty()) return back()->with('error', 'User ID is required');
                    $resp = $client->request('GET', '/api/users/'.$id);
                    break;

                case 'get_with_wallets':
                    $id = $request->string('id');
                    $currency = $request->string('currency');
                    if ($id->isEmpty()) return back()->with('error', 'User ID is required');
                    $resp = $client->request('GET', '/api/users/'.$id.'/with-wallets', [], [
                        'currency' => $currency->toString() ?: null,
                    ]);
                    break;

                case 'get_all_with_wallets':
                    $currency = $request->string('currency');
                    $resp = $client->request('GET', '/api/users/with-wallets', [], [
                        'currency' => $currency->toString() ?: null,
                    ]);
                    break;

                case 'list_wallets':
                    $id = $request->string('id');
                    $currency = $request->string('currency');
                    if ($id->isEmpty()) return back()->with('error', 'User ID is required');
                    $resp = $client->request('GET', '/api/users/'.$id.'/wallets', [], [
                        'currency' => $currency->toString() ?: null,
                    ]);
                    break;

                case 'create_wallet':
                    $validated = $request->validate([
                        'id' => 'required|string',
                        'currency' => 'required|string',
                        'name' => 'nullable|string',
                        'initialBalance' => 'nullable|numeric',
                    ]);
                    $id = $validated['id'];
                    $payload = array_filter([
                        'currency' => $validated['currency'],
                        'name' => $validated['name'] ?? null,
                        'initialBalance' => isset($validated['initialBalance']) ? (float)$validated['initialBalance'] : null,
                    ], fn($v) => !is_null($v) && $v !== '');
                    $resp = $client->request('POST', '/api/users/'.$id.'/wallets', $payload);
                    break;

                default:
                    return back()->with('error', 'Unknown action');
            }

            $payload = [
                'status' => $resp->status(),
                'ok' => $resp->successful(),
                'headers' => $resp->headers(),
                'body' => $resp->json() ?? $resp->body(),
            ];

            return back()->with('result', $payload);
        } catch (\Throwable $e) {
            return back()->with('error', 'Request failed: '.$e->getMessage());
        }
    }

    protected function injectPathParams(string $path, array $pathParams): string
    {
        foreach ($pathParams as $k => $v) {
            $path = str_replace('{'.$k.'}', urlencode((string) $v), $path);
        }
        return $path;
    }

    protected function resolveBody($requestBodySchema, $input)
    {
        if (is_string($input) && $input !== '') {
            $decoded = json_decode($input, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }
        if (is_array($input)) {
            return $input;
        }
        return null;
    }
}
