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

it('redirects guests to the login page', function () {
    $this->get('/locations?q=Partizanski')->assertRedirect(route('login'));
});

it('renders the location autocomplete input', function () {
    $this->actingAs(User::factory()->create())
        ->get('/reports/create')
        ->assertOk()
        ->assertSee('location-suggestions', false);
});
