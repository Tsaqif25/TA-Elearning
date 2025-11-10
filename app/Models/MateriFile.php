<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MateriFile extends Model
{
    use HasFactory;

    protected $fillable = ['materi_id', 'file'];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}
