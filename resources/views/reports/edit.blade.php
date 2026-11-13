@extends('layouts.app')

@section('title', 'Уреди пријава | LostLink')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('reports.show', $report) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 transition hover:text-slate-900">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M19 12H5M11 18l-6-6 6-6"></path>
            </svg>
            Назад
        </a>

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Уреди пријава</h1>
        <p class="mt-2 text-slate-600">Измени ги деталите и зачувај ги промените.</p>

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

        @include('reports.partials.form', ['report' => $report, 'submitLabel' => 'Зачувај промени'])
    </div>
@endsection
