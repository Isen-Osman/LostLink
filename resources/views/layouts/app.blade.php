<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LostLink')</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-10 border-b border-slate-200/80 bg-white/80 backdrop-blur">
            <nav class="mx-auto flex w-full max-w-5xl items-center justify-between gap-4 px-4 py-3">
                <a href="{{ route('reports.index') }}" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-600 text-white shadow-sm">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </span>
                    <span class="text-lg font-bold tracking-tight text-slate-900">LostLink</span>
                </a>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('reports.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-sky-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                                <path d="M12 5v14M5 12h14"></path>
                            </svg>
                            <span class="hidden sm:inline">Пријави предмет</span>
                        </a>
                        <div class="hidden items-center gap-2 sm:flex">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-sm font-semibold text-slate-700">
                                {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-32 truncate text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="rounded-lg px-2 py-1 text-sm font-semibold text-slate-500 transition hover:text-slate-900" type="submit">Одјава</button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Најава</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-sky-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">Регистрација</a>
                    @endguest
                </div>
            </nav>
        </header>

        <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-8 sm:py-12">
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex w-full max-w-5xl flex-col items-center justify-between gap-2 px-4 py-6 text-sm text-slate-500 sm:flex-row">
                <p>&copy; {{ date('Y') }} LostLink</p>
                <p>Изгубени и најдени предмети во заедницата.</p>
            </div>
        </footer>
    </div>
</body>
</html>
