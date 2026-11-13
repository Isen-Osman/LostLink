<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index', [
            'reports' => Report::latest()->get(),
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
