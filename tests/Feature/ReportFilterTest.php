<?php

use App\Enums\ReportCategory;
use App\Enums\ReportType;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('filters reports by location case-insensitively', function () {
    if (DB::getDriverName() !== 'pgsql') {
        $this->markTestSkipped('ILIKE search is PostgreSQL only.');
    }

    Report::factory()->create(['title' => 'Lost in Skopje', 'location' => 'Skopje, North Macedonia']);
    Report::factory()->create(['title' => 'Lost in Bitola', 'location' => 'Bitola, North Macedonia']);

    $this->get('/reports?location=skopje')
        ->assertOk()
        ->assertSee('Lost in Skopje')
        ->assertDontSee('Lost in Bitola');
});

it('filters reports by type and category', function () {
    Report::factory()->create([
        'title' => 'Lost phone',
        'type' => ReportType::Lost,
        'category' => ReportCategory::Phone,
    ]);
    Report::factory()->create([
        'title' => 'Found wallet',
        'type' => ReportType::Found,
        'category' => ReportCategory::Wallet,
    ]);

    $this->get('/reports?type=found&category=wallet')
        ->assertOk()
        ->assertSee('Found wallet')
        ->assertDontSee('Lost phone');
});
