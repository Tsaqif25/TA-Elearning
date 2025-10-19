<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_mapel_id',
        'name',
        'content',
        'due',
    
    ];



    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

  

    public function userTugas()
    {
        return $this->hasmany(UserTugas::class);
    }

  

    public function files()
{
    return $this->hasMany(TugasFile::class);
}

}
