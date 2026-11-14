-@extends('layouts.app')

@section('title', 'Мои пријави | LostLink')

@section('content')
    <section class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-sky-600">Мои пријави</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Пријавите што ги објави</h1>
            <p class="mt-3 max-w-2xl text-slate-600">Овде ги гледаш само твоите пријави — уреди ги или означи ги како решени.</p>
        </div>
        <a href="{{ route('reports.create') }}" class="inline-flex shrink-0 items-center justify-center gap-1.5 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M12 5v14M5 12h14"></path>
            </svg>
            Пријави предмет
        </a>
    </section>

    <div class="mt-8 space-y-3">
        @forelse ($reports as $report)
            <article class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-type-badge :type="$report->type" />
                        @if ($report->status === \App\Enums\ReportStatus::Resolved)
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                                Решена
                            </span>
                        @endif
                    </div>

                    <h2 class="mt-2 truncate text-base font-semibold text-slate-900">
                        <a href="{{ route('reports.show', $report) }}" class="transition hover:text-sky-700">{{ $report->title }}</a>
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $report->categoryLabel() }} · {{ $report->location }} · {{ $report->happened_at->format('d.m.Y') }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('reports.show', $report) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">Детали</a>
                    <a href="{{ route('reports.edit', $report) }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">Уреди</a>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 12h6M9 16h6M9 8h6"></path>
                        <path d="M20 12V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Сè уште немаш пријави</h3>
                <p class="mt-1 text-sm text-slate-600">Објави предмет за да го видиш овде.</p>
                <a href="{{ route('reports.create') }}" class="mt-5 inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">Пријави предмет</a>
            </div>
        @endforelse
    </div>

    @if ($reports->hasPages())
        <div class="mt-8">
            {{ $reports->links() }}
        </div>
    @endif
@endsection
