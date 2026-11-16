<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $reports = Report::query()
            ->with('user')
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->input('type')))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->input('category')))
            ->when($request->filled('location'), fn ($query) => $query->where('location', 'ilike', '%'.$request->input('location').'%'))
            ->when($request->filled('happened_at'), fn ($query) => $query->whereDate('happened_at', $request->input('happened_at')))
            ->latest()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return ReportResource::collection($reports);
    }

    public function show(Report $report): ReportResource
    {
        return new ReportResource($report->load('user'));
    }

    public function store(StoreReportRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $report = DB::transaction(function () use ($request, $validated) {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('reports', 'public');
            }

            return $request->user()->reports()->create($validated);
        });

        return (new ReportResource($report->load('user')))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateReportRequest $request, Report $report): ReportResource
    {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $report, $validated) {
            if ($request->hasFile('image')) {
                if ($report->image) {
                    Storage::disk('public')->delete($report->image);
                }

                $validated['image'] = $request->file('image')->store('reports', 'public');
            }

            $report->update($validated);
        });

        return new ReportResource($report->load('user'));
    }

    public function destroy(Report $report): JsonResponse
    {
        $this->authorize('delete', $report);

        if ($report->image) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return response()->json(null, 204);
    }
}
