@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="rounded-lg border border-stone-200 bg-white p-6 shadow-sm">
            <h1 class="mb-6 text-2xl font-bold text-stone-900">Create a new post</h1>

            @if ($errors->any())
                <div class="mb-4 rounded border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700" role="alert">
                    <p class="mb-1 font-semibold">Please fix the following errors:</p>
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('posts.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="title" class="label">Title</label>
                    <input id="title" name="title" type="text" maxlength="120" value="{{ old('title') }}" class="input" required>
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="label">Category</label>
                    <select id="category" name="category" class="input" required>
                        <option value="">Select a category</option>
                        @foreach (['Announcement', 'Health', 'Peace & Order', 'Ayuda', 'Sports & Youth'] as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="label">Body</label>
                    <textarea id="body" name="body" rows="8" class="input" required>{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Tags</label>
                    <div class="grid gap-2 md:grid-cols-2">
                        @foreach ($tags as $tag)
                            <label class="flex items-center gap-2 rounded border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-700">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-stone-300 text-emerald-700 focus:ring-emerald-600" @checked(in_array((string) $tag->id, (array) old('tags', []), true))>
                                {{ $tag->name }}
                            </label>
                            @error('tags.'.$loop->index)
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        @endforeach
                    </div>
                    @error('tags')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="hidden" name="is_published" value="0">
                    <label class="flex items-center gap-2 text-sm text-stone-700">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-stone-300 text-emerald-700 focus:ring-emerald-600" @checked((bool) old('is_published', true))>
                        Publish this post
                    </label>
                    @error('is_published')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded bg-emerald-700 px-5 py-2.5 text-sm text-white hover:bg-emerald-800">Save post</button>
                </div>
            </form>
        </div>
    </div>
@endsection
