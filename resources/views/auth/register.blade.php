@extends('layouts.app')

@section('title', 'Регистрација | LostLink')

@section('content')
    <div class="mx-auto w-full max-w-md">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Направи профил</h1>
            <p class="mt-1 text-sm text-slate-600">Регистрирај се за да објавуваш изгубени и најдени предмети.</p>

            @if ($errors->any())
                <div class="mt-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                    <ul class="list-inside list-disc space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-6 space-y-4" action="{{ route('register.store') }}" method="POST">
                @csrf

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="name">Име</label>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Твоето име" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="phone">Телефонски број</label>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="+389 70 123 456" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="email">Емаил</label>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="ime@primer.com" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="password">Лозинка</label>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="password" name="password" type="password" placeholder="Најмалку 8 знаци" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="password_confirmation">Потврди лозинка</label>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="password_confirmation" name="password_confirmation" type="password" placeholder="Повтори ја лозинката" required>
                </div>

                <button class="inline-flex w-full items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700" type="submit">Регистрирај се</button>
            </form>
        </div>

        <p class="mt-4 text-center text-sm text-slate-600">
            Веќе имаш профил?
            <a href="{{ route('login') }}" class="font-semibold text-sky-700 hover:underline">Најави се</a>
        </p>
    </div>
@endsection
