@extends('layouts.app')

@section('title', 'Пријавата е примена | LostLink')

@section('content')
    <div class="mx-auto max-w-lg">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 6 9 17l-5-5"></path>
                </svg>
            </div>

            <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-900">Пријавата е примена</h1>
            <p class="mt-2 text-slate-600">Твојата пријава е успешно објавена.</p>

            <div class="mt-6 rounded-xl bg-slate-50 p-4 text-left text-sm">
                <p class="flex items-center justify-between gap-4">
                    <span class="text-slate-500">Број на пријава</span>
                    <span class="font-semibold text-slate-900">#{{ $report->id }}</span>
                </p>
                <p class="mt-2 flex items-center justify-between gap-4">
                    <span class="text-slate-500">Наслов</span>
                    <span class="font-semibold text-slate-900">{{ $report->title }}</span>
                </p>
            </div>

            <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-center">
                <a href="{{ route('reports.show', $report) }}" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">Види ја пријавата</a>
                <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">Сите пријави</a>
            </div>
        </div>
    </div>
@endsection
