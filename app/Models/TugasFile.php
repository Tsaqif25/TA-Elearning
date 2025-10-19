<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tugas_id',
        'file',
    ];

    // public function tugas()
    // {
    //   return  $this->belongsTo(UserTugas::class);
    // }

    public function tugas()
{
    return $this->belongsTo(Tugas::class);
}

}
