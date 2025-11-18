<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = ['tugas_id', 'siswa_id', 'submitted_at','is_late' ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function files()
    {
        return $this->hasMany(PengumpulanTugasFile::class);
    }
}
