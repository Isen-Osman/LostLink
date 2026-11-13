@extends('layouts.app')

@section('title', $report->title.' | LostLink')

@section('content')
    <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 transition hover:text-slate-900">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M19 12H5M11 18l-6-6 6-6"></path>
        </svg>
        Назад до пријавите
    </a>

    <article class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-5 sm:p-8">
            <div class="flex flex-wrap items-center gap-3">
                <x-type-badge :type="$report->type" />
                <span class="text-sm text-slate-500">Објавено на {{ $report->created_at->format('d.m.Y') }}</span>
            </div>
            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $report->title }}</h1>
        </div>

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
                            <dd class="font-medium text-slate-900">{{ $report->status === 'resolved' ? 'Решена' : 'Отворена' }}</dd>
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
                </div>
            </aside>
        </div>
    </article>
@endsection
