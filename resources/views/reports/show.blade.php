@extends('layouts.app')

@section('title', $report->title.' | LostLink')

@section('content')
    <p><a class="text-sm font-semibold text-sky-700 hover:underline" href="{{ route('reports.index') }}">Назад до пријавите</a></p>

    <article class="mt-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">{{ $report->title }}</h1>
        <p class="mt-2 text-sm text-slate-600">Тип: {{ $report->type === 'lost' ? 'Изгубен' : 'Најден' }}</p>
        <p class="text-sm text-slate-600">Објавил: {{ $report->user?->name ?? 'Непознат автор' }}</p>
        <p class="text-sm text-slate-600">Категорија: {{ $report->category }}</p>
        <p class="text-sm text-slate-600">Опис: {{ $report->description }}</p>
        <p class="text-sm text-slate-600">Локација: {{ $report->location }}</p>
        <p class="text-sm text-slate-600">Датум: {{ $report->happened_at->format('d.m.Y') }}</p>
        <p class="text-sm text-slate-600">Статус: {{ $report->status }}</p>
    </article>
@endsection
