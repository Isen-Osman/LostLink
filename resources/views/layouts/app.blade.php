<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LostLink')</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex w-full max-w-3xl items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('reports.index') }}" class="text-xl font-bold text-slate-900">LostLink</a>
            <a href="{{ route('reports.create') }}" class="rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800">Пријави предмет</a>
        </nav>
    </header>

    <main class="mx-auto w-full max-w-3xl px-4 py-9">
        @yield('content')
    </main>
</body>
</html>
