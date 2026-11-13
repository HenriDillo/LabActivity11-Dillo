@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="rounded-lg border border-stone-200 bg-white p-6 shadow-sm">
            <h1 class="mb-6 text-2xl font-bold text-stone-900">Resident Login</h1>

            @if ($errors->any())
                <div class="mb-4 rounded border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="input" required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="label">Password</label>
                    <input id="password" name="password" type="password" class="input" required>
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-stone-600">
                        <input type="checkbox" name="remember" value="1" class="rounded border-stone-300 text-emerald-700 focus:ring-emerald-600">
                        Remember me
                    </label>
                    <button type="submit" class="rounded bg-emerald-700 px-4 py-2 text-sm text-white hover:bg-emerald-800">Log in</button>
                </div>
            </form>
        </div>
    </div>
@endsection
