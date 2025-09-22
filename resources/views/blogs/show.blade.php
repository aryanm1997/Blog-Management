@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">{{ $blog->title }}</h1>

    {{-- Blog Image --}}
    @if ($blog->image)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $blog->image) }}" 
                 alt="Blog Image" 
                 class="img-fluid rounded shadow" style="height: 200px;">
        </div>
    @endif

    {{-- Blog Content --}}
    <div class="mb-4">
        <p>{{ $blog->content }}</p>
    </div>

    {{-- Blog Meta Info --}}
    <div class="text-muted mb-4">
        <small>
            Posted by {{ $blog->user->name ?? 'Unknown' }}  
            on {{ $blog->created_at->format('d M Y') }}
        </small>
    </div>

    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Back to Blogs</a>
</div>
@endsection
