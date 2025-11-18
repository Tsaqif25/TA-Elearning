<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasKomentar extends Model
{
    // protected $table = "tugas_komentar";
    protected $fillable = ["tugas_id", "user_id", "komentar"];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
