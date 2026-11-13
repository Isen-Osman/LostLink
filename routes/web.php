<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/reports/create', 'reports.create')->name('reports.create');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
