<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_mapel_id', 'name', 'deskripsi', 'due'];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

    public function files()
    {
        return $this->hasMany(TugasFile::class);
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

    
}
