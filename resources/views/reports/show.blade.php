<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->title }}</title>
</head>
<body>
    <p><a href="{{ route('reports.index') }}">Назад до пријавите</a></p>

    <h1>{{ $report->title }}</h1>
    <p>Тип: {{ $report->type === 'lost' ? 'Изгубен' : 'Најден' }}</p>
    <p>Категорија: {{ $report->category }}</p>
    <p>Опис: {{ $report->description }}</p>
    <p>Локација: {{ $report->location }}</p>
    <p>Датум: {{ $report->happened_at->format('d.m.Y') }}</p>
    <p>Статус: {{ $report->status }}</p>
</body>
</html>
