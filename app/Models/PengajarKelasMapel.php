<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajarKelasMapel extends Model
{
    use HasFactory;

    protected $fillable = ['guru_id', 'kelas_mapel_id'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }
}
