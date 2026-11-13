<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function show(Author $author)
    {
        $author->load([
            'user',
            'posts' => fn ($query) => $query->where('is_published', true)->orderByDesc('published_at')->withCount('comments'),
        ]);

        return view('authors.show', compact('author'));
    }
}
