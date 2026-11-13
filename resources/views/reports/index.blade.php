<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пријави</title>
</head>
<body>
    <h1>Пријави</h1>
    <p><a href="{{ route('reports.create') }}">Додај пријава</a></p>

    @forelse ($reports as $report)
        <article>
            <h2>{{ $report->title }}</h2>
            <p>Тип: {{ $report->type === 'lost' ? 'Изгубен' : 'Најден' }}</p>
            <p>Категорија: {{ $report->category }}</p>
            <p>Локација: {{ $report->location }}</p>
            <p>Датум: {{ $report->happened_at->format('d.m.Y') }}</p>
        </article>
    @empty
        <p>Сè уште нема пријави.</p>
    @endforelse
</body>
</html>
