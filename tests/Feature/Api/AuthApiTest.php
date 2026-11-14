<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a token for valid credentials', function () {
    $user = User::factory()->create();

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertOk()
        ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email']]);
});

it('rejects invalid credentials', function () {
    $user = User::factory()->create();

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])
        ->assertStatus(422)
        ->assertJsonValidationErrors('email');
});
