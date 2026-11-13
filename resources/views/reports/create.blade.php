<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пријави предмет</title>
</head>
<body>
    <h1>Пријави изгубен или најден предмет</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <label for="type">Тип</label>
        <select id="type" name="type">
            <option value="lost" @selected(old('type', 'lost') === 'lost')>Изгубен</option>
            <option value="found" @selected(old('type') === 'found')>Најден</option>
        </select>

        <p>
            <label for="category">Категорија</label>
            <input id="category" name="category" type="text" value="{{ old('category') }}">
        </p>

        <p>
            <label for="title">Наслов</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}">
        </p>

        <p>
            <label for="description">Опис</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </p>

        <p>
            <label for="location">Локација</label>
            <input id="location" name="location" type="text" value="{{ old('location') }}">
        </p>

        <p>
            <label for="happened_at">Датум</label>
            <input id="happened_at" name="happened_at" type="date" value="{{ old('happened_at') }}">
        </p>

        <button type="submit">Испрати пријава</button>
    </form>
</body>
</html>
