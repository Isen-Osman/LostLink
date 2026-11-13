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

it('lets the owner update a report', function () {
    $user = User::factory()->create();
    $report = Report::factory()->for($user)->create();

    $this->actingAs($user)->get(route('reports.edit', $report))->assertOk();

    $this->actingAs($user)->put(route('reports.update', $report), [
        'type' => 'found',
        'category' => 'wallet',
        'title' => 'Updated title',
        'description' => 'Updated description',
        'location' => 'Bitola',
        'happened_at' => '2026-11-13',
    ])->assertRedirect(route('reports.show', $report));

    $report->refresh();

    expect($report->type)->toBe('found');
    expect($report->title)->toBe('Updated title');
    expect($report->location)->toBe('Bitola');
});

it('forbids editing or deleting someone else\'s report', function () {
    $owner = User::factory()->create();
    $report = Report::factory()->for($owner)->create();
    $other = User::factory()->create();

    $this->actingAs($other)->get(route('reports.edit', $report))->assertForbidden();
    $this->actingAs($other)->put(route('reports.update', $report), [])->assertForbidden();
    $this->actingAs($other)->delete(route('reports.destroy', $report))->assertForbidden();

    expect(Report::find($report->id))->not->toBeNull();
});

it('lets the owner delete a report', function () {
    $user = User::factory()->create();
    $report = Report::factory()->for($user)->create();

    $this->actingAs($user)
        ->delete(route('reports.destroy', $report))
        ->assertRedirect(route('reports.index'));

    expect(Report::find($report->id))->toBeNull();
});
