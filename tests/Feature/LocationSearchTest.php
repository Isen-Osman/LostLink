<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

it('returns location suggestions as json', function () {
    Http::fake([
        'api.geoapify.com/*' => Http::response([
            'features' => [
                ['properties' => ['formatted' => 'Partizanski Odredi, 6250 Kichevo, North Macedonia']],
                ['properties' => ['formatted' => 'Partizanski Odredi na Makedonija, 7000 Bitola, North Macedonia']],
            ],
        ]),
    ]);

    $this->actingAs(User::factory()->create())
        ->getJson('/locations?q=Partizanski')
        ->assertOk()
        ->assertExactJson([
            'data' => [
                ['label' => 'Partizanski Odredi, 6250 Kichevo, North Macedonia'],
                ['label' => 'Partizanski Odredi na Makedonija, 7000 Bitola, North Macedonia'],
            ],
        ]);
});

it('returns an empty list for a short query', function () {
    Http::fake();

    $this->actingAs(User::factory()->create())
        ->getJson('/locations?q=Pa')
        ->assertOk()
        ->assertExactJson(['data' => []]);

    Http::assertNothingSent();
});

it('lets guests search locations for the public filter', function () {
    Http::fake([
        'api.geoapify.com/*' => Http::response([
            'features' => [
                ['properties' => ['formatted' => 'Skopje, North Macedonia']],
            ],
        ]),
    ]);

    $this->getJson('/locations?q=Skopje')
        ->assertOk()
        ->assertJsonPath('data.0.label', 'Skopje, North Macedonia');
});

it('renders the location autocomplete input', function () {
    $this->actingAs(User::factory()->create())
        ->get('/reports/create')
        ->assertOk()
        ->assertSee('location-suggestions', false);
});

it('renders the location autocomplete in the reports filter', function () {
    $this->get('/reports')
        ->assertOk()
        ->assertSee('location-suggestions', false);
});
