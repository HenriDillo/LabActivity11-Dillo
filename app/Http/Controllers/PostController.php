<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private const PER_PAGE = 6;

    public function index(Request $request)
    {
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->input('q').'%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->input('category'));
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', fn ($tagQuery) => $tagQuery->where('name', $request->input('tag')));
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $categories = Post::query()->distinct()->orderBy('category')->pluck('category');
        $tags = Tag::query()->orderBy('name')->pluck('name');

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function create()
    {
        $tags = Tag::query()->orderBy('name')->get();

        return view('posts.create', compact('tags'));
    }

    public function store(StorePostRequest $request)
    {
        $author = Auth::user()->author;

        $validated = $request->validated();
        $tagIds = $validated['tags'];
        unset($validated['tags']);

        $isPublished = (bool) $validated['is_published'];
        $validated['is_pinned'] = false;
        $validated['published_at'] = $isPublished ? now() : null;

        $post = $author->posts()->create($validated);
        $post->tags()->sync($tagIds);

        if (! $isPublished) {
            return redirect()->route('posts.index')->with('success', 'Draft saved successfully.');
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post published successfully.');
    }

    public function show(Post $post)
    {
        $post = Post::query()
            ->where('is_published', true)
            ->findOrFail($post->id);

        $post->increment('views');
        $post->load(['author', 'tags', 'comments.user']);

        return view('posts.show', compact('post'));
    }
}
