<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $guarded = ['id']; // Semua kolom boleh diisi

    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }
}