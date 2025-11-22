<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasKomentar extends Model
{
   protected $fillable = [
    'tugas_id',
    'siswa_id',
    'user_id',
    'pesan'
   ];

   public function user()
   {
    return $this->belongsTo(User::class);
   }
   public function siswa()
   {
    return $this->belongsTo(DataSiswa::class,'siswa_id');
   }
   public function tugas()
   {
    return $this->belongsTo(Tugas::class);
   }
}
