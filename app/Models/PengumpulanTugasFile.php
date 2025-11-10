<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengumpulanTugasFile extends Model
{
    use HasFactory;

    protected $fillable = ['pengumpulan_tugas_id', 'file'];

    public function pengumpulanTugas()
    {
        return $this->belongsTo(PengumpulanTugas::class);
    }
}
