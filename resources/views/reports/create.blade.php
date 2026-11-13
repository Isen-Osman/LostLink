@extends('layouts.app')

@section('title', 'Пријави предмет | LostLink')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 transition hover:text-slate-900">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M19 12H5M11 18l-6-6 6-6"></path>
            </svg>
            Назад
        </a>

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Пријави изгубен или најден предмет</h1>
        <p class="mt-2 text-slate-600">Пополни ги деталите за да помогнеш предметот да го најде вистинскиот сопственик.</p>

        @if ($errors->any())
            <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <p class="font-semibold">Провери ги полињата:</p>
                <ul class="mt-1 list-inside list-disc space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="mt-6 space-y-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8" action="{{ route('reports.store') }}" method="POST">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="type">Тип</label>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="type" name="type">
                        <option value="lost" @selected(old('type', 'lost') === 'lost')>Изгубен</option>
                        <option value="found" @selected(old('type') === 'found')>Најден</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="category">Категорија</label>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="category" name="category" required>
                        <option value="" @selected(! old('category'))>— Избери категорија —</option>
                        @foreach (\App\Models\Report::CATEGORIES as $value => $label)
                            <option value="{{ $value }}" @selected(old('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="title">Наслов</label>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="title" name="title" type="text" value="{{ old('title') }}" placeholder="Кратко име на предметот">
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="description">Опис</label>
                <textarea class="w-full resize-y rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="description" name="description" rows="5" placeholder="Боја, марка, препознатливи знаци...">{{ old('description') }}</textarea>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="location">Локација</label>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="location" name="location" type="text" value="{{ old('location') }}" placeholder="Каде е изгубен/најден?">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="happened_at">Датум</label>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="happened_at" name="happened_at" type="date" value="{{ old('happened_at') }}">
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">
                <button class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700" type="submit">Испрати пријава</button>
                <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">Откажи</a>
            </div>
        </form>
    </div>
@endsection
