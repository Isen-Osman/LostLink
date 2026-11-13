@props(['type'])

@if ($type === 'lost')
    <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">
        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
        Изгубен
    </span>
@else
    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
        Најден
    </span>
@endif
