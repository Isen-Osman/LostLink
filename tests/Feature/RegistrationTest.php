<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a new user and logs them in', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '+389 70 123 456',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('reports.index'));

    $this->assertAuthenticated();
    expect(User::where('email', 'test@example.com')->first()->phone)->toBe('+389 70 123 456');
});
