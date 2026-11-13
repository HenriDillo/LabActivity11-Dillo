@extends('layouts.app')

@section('title', $post->title . ' – Barangay Bulletin – Purok Dillo')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-emerald-700 hover:underline">&larr; Back to all posts</a>

    <article class="mt-4 rounded-lg border border-stone-200 bg-white p-5 shadow-sm sm:p-8">
        <div class="mb-3 flex flex-wrap items-center gap-2">
            @if ($post->is_pinned)
                <span class="rounded bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">Pinned</span>
            @endif
            <span class="rounded bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">{{ $post->category }}</span>
        </div>

        <h1 class="text-2xl font-bold sm:text-3xl">{{ $post->title }}</h1>
        <p class="mt-2 text-sm text-stone-500">
            {{ $post->published_at->format('F d, Y') }} &middot;
            <a href="{{ route('authors.show', $post->author) }}" class="hover:text-emerald-800">{{ $post->author->name }}</a>
            &middot; {{ $post->views }} views
        </p>

        @if ($post->tags->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="mt-6 space-y-4 leading-relaxed">
            @foreach (preg_split('/\R{2,}/', $post->body) as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </article>

    <section class="mt-6 rounded-lg border border-stone-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-xl font-semibold">Comments</h2>
            <span class="text-sm text-stone-500">{{ $post->comments->count() }} total</span>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($post->comments->isNotEmpty())
            <div class="space-y-4">
                @foreach ($post->comments as $comment)
                    <div class="rounded border border-stone-200 bg-stone-50 p-4">
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm text-stone-500">
                            <span class="font-semibold text-stone-800">{{ $comment->user->name }}</span>
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p>{{ $comment->body }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-stone-500">No comments yet. Be the first resident to share thoughts.</p>
        @endif

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="body" class="label">Write a comment</label>
                    <textarea id="body" name="body" rows="4" class="input" required>{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="rounded bg-emerald-700 px-4 py-2 text-sm text-white hover:bg-emerald-800">Post comment</button>
            </form>
        @else
            <p class="mt-6 text-sm text-stone-600"><a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:underline">Sign in to comment</a>.</p>
        @endauth
    </section>
@endsection
