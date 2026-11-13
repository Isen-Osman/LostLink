@extends('layouts.app')

@section('title', 'Пријавата е примена | LostLink')

@section('content')
    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Пријавата е примена</h1>
        <p class="mt-2 text-slate-600">Број на пријава: {{ $report->id }}</p>
        <p class="text-slate-600">Наслов: {{ $report->title }}</p>
        <p class="mt-3"><a class="text-sm font-semibold text-sky-700 hover:underline" href="{{ route('reports.index') }}">Погледни ги сите пријави</a></p>
    </section>
@endsection
