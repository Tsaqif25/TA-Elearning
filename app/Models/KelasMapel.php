<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMapel extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_id', 'mapel_id'];

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mapel() { return $this->belongsTo(Mapel::class); }

    public function pengajarKelasMapels()
    {
        return $this->hasMany(PengajarKelasMapel::class);
    }

    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'pengajar_kelas_mapels', 'kelas_mapel_id', 'guru_id');
    }

    public function materis() { return $this->hasMany(Materi::class); }
    public function tugas()   { return $this->hasMany(Tugas::class); }
    public function ujians()  { return $this->hasMany(Ujian::class); }
}
