<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OpenApiSpec
{
    protected string $baseUrl;
    protected ?string $overrideUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('wallet.base_url'), '/');
        $this->overrideUrl = config('wallet.openapi_url');
    }

    public function fetch(): array
    {
        return Cache::remember('wallet.openapi', now()->addMinutes(5), function () {
            $url = $this->overrideUrl ?: $this->baseUrl.'/v3/api-docs';
            $http = Http::acceptJson();
            if ($token = env('WALLET_API_TOKEN')) {
                $http = $http->withToken($token);
            }
            $resp = $http->get($url);
            if (!$resp->successful()) {
                throw new \RuntimeException('Failed to fetch OpenAPI spec: '.$resp->status());
            }
            return $resp->json() ?: [];
        });
    }

    public function operationsByTag(string $tag): array
    {
        $spec = $this->fetch();
        $paths = $spec['paths'] ?? [];
        $ops = [];
        foreach ($paths as $path => $methods) {
            foreach ($methods as $method => $op) {
                if (!is_array($op)) continue;
                $tags = array_map('strtolower', $op['tags'] ?? []);
                if (in_array(strtolower($tag), $tags)) {
                    $ops[] = $this->normalizeOperation($path, strtoupper($method), $op);
                }
            }
        }
        return $ops;
    }

    public function tags(): array
    {
        $spec = $this->fetch();
        $declared = array_map(fn($t) => $t['name'] ?? null, $spec['tags'] ?? []);
        $declared = array_filter($declared);

        $fromOps = [];
        foreach (($spec['paths'] ?? []) as $methods) {
            foreach ($methods as $op) {
                foreach (($op['tags'] ?? []) as $t) {
                    $fromOps[] = $t;
                }
            }
        }
        $tags = array_values(array_unique(array_merge($declared, $fromOps)));
        sort($tags);
        return $tags;
    }

    public function findOperation(string $operationId): ?array
    {
        $spec = $this->fetch();
        foreach (($spec['paths'] ?? []) as $path => $methods) {
            foreach ($methods as $method => $op) {
                if (($op['operationId'] ?? null) === $operationId) {
                    return $this->normalizeOperation($path, strtoupper($method), $op);
                }
            }
        }
        return null;
    }

    protected function normalizeOperation(string $path, string $method, array $op): array
    {
        return [
            'operationId' => $op['operationId'] ?? md5($method.' '.$path),
            'summary' => $op['summary'] ?? '',
            'description' => $op['description'] ?? '',
            'tags' => $op['tags'] ?? [],
            'path' => $path,
            'method' => $method,
            'parameters' => $op['parameters'] ?? [],
            'requestBody' => $op['requestBody'] ?? null,
        ];
    }
}
