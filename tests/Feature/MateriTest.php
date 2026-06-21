<?php

use App\Models\User;
use App\Models\Materi;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
});
it('can display materi by class', function () {

    $response = $this->actingAs($this->admin)
        ->get('/kelas/1/materi');

    $response->assertStatus(200);
});
it('only shows materi for selected class', function () {

    Materi::create([
        'judul' => 'Matematika',
        'link_video' => 'https://youtube.com/test',
        'id_kelas' => '1'
    ]);

    Materi::create([
        'judul' => 'Bahasa',
        'link_video' => 'https://youtube.com/test2',
        'id_kelas' => '2'
    ]);

    $response = $this->actingAs($this->admin)
        ->get('/kelas/1/materi');

    $response->assertStatus(200);
});
it('admin can access create page', function () {

    $response = $this->actingAs($this->admin)
        ->get('/kelas/1/materi/create');

    $response->assertStatus(200);
});
it('user cannot access create page', function () {

    $response = $this->actingAs($this->user)
        ->get('/kelas/1/materi/create');

    $response->assertRedirect();
});
it('admin can store materi', function () {

    $response = $this->actingAs($this->admin)
        ->post('/materi/store', [
            'judul' => 'Matematika',
            'link_video' => 'https://youtube.com/test',
            'deskripsi' => 'Belajar dasar',
            'id_kelas' => '1'
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('materis', [
        'judul' => 'Matematika'
    ]);
});
it('fails validation when store empty', function () {

    $response = $this->actingAs($this->admin)
        ->post('/materi/store', []);

    $response->assertSessionHasErrors();
});
it('non admin cannot store materi', function () {

    $response = $this->actingAs($this->user)
        ->post('/materi/store', [
            'judul' => 'Test',
            'link_video' => 'https://youtube.com/test',
            'id_kelas' => '1'
        ]);

    $response->assertStatus(403);
});
it('admin can delete materi', function () {

    $materi = Materi::create([
        'judul' => 'Test',
        'link_video' => 'https://youtube.com/test',
        'id_kelas' => '1'
    ]);

    $response = $this->actingAs($this->admin)
        ->delete('/materi/'.$materi->id);

    $response->assertRedirect();

    $this->assertDatabaseMissing('materis', [
        'id' => $materi->id
    ]);
});
it('user cannot delete materi', function () {

    $materi = Materi::create([
        'judul' => 'Test',
        'link_video' => 'https://youtube.com/test',
        'id_kelas' => '1'
    ]);

    $response = $this->actingAs($this->user)
        ->delete('/materi/'.$materi->id);

    $response->assertStatus(403);
});