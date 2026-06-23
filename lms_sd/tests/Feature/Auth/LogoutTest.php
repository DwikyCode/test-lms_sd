<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can logout successfully', function () {

    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Logout berhasil',
        ]);
});

test('unauthenticated user cannot logout', function () {

    $response = $this->postJson('/api/logout');

    $response->assertStatus(401);
});