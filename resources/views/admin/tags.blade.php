@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-4">OpenAPI Tags</h1>
<p class="text-gray-600 mb-6">Browse all controller tags exposed by the Wallet API.</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
@foreach($tags as $tag)
    <a href="{{ route('admin.byTag', ['tag' => $tag]) }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:border-gray-300">
        <div class="text-lg font-semibold text-gray-900">{{ $tag }}</div>
        <div class="text-sm text-gray-600 mt-1">View operations</div>
    </a>
@endforeach
</div>
@endsection

