@extends('admin.layout')

@section('content')
@php($ops = $ops ?? [])
@php($grouped = collect($ops)->groupBy(fn($o) => $o['path']))

<h1 class="text-2xl font-bold text-gray-900 mb-4">Users - Admin</h1>
<p class="text-gray-600">Base URL: <span class="font-mono">{{ config('wallet.base_url') }}</span></p>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
  <div class="space-y-6">
    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
      <div class="border-b border-gray-200 px-4 py-2 font-semibold">Register user</div>
      <div class="p-4">
        <form method="post" action="{{ route('admin.users.exec') }}" class="grid grid-cols-1 md:grid-cols-2 gap-3">
          @csrf
          <input type="hidden" name="action" value="register" />

          <label class="block">
            <span class="block text-sm text-gray-700">Type</span>
            <select name="type" class="w-full rounded border-gray-300 text-sm">
              <option value="INDIVIDUAL">INDIVIDUAL</option>
              <option value="CORPORATE">CORPORATE</option>
            </select>
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">Email</span>
            <input name="email" type="email" class="w-full rounded border-gray-300 text-sm" required />
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">First name</span>
            <input name="firstName" class="w-full rounded border-gray-300 text-sm" />
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">Last name</span>
            <input name="lastName" class="w-full rounded border-gray-300 text-sm" />
          </label>
          <label class="block md:col-span-2">
            <span class="block text-sm text-gray-700">Company name</span>
            <input name="companyName" class="w-full rounded border-gray-300 text-sm" />
          </label>
          <label class="block md:col-span-2">
            <span class="block text-sm text-gray-700">Phone</span>
            <input name="phone" class="w-full rounded border-gray-300 text-sm" />
          </label>
          <div class="md:col-span-2">
            <button class="rounded bg-blue-600 text-white text-sm px-3 py-1.5 hover:bg-blue-700" type="submit">Register</button>
          </div>
        </form>
      </div>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
      <div class="border-b border-gray-200 px-4 py-2 font-semibold">Get user details</div>
      <div class="p-4">
        <form method="post" action="{{ route('admin.users.exec') }}" class="flex items-end gap-3">
          @csrf
          <input type="hidden" name="action" value="get" />
          <label class="block flex-1">
            <span class="block text-sm text-gray-700">User ID (UUID)</span>
            <input name="id" class="w-full rounded border-gray-300 text-sm" placeholder="e.g. 5f15d1c3-..." />
          </label>
          <button class="rounded bg-gray-900 text-white text-sm px-3 py-1.5 hover:bg-gray-800" type="submit">Fetch</button>
        </form>
      </div>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
      <div class="border-b border-gray-200 px-4 py-2 font-semibold">Get user with wallets</div>
      <div class="p-4">
        <form method="post" action="{{ route('admin.users.exec') }}" class="grid grid-cols-1 md:grid-cols-2 gap-3">
          @csrf
          <input type="hidden" name="action" value="get_with_wallets" />
          <label class="block">
            <span class="block text-sm text-gray-700">User ID (UUID)</span>
            <input name="id" class="w-full rounded border-gray-300 text-sm" />
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">Currency (optional)</span>
            <input name="currency" class="w-full rounded border-gray-300 text-sm" placeholder="e.g. USD" />
          </label>
          <div class="md:col-span-2">
            <button class="rounded bg-gray-900 text-white text-sm px-3 py-1.5 hover:bg-gray-800" type="submit">Fetch</button>
          </div>
        </form>
      </div>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
      <div class="border-b border-gray-200 px-4 py-2 font-semibold">List user wallets</div>
      <div class="p-4">
        <form method="post" action="{{ route('admin.users.exec') }}" class="grid grid-cols-1 md:grid-cols-2 gap-3">
          @csrf
          <input type="hidden" name="action" value="list_wallets" />
          <label class="block">
            <span class="block text-sm text-gray-700">User ID (UUID)</span>
            <input name="id" class="w-full rounded border-gray-300 text-sm" />
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">Currency (optional)</span>
            <input name="currency" class="w-full rounded border-gray-300 text-sm" placeholder="e.g. USD" />
          </label>
          <div class="md:col-span-2">
            <button class="rounded bg-gray-900 text-white text-sm px-3 py-1.5 hover:bg-gray-800" type="submit">List</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="space-y-6">
    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
      <div class="border-b border-gray-200 px-4 py-2 font-semibold">Get all users with wallets</div>
      <div class="p-4">
        <form method="post" action="{{ route('admin.users.exec') }}" class="flex items-end gap-3">
          @csrf
          <input type="hidden" name="action" value="get_all_with_wallets" />
          <label class="block flex-1">
            <span class="block text-sm text-gray-700">Currency (optional)</span>
            <input name="currency" class="w-full rounded border-gray-300 text-sm" placeholder="e.g. USD" />
          </label>
          <button class="rounded bg-gray-900 text-white text-sm px-3 py-1.5 hover:bg-gray-800" type="submit">Fetch</button>
        </form>
      </div>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
      <div class="border-b border-gray-200 px-4 py-2 font-semibold">Create user wallet</div>
      <div class="p-4">
        <form method="post" action="{{ route('admin.users.exec') }}" class="grid grid-cols-1 md:grid-cols-2 gap-3">
          @csrf
          <input type="hidden" name="action" value="create_wallet" />
          <label class="block">
            <span class="block text-sm text-gray-700">User ID (UUID)</span>
            <input name="id" class="w-full rounded border-gray-300 text-sm" />
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">Currency</span>
            <input name="currency" class="w-full rounded border-gray-300 text-sm" placeholder="e.g. USD" />
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">Name</span>
            <input name="name" class="w-full rounded border-gray-300 text-sm" placeholder="e.g. Primary" />
          </label>
          <label class="block">
            <span class="block text-sm text-gray-700">Initial balance</span>
            <input name="initialBalance" type="number" step="0.01" class="w-full rounded border-gray-300 text-sm" value="0" />
          </label>
          <div class="md:col-span-2">
            <button class="rounded bg-blue-600 text-white text-sm px-3 py-1.5 hover:bg-blue-700" type="submit">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="space-y-6 mt-10">
  @foreach($grouped as $path => $items)
    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-4 py-2 flex items-center justify-between">
            <div class="font-mono text-sm text-gray-700">{{ $path }}</div>
        </div>
        <div class="divide-y divide-gray-100">
        @foreach($items as $op)
            <div class="px-4 py-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-xs text-gray-500">{{ $op['method'] }}</div>
                        <div class="text-base font-semibold text-gray-900">{{ $op['summary'] ?: $op['operationId'] }}</div>
                        @if(!empty($op['description']))
                            <p class="text-sm text-gray-600 mt-1">{{ $op['description'] }}</p>
                        @endif
                    </div>
                    <span class="text-xs font-mono text-gray-500">{{ $op['operationId'] }}</span>
                </div>

                <form class="mt-3 space-y-3" method="post" action="{{ route('admin.users.call') }}">
                    @csrf
                    <input type="hidden" name="operationId" value="{{ $op['operationId'] }}"/>

                    @php($params = $op['parameters'] ?? [])
                    @php($pathParams = collect($params)->filter(fn($p) => ($p['in'] ?? '') === 'path'))
                    @php($queryParams = collect($params)->filter(fn($p) => ($p['in'] ?? '') === 'query'))

                    @if($pathParams->isNotEmpty())
                    <div>
                        <div class="text-xs font-semibold text-gray-700 mb-1">Path Params</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($pathParams as $p)
                                @php($name = $p['name'] ?? '')
                                <label class="block">
                                    <span class="block text-xs text-gray-600 mb-1">{{ $name }}{!! !empty($p['required']) ? ' <span class="text-red-600">*</span>' : '' !!}</span>
                                    <input class="w-full rounded border-gray-300 text-sm" name="path[{{ $name }}]" />
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($queryParams->isNotEmpty())
                    <div>
                        <div class="text-xs font-semibold text-gray-700 mb-1">Query Params</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($queryParams as $p)
                                @php($name = $p['name'] ?? '')
                                <label class="block">
                                    <span class="block text-xs text-gray-600 mb-1">{{ $name }}{!! !empty($p['required']) ? ' <span class="text-red-600">*</span>' : '' !!}</span>
                                    <input class="w-full rounded border-gray-300 text-sm" name="query[{{ $name }}]" />
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($op['requestBody']))
                    <div>
                        <div class="text-xs font-semibold text-gray-700 mb-1">Request Body (JSON)</div>
                        <textarea name="body" rows="6" class="w-full rounded border-gray-300 font-mono text-xs" placeholder='{
  "example": true
}'></textarea>
                    </div>
                    @endif

                    <button class="rounded bg-blue-600 text-white text-sm px-3 py-1.5 hover:bg-blue-700" type="submit">Send</button>
                </form>
            </div>
        @endforeach
        </div>
    </div>
@endforeach
</div>
@endsection
