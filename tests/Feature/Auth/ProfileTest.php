<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can access profile', function () {

    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/user-profile');

    $response->assertStatus(200)
        ->assertJson([
            'id' => $user->id,
            'email' => $user->email,
        ]);
});

test('guest cannot access profile', function () {

    $response = $this->getJson('/api/user-profile');

    $response->assertStatus(401);
});