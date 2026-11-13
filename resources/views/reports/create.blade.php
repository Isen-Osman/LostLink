@extends('layouts.app')

@section('title', 'Пријави предмет | LostLink')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Пријави изгубен или најден предмет</h1>

    @if ($errors->any())
        <ul class="mt-4 space-y-1 rounded-lg bg-red-50 p-4 text-sm text-red-800">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form class="mt-6 space-y-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm" action="{{ route('reports.store') }}" method="POST">
        @csrf

        <div>
            <label class="mb-1 block text-sm font-semibold" for="type">Тип</label>
            <select class="w-full rounded-lg border border-slate-300 px-3 py-2" id="type" name="type">
                <option value="lost" @selected(old('type', 'lost') === 'lost')>Изгубен</option>
                <option value="found" @selected(old('type') === 'found')>Најден</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="category">Категорија</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="category" name="category" type="text" value="{{ old('category') }}">
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="title">Наслов</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="title" name="title" type="text" value="{{ old('title') }}">
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="description">Опис</label>
            <textarea class="w-full resize-y rounded-lg border border-slate-300 px-3 py-2" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="location">Локација</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="location" name="location" type="text" value="{{ old('location') }}">
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold" for="happened_at">Датум</label>
            <input class="w-full rounded-lg border border-slate-300 px-3 py-2" id="happened_at" name="happened_at" type="date" value="{{ old('happened_at') }}">
        </div>

        <button class="rounded-lg bg-sky-700 px-4 py-2 font-semibold text-white hover:bg-sky-800" type="submit">Испрати пријава</button>
    </form>
@endsection
