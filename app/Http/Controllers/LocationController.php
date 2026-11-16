<?php

namespace App\Http\Controllers;

use App\Services\GeoapifyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request, GeoapifyService $geoapify): JsonResponse
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        return response()->json([
            'data' => $geoapify->suggest((string) $request->string('q')),
        ]);
    }
}
