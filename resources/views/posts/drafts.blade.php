@extends('layouts.app')

@section('title', 'My Drafts – Barangay Bulletin – Purok Dillo')

@section('content')
    <div class="mb-6 flex flex-col gap-4 rounded-lg border border-stone-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">Author workspace</p>
            <h1 class="mt-1 text-2xl font-bold text-stone-900">My drafts</h1>
            <p class="mt-1 text-sm text-stone-600">Drafts are private to you until you publish them.</p>
        </div>
        <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center rounded bg-emerald-700 px-4 py-2 text-sm text-white hover:bg-emerald-800">
            + New post
        </a>
    </div>

    @if ($posts->isEmpty())
        <div class="rounded-lg border border-dashed border-stone-300 bg-white px-6 py-12 text-center shadow-sm">
            <h2 class="text-lg font-semibold text-stone-800">No drafts yet</h2>
            <p class="mt-2 text-sm text-stone-600">Save a post without publishing it, and it will appear here.</p>
            <a href="{{ route('posts.create') }}" class="mt-5 inline-flex rounded bg-emerald-700 px-4 py-2 text-sm text-white hover:bg-emerald-800">
                Write a post
            </a>
        </div>
    @else
        <div class="mb-3 text-sm text-stone-500">
            {{ $posts->total() }} {{ $posts->total() === 1 ? 'draft' : 'drafts' }}
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($posts as $post)
                <article class="rounded-lg border border-amber-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">Draft</span>
                        <span class="rounded bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">{{ $post->category }}</span>
                    </div>

                    <h2 class="mt-3 text-lg font-semibold text-stone-900">{{ $post->title }}</h2>
                    <p class="mt-1 text-xs text-stone-500">Last saved {{ $post->updated_at->diffForHumans() }}</p>
                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-stone-600">{{ $post->body }}</p>

                    @if ($post->tags->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($post->tags as $tag)
                                <span class="badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4 border-t border-stone-200 pt-4">
                        <a href="{{ route('posts.edit', $post) }}" class="font-semibold text-emerald-800 hover:underline">
                            Continue editing &amp; publish
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">{{ $posts->links() }}</div>
    @endif
@endsection
