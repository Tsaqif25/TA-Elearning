<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiTugas extends Model
{
    protected $fillable = ['tugas_id','siswa_id','nilai'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa(){
        return $this->belongsTo(DataSiswa::class,'siswa_id');
    }
}
