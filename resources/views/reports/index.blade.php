@extends('layouts.app')

@section('title', 'Пријави | LostLink')

@section('content')
    <section class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-sky-600">Lost &amp; Found</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Изгубено? Најдено?</h1>
            <p class="mt-3 max-w-2xl text-slate-600">Прегледај пријави од заедницата или објави предмет за да помогнеш некој да го врати.</p>
        </div>
        @auth
            <a href="{{ route('reports.create') }}" class="inline-flex shrink-0 items-center justify-center gap-1.5 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"></path>
                </svg>
                Пријави предмет
            </a>
        @else
            <a href="{{ route('register') }}" class="inline-flex shrink-0 items-center justify-center gap-1.5 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">
                Започни бесплатно
            </a>
        @endauth
    </section>

    <form class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6" action="{{ route('reports.index') }}" method="GET">
        <div class="flex items-center justify-between gap-4">
            <h2 class="flex items-center gap-2 text-sm font-semibold text-slate-900">
                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"></path>
                </svg>
                Филтри
            </h2>
            <a href="{{ route('reports.index') }}" class="text-sm font-semibold text-slate-500 transition hover:text-slate-900">Исчисти</a>
        </div>

        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="type">Тип</label>
                <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="type" name="type">
                    <option value="">Сите</option>
                    <option value="lost" @selected(request('type') === 'lost')>Изгубен</option>
                    <option value="found" @selected(request('type') === 'found')>Најден</option>
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="category">Категорија</label>
                <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="category" name="category">
                    <option value="">Сите категории</option>
                    @foreach (\App\Models\Report::CATEGORIES as $value => $label)
                        <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="location">Локација</label>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="location" name="location" type="text" value="{{ request('location') }}" placeholder="Пр. Скопје">
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="happened_at">Датум</label>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="happened_at" name="happened_at" type="date" value="{{ request('happened_at') }}">
            </div>
        </div>

        <div class="mt-4">
            <button class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800" type="submit">Примени филтри</button>
        </div>
    </form>

    <div class="mt-8 flex items-center justify-between gap-4">
        <h2 class="text-lg font-semibold text-slate-900">
            @if ($reports->total() > 0)
                {{ $reports->total() }} {{ $reports->total() === 1 ? 'пријава' : 'пријави' }}
            @else
                Резултати
            @endif
        </h2>
    </div>

    <div class="mt-4 grid gap-4 sm:grid-cols-2">
        @forelse ($reports as $report)
            <article class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                @if ($report->image)
                    <img class="mb-4 h-40 w-full rounded-xl object-cover" src="{{ $report->imageUrl() }}" alt="{{ $report->title }}" loading="lazy">
                @endif

                <div class="flex items-center justify-between gap-3">
                    <x-type-badge :type="$report->type" />
                    <time class="text-xs font-medium text-slate-500" datetime="{{ $report->happened_at->toDateString() }}">{{ $report->happened_at->format('d.m.Y') }}</time>
                </div>

                <h3 class="mt-3 text-lg font-semibold text-slate-900">
                    <a href="{{ route('reports.show', $report) }}" class="transition hover:text-sky-700">{{ $report->title }}</a>
                </h3>
                <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $report->description }}</p>

                <dl class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
                    <div class="flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82Z"></path>
                            <path d="M7 7h.01"></path>
                        </svg>
                        <span>{{ $report->categoryLabel() }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>{{ $report->location }}</span>
                    </div>
                </dl>

                <div class="mt-4 border-t border-slate-100 pt-3">
                    <a href="{{ route('reports.show', $report) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-sky-700 transition hover:text-sky-800">
                        Детали
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6"></path>
                        </svg>
                    </a>
                </div>
            </article>
        @empty
            <div class="sm:col-span-2">
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">Нема пронајдени пријави</h3>
                    <p class="mt-1 text-sm text-slate-600">Пробај да ги смениш филтрите или објави нова пријава.</p>
                    @auth
                        <a href="{{ route('reports.create') }}" class="mt-5 inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">Пријави предмет</a>
                    @endauth
                </div>
            </div>
        @endforelse
    </div>

    @if ($reports->hasPages())
        <div class="mt-8">
            {{ $reports->links() }}
        </div>
    @endif
@endsection
