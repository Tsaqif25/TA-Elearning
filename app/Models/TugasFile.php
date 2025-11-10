<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TugasFile extends Model
{
    use HasFactory;

    protected $fillable = ['tugas_id', 'file'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
