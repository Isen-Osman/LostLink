<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = Report::query()
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->input('type')))
            ->when($request->filled('category'), fn ($query) => $query->where('category', 'ilike', '%'.$request->input('category').'%'))
            ->when($request->filled('location'), fn ($query) => $query->where('location', 'ilike', '%'.$request->input('location').'%'))
            ->when($request->filled('happened_at'), fn ($query) => $query->whereDate('happened_at', $request->input('happened_at')))
            ->latest()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', [
            'reports' => $reports,
        ]);
    }

    public function show(Report $report): View
    {
        return view('reports.show', [
            'report' => $report,
        ]);
    }

    public function store(Request $request): View
    {
        $validated = $request->validate([
            'type' => ['required', 'in:lost,found'],
            'category' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'happened_at' => ['required', 'date'],
        ]);

        $report = Report::create($validated);

        return view('reports.received', [
            'report' => $report,
        ]);
    }
}
