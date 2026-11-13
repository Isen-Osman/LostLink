@extends('layouts.app')

@section('title', 'Пријави | LostLink')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Пријави</h1>
    <p class="mt-1 text-slate-600">Изгубени и најдени предмети во заедницата.</p>
    <p class="mt-4">
        <a class="inline-block rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800" href="{{ route('reports.create') }}">Додај пријава</a>
    </p>

    <form class="mt-6 grid gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2" action="{{ route('reports.index') }}" method="GET">
        <div>
            <label class="mb-1 block text-sm font-semibold" for="type">Тип</label>
            <select class="w-full rounded-lg border border-slate-300 px-3 py-2" id="type" name="type">
                <option value="">Сите</option>
                <option value="lost" @selected(request('type') === 'lost')>Изгубен</option>
                <option value="found" @selected(request('type') === 'found')>Најден</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="category">Категорија</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="category" name="category" type="text" value="{{ request('category') }}">
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="location">Локација</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="location" name="location" type="text" value="{{ request('location') }}">
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="happened_at">Датум</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="happened_at" name="happened_at" type="date" value="{{ request('happened_at') }}">
        </div>

        <div class="flex gap-2 sm:col-span-2">
            <button class="rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800" type="submit">Филтрирај</button>
            <a class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="{{ route('reports.index') }}">Исчисти</a>
        </div>
    </form>

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
        <p class="mt-4 rounded-xl border border-slate-200 bg-white p-5 text-slate-600">Нема пронајдени пријави за избраните филтри.</p>
    @endforelse

    <div class="mt-6">
        {{ $reports->links() }}
    </div>
@endsection
