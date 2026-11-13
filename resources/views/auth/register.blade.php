@extends('layouts.app')

@section('title', 'Регистрација | LostLink')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Регистрација</h1>
    <p class="mt-1 text-slate-600">Направи профил за да објавуваш пријави.</p>

    @if ($errors->any())
        <ul class="mt-4 space-y-1 rounded-lg bg-red-50 p-4 text-sm text-red-800">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form class="mt-6 space-y-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm" action="{{ route('register.store') }}" method="POST">
        @csrf

        <div>
            <label class="mb-1 block text-sm font-semibold" for="name">Име</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="name" name="name" type="text" value="{{ old('name') }}" required>
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="email">Емаил</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="email" name="email" type="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="password">Лозинка</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="password" name="password" type="password" required>
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="password_confirmation">Потврди лозинка</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="password_confirmation" name="password_confirmation" type="password" required>
        </div>

        <button class="rounded-lg bg-sky-700 px-4 py-2 font-semibold text-white hover:bg-sky-800" type="submit">Регистрирај се</button>
    </form>
@endsection
