@extends('layouts.app')

@section('title', $report->title.' | LostLink')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 transition hover:text-slate-900">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M19 12H5M11 18l-6-6 6-6"></path>
            </svg>
            Назад до пријавите
        </a>

        @auth
            @if (auth()->id() === $report->user_id)
                <div class="flex items-center gap-2">
                    <a href="{{ route('reports.edit', $report) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                        </svg>
                        Уреди
                    </a>
                    <form action="{{ route('reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Дали сигурно сакаш да ја избришеш оваа пријава?');">
                        @csrf
                        @method('DELETE')
                        <button class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-white px-3 py-1.5 text-sm font-semibold text-rose-700 shadow-sm transition hover:bg-rose-50" type="submit">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            Избриши
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>

    <article class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-5 sm:p-8">
            <div class="flex flex-wrap items-center gap-3">
                <x-type-badge :type="$report->type" />
                <span class="text-sm text-slate-500">Објавено на {{ $report->created_at->format('d.m.Y') }}</span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $report->title }}</h1>
        </div>

        @if ($report->image)
            <div class="border-b border-slate-100 p-5 sm:p-8">
                <img class="max-h-[28rem] w-full rounded-xl object-cover" src="{{ $report->imageUrl() }}" alt="{{ $report->title }}">
            </div>
        @endif

        <div class="grid gap-8 p-5 sm:p-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Опис</h2>
                <p class="mt-2 whitespace-pre-line leading-relaxed text-slate-700">{{ $report->description }}</p>
            </div>

            <aside class="space-y-6 lg:border-l lg:border-slate-100 lg:pl-8">
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Детали</h2>
                    <dl class="mt-3 space-y-3 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-slate-500">Категорија</dt>
                            <dd class="font-medium text-slate-900">{{ $report->categoryLabel() }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-slate-500">Локација</dt>
                            <dd class="font-medium text-slate-900">{{ $report->location }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-slate-500">Датум</dt>
                            <dd class="font-medium text-slate-900">{{ $report->happened_at->format('d.m.Y') }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-slate-500">Статус</dt>
                            <dd class="font-medium text-slate-900">{{ $report->status->label() }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl bg-slate-50 p-4">
                    <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Објавил</h2>
                    <div class="mt-2 flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-sm font-semibold text-slate-700">
                            {{ $report->user ? mb_strtoupper(mb_substr($report->user->name, 0, 1)) : '?' }}
                        </span>
                        <span class="font-medium text-slate-900">{{ $report->user?->name ?? 'Непознат автор' }}</span>
                    </div>
                    @if ($report->user?->phone)
                        <a href="tel:{{ $report->user->phone }}" class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-sky-700 transition hover:text-sky-800">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            {{ $report->user->phone }}
                        </a>
                    @endif
                </div>
            </aside>
        </div>
    </article>
@endsection
