<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can login successfully', function () {

    // Seed admin
    $this->seed(\Database\Seeders\AdminSeeder::class);

    // Hit endpoint login
    $response = $this->postJson('/api/login', [
        'email' => 'hadhie@sekolah.id',
        'password' => 'hadhieganteng',
    ]);

    // Cek response
    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Login berhasil',
        ]);

    // Cek role
    expect($response['data']['role'])
        ->toBe('admin');

    // Cek token tidak kosong
    expect($response['data']['token'])
        ->not->toBeEmpty();
});

test('login fails with wrong password', function () {

    $this->seed(\Database\Seeders\AdminSeeder::class);

    $response = $this->postJson('/api/login', [
        'email' => 'hadhie@sekolah.id',
        'password' => 'passwordsalah',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'status' => false,
            'message' => 'Email atau Password salah',
        ]);
});

test('login validation fails when fields are empty', function () {

    $response = $this->postJson('/api/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'email',
            'password',
        ]);
});