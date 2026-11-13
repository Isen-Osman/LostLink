@extends('layouts.app')

@section('title', 'Пријави | LostLink')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Пријави</h1>
    <p class="mt-1 text-slate-600">Изгубени и најдени предмети во заедницата.</p>
    <p class="mt-4">
        <a class="inline-block rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800" href="{{ route('reports.create') }}">Додај пријава</a>
    </p>

    @forelse ($reports as $report)
        <article class="mt-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">{{ $report->title }}</h2>
            <p class="mt-2 text-sm text-slate-600">Тип: {{ $report->type === 'lost' ? 'Изгубен' : 'Најден' }}</p>
            <p class="text-sm text-slate-600">Категорија: {{ $report->category }}</p>
            <p class="text-sm text-slate-600">Локација: {{ $report->location }}</p>
            <p class="text-sm text-slate-600">Датум: {{ $report->happened_at->format('d.m.Y') }}</p>
            <p class="mt-3"><a class="text-sm font-semibold text-sky-700 hover:underline" href="{{ route('reports.show', $report) }}">Детали</a></p>
        </article>
    @empty
        <p class="mt-4 rounded-xl border border-slate-200 bg-white p-5 text-slate-600">Сè уште нема пријави.</p>
    @endforelse
@endsection
