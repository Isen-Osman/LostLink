<?php

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('requires authentication to create a report', function () {
    $this->postJson('/api/reports', [])->assertUnauthorized();
});

it('lets an authenticated user create a report', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/reports', [
        'type' => 'lost',
        'category' => 'phone',
        'title' => 'API phone',
        'description' => 'Black phone',
        'location' => 'Skopje',
        'happened_at' => '2026-11-14',
    ])
        ->assertCreated()
        ->assertJsonPath('data.title', 'API phone');

    expect(Report::where('title', 'API phone')->exists())->toBeTrue();
});

it('forbids updating another user\'s report', function () {
    $report = Report::factory()->for(User::factory())->create();
    Sanctum::actingAs(User::factory()->create());

    $this->patchJson("/api/reports/{$report->id}", [
        'type' => 'lost',
        'category' => 'phone',
        'title' => 'Hacked',
        'description' => 'x',
        'location' => 'Skopje',
        'happened_at' => '2026-11-14',
    ])->assertForbidden();
});

it('lets the owner update and delete a report', function () {
    $user = User::factory()->create();
    $report = Report::factory()->for($user)->create();
    Sanctum::actingAs($user);

    $this->patchJson("/api/reports/{$report->id}", [
        'type' => 'found',
        'category' => 'wallet',
        'title' => 'Updated via API',
        'description' => 'x',
        'location' => 'Bitola',
        'happened_at' => '2026-11-14',
    ])
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated via API');

    $this->deleteJson("/api/reports/{$report->id}")->assertNoContent();

    expect(Report::find($report->id))->toBeNull();
});
