<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Wallet Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-full bg-gray-50">
<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-gray-800 font-semibold">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">Users</a>
        </div>
        <div class="text-xs text-gray-500">API: <span class="font-mono">{{ config('wallet.base_url') }}</span></div>
    </div>
    @if(session('error'))
        <div class="mx-auto max-w-7xl px-4 py-2 text-sm bg-red-50 text-red-700">{{ session('error') }}</div>
    @endif
</nav>

<main class="max-w-7xl mx-auto px-4 py-6">
    @yield('content')
    @if(session('result'))
        @php($flash = session('result'))
        <div class="mt-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Last Response</h2>
                <span class="text-xs text-gray-600">Status: {{ $flash['status'] }}</span>
            </div>
            <pre class="mt-3 bg-gray-900 text-gray-100 text-xs p-3 rounded overflow-auto"><code>{{ is_string($flash['body']) ? $flash['body'] : json_encode($flash['body'], JSON_PRETTY_PRINT) }}</code></pre>
        </div>
    @endif
</main>
</body>
</html>
