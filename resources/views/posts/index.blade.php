@extends('layouts.app')

@section('title', 'Barangay Bulletin – Purok Dillo')

@section('content')
    <form method="GET" action="{{ route('posts.index') }}" class="mb-6 flex flex-col gap-2 sm:flex-row">
        <input name="q" value="{{ request('q') }}" placeholder="Search title"
               class="flex-1 rounded border border-stone-300 bg-white px-3 py-2">
        <select name="category" class="rounded border border-stone-300 bg-white px-3 py-2">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
            @endforeach
        </select>
        <select name="tag" class="rounded border border-stone-300 bg-white px-3 py-2">
            <option value="">All tags</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag }}" @selected(request('tag') === $tag)>{{ $tag }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded bg-emerald-700 px-4 py-2 text-white hover:bg-emerald-800">Filter</button>
    </form>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        @forelse ($posts as $post)
            <article class="rounded-lg border bg-white p-4 shadow-sm {{ $post->is_pinned ? 'border-amber-400' : 'border-stone-200' }}">
                <div class="mb-2 flex flex-wrap items-center gap-2">
                    @if ($post->is_pinned)
                        <span class="rounded bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">Pinned</span>
                    @endif
                    <span class="rounded bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">{{ $post->category }}</span>
                </div>
                <h2 class="text-lg font-semibold">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">{{ $post->title }}</a>
                </h2>
                <p class="mt-2 text-sm text-stone-500">
                    {{ $post->published_at->format('M d, Y') }} &middot;
                    <a href="{{ route('authors.show', $post->author) }}" class="hover:text-emerald-800">{{ $post->author->name }}</a>
                    &middot; {{ $post->views }} views
                </p>
                @if ($post->tags->isNotEmpty())
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif
                <p class="mt-3 text-sm text-stone-500">
                    {{ $post->comments_count }} {{ $post->comments_count === 1 ? 'comment' : 'comments' }}
                </p>
            </article>
        @empty
            <p class="text-stone-500 md:col-span-2">No posts match your search.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>

    <p class="mt-2 text-sm text-stone-500">
        Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts
    </p>
@endsection
