@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <div class="rounded-lg border border-stone-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-emerald-700">Author profile</p>
                <h1 class="mt-2 text-3xl font-bold text-stone-900">{{ $author->name }}</h1>
            </div>
            <span class="rounded bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-800">{{ $author->position }}</span>
        </div>

        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <div class="rounded border border-stone-200 bg-stone-50 p-4">
                <p class="text-sm text-stone-500">Email</p>
                <p class="mt-1 font-medium text-stone-800">{{ $author->email }}</p>
            </div>
            <div class="rounded border border-stone-200 bg-stone-50 p-4">
                <p class="mt-1 text-2xl font-bold text-stone-900">{{ $author->comments()->count() }} comments received</p>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="mb-4 text-2xl font-bold text-stone-900">Published posts</h2>
        @if ($author->posts->isEmpty())
            <div class="rounded-lg border border-stone-200 bg-white p-6 text-stone-600 shadow-sm">No posts from this author yet.</div>
        @else
            <div class="space-y-4">
                @foreach ($author->posts as $post)
                    <div class="rounded-lg border border-stone-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <a href="{{ route('posts.show', $post) }}" class="text-xl font-semibold text-stone-900 hover:text-emerald-700">{{ $post->title }}</a>
                            <span class="text-sm text-stone-500">{{ $post->comments_count }} comments</span>
                        </div>
                        <p class="mt-2 text-sm text-stone-600">{{ $post->published_at?->format('F j, Y') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
