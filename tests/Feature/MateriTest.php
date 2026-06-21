    <?php

    use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($this->admin);
});

// CREATE - Path 1
test('Gagal mengakses halaman tambah materi sebagai guru', function () {
    $guru = User::factory()->create([
        'role' => 'guru',
        'email_verified_at' => now(),
    ]);

    $response = $this
        ->actingAs($guru)
        ->get(route('materi.create', 1));

    $response->assertRedirect();
});

// CREATE - Path 2
test('Berhasil mengakses halaman tambah materi sebagai admin', function () {
    $response = $this->get(route('materi.create', 1));

    $response->assertOk();
});

// STORE - Path 1
test('Gagal menambahkan materi sebagai guru', function () {
    $guru = User::factory()->create([
        'role' => 'guru',
        'email_verified_at' => now(),
    ]);

    $response = $this
        ->actingAs($guru)
        ->post(route('materi.store'), [
            'judul' => 'Video Test',
            'link_video' => 'https://youtube.com/test',
            'id_kelas' => 1,
        ]);

    $response->assertForbidden();
});

// STORE - Path 2
test('Gagal menambahkan materi ketika data wajib kosong', function () {
    $response = $this->post(route('materi.store'), []);

    $response->assertSessionHasErrors([
        'judul',
        'link_video',
        'id_kelas',
    ]);
});

// STORE - Path 3
test('Berhasil menambahkan materi', function () {
    $response = $this->post(route('materi.store'), [
        'judul' => 'Video Test',
        'link_video' => 'https://youtube.com/test',
        'deskripsi' => 'Deskripsi video',
        'id_kelas' => 1,
    ]);

    $response->assertRedirect(route('materi.index', 1));

    $this->assertDatabaseHas('materis', [
        'judul' => 'Video Test',
        'link_video' => 'https://youtube.com/test',
        'deskripsi' => 'Deskripsi video',
        'id_kelas' => 1,
    ]);
});

// DESTROY - Path 1
test('Gagal menghapus materi sebagai guru', function () {
    $materi = Materi::create([
        'judul' => 'Video Test',
        'link_video' => 'https://youtube.com/test',
        'id_kelas' => 1,
    ]);

    $guru = User::factory()->create([
        'role' => 'guru',
        'email_verified_at' => now(),
    ]);

    $response = $this
        ->actingAs($guru)
        ->delete(route('materi.destroy', $materi->id));

    $response->assertForbidden();
});

// DESTROY - Path 2
test('Gagal menghapus materi ketika ID tidak ditemukan', function () {
    $response = $this->delete(route('materi.destroy', 9999));

    $response->assertNotFound();
});

// DESTROY - Path 3
test('Berhasil menghapus materi', function () {
    $materi = Materi::create([
        'judul' => 'Video Test',
        'link_video' => 'https://youtube.com/test',
        'id_kelas' => 1,
    ]);

    $response = $this->delete(route('materi.destroy', $materi->id));

    $response->assertRedirect(route('materi.index', 1));

    $this->assertDatabaseMissing('materis', [
        'id' => $materi->id,
    ]);
});
