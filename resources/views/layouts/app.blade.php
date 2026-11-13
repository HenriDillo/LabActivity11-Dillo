<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Barangay Bulletin – Purok Dillo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-stone-100 text-stone-800">
    <header class="bg-emerald-800 text-white shadow">
        <div class="mx-auto max-w-5xl px-4 py-5">
            <a href="{{ route('posts.index') }}" class="text-xl font-bold sm:text-2xl">Barangay Bulletin – Purok Dillo</a>
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                <p class="text-sm text-emerald-100">Barangay Matina Crossing Hall, Davao City</p>
                <nav class="flex items-center gap-4 text-sm text-emerald-50">
                    <a href="{{ route('posts.index') }}" class="hover:text-white">Posts</a>
                    @auth
                        @if (Auth::user()->author)
                            <a href="{{ route('posts.drafts') }}" class="hover:text-white">My drafts</a>
                            <a href="{{ route('posts.create') }}" class="hover:text-white">New post</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-white">Log out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-white">Log in</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-6">
        @if (session('success'))
            <div class="mb-5 rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-4 text-center text-sm text-stone-500">
        &copy; 2026 Barangay Matina Crossing Hall &middot; Lab Activity 10
    </footer>
</body>
</html>
