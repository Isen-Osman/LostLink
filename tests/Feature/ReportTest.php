<?php

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('redirects guests from creating reports', function () {
    $this->get('/reports/create')->assertRedirect(route('login'));
});

it('lets an authenticated user create a report linked to them', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/reports', [
        'type' => 'lost',
        'category' => 'phone',
        'title' => 'Lost phone',
        'description' => 'Black phone',
        'location' => 'Skopje',
        'happened_at' => '2026-11-13',
    ])->assertOk();

    $report = Report::first();

    expect($report->user_id)->toBe($user->id);
    expect($report->title)->toBe('Lost phone');
});

it('rejects a category that is not in the list', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/reports', [
        'type' => 'lost',
        'category' => 'spaceship',
        'title' => 'Lost phone',
        'description' => 'Black phone',
        'location' => 'Skopje',
        'happened_at' => '2026-11-13',
    ])->assertSessionHasErrors('category');

    expect(Report::count())->toBe(0);
});

it('stores an uploaded image', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $this->actingAs($user)->post('/reports', [
        'type' => 'found',
        'category' => 'wallet',
        'title' => 'Found wallet',
        'description' => 'Brown leather wallet',
        'image' => UploadedFile::fake()->image('wallet.jpg'),
        'location' => 'Skopje',
        'happened_at' => '2026-11-13',
    ])->assertOk();

    $report = Report::first();

    expect($report->image)->not->toBeNull();
    Storage::disk('public')->assertExists($report->image);
});

it('shows the author phone number on the report page', function () {
    $user = User::factory()->create(['phone' => '+389 70 123 456']);
    $report = Report::factory()->for($user)->create();

    $this->get(route('reports.show', $report))
        ->assertOk()
        ->assertSee('+389 70 123 456');
});
