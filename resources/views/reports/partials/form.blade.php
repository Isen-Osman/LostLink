<form class="mt-6 space-y-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8" action="{{ $report ? route('reports.update', $report) : route('reports.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($report)
        @method('PUT')
    @endif

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="type">Тип</label>
            <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="type" name="type">
                <option value="lost" @selected(old('type', $report?->type ?? 'lost') === 'lost')>Изгубен</option>
                <option value="found" @selected(old('type', $report?->type ?? 'lost') === 'found')>Најден</option>
            </select>
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="category">Категорија</label>
            <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="category" name="category" required>
                <option value="" @selected(! old('category', $report?->category))>— Избери категорија —</option>
                @foreach (\App\Models\Report::CATEGORIES as $value => $label)
                    <option value="{{ $value }}" @selected(old('category', $report?->category) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="title">Наслов</label>
        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="title" name="title" type="text" value="{{ old('title', $report?->title) }}" placeholder="Кратко име на предметот">
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="description">Опис</label>
        <textarea class="w-full resize-y rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="description" name="description" rows="5" placeholder="Боја, марка, препознатливи знаци...">{{ old('description', $report?->description) }}</textarea>
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="image">Слика <span class="font-normal text-slate-500">(опционално)</span></label>
        @if ($report?->image)
            <img class="mb-3 h-32 w-auto rounded-lg object-cover" src="{{ $report->imageUrl() }}" alt="{{ $report->title }}">
        @endif
        <input class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 shadow-sm file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="image" name="image" type="file" accept="image/*">
        <p class="mt-1.5 text-xs text-slate-500">
            @if ($report?->image)
                Остави празно за да ја задржиш сегашната слика.
            @else
                JPG, PNG или WEBP, најмногу 2 MB.
            @endif
        </p>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="location">Локација</label>
            <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="location" name="location" type="text" value="{{ old('location', $report?->location) }}" placeholder="Каде е изгубен/најден?">
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold text-slate-700" for="happened_at">Датум</label>
            <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30" id="happened_at" name="happened_at" type="date" value="{{ old('happened_at', $report?->happened_at?->format('Y-m-d')) }}">
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">
        <button class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700" type="submit">{{ $submitLabel }}</button>
        <a href="{{ $report ? route('reports.show', $report) : route('reports.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">Откажи</a>
    </div>
</form>
