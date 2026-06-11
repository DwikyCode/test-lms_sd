<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
    'nis',
    'nama',
    'kelas',
];
    public function nilai()
    {
        // Artinya: Satu Siswa punya banyak Nilai
        return $this->hasMany(Nilai::class, 'siswa_id'); 
    }
}
