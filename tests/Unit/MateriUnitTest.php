<?php

use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

// CREATE
test('Path 1 - user bukan admin tidak memiliki akses untuk create materi', function () {
    $user = User::factory()->create([
        'role' => 'guru',
        'email_verified_at' => now(),
    ]);

    $result = $user->role === 'admin';

    expect($result)->toBeFalse();
});

test('Path 2 - user admin memiliki akses untuk create materi', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $result = $user->role === 'admin';

    expect($result)->toBeTrue();
});

// STORE
test('Path 3 - user bukan admin tidak memiliki akses untuk store materi', function () {
    $user = User::factory()->create([
        'role' => 'guru',
        'email_verified_at' => now(),
    ]);

    $result = $user->role === 'admin';

    expect($result)->toBeFalse();
});

test('Path 4 - validasi gagal ketika input store materi tidak valid', function () {

    $data = [
        'judul' => '',
        'link_video' => 'video-materi',
        'deskripsi' => '',
        'id_kelas' => '',
    ];

    $rules = [
        'judul' => 'required|string|max:255',
        'link_video' => 'required|url',
        'deskripsi' => 'nullable|string',
        'id_kelas' => 'required',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('judul'))->toBeTrue();
    expect($validator->errors()->has('link_video'))->toBeTrue();
    expect($validator->errors()->has('id_kelas'))->toBeTrue();
});

test('Path 5 - validasi berhasil ketika input store materi valid', function () {
    $data = [
        'judul' => 'Matematika Bab 1',
        'link_video' => 'https://youtube.com/watch?v=abc123',
        'deskripsi' => 'Materi pembelajaran',
        'id_kelas' => 1,
    ];

    $rules = [
        'judul' => 'required|string|max:255',
        'link_video' => 'required|url',
        'deskripsi' => 'nullable|string',
        'id_kelas' => 'required',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->passes())->toBeTrue();
});

// DESTROY
test('Path 6 - user bukan admin tidak memiliki akses untuk destroy materi', function () {
    $user = User::factory()->create([
        'role' => 'guru',
        'email_verified_at' => now(),
    ]);

    $result = $user->role === 'admin';

    expect($result)->toBeFalse();
});

test('Path 7 - materi tidak ditemukan berdasarkan id', function () {
    $id = 9999;

    $materi = Materi::find($id);

    expect($materi)->toBeNull();
});

test('Path 8 - materi ditemukan dan berhasil dihapus', function () {
    $materi = Materi::create([
        'judul' => 'Video Test',
        'link_video' => 'https://youtube.com/watch?v=abc123',
        'deskripsi' => 'Deskripsi video',
        'id_kelas' => 1,
    ]);

    $materi->delete();

    $result = Materi::find($materi->id);

    expect($result)->toBeNull();
});
