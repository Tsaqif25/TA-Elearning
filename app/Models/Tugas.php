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
        // 'isHidden',
    ];



    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

    public function forumDiskusi()
    {
        return $this->hasMany(Diskusi::class);
    }

    public function userTugas()
    {
        return $this->hasmany(UserTugas::class);
    }

    public function tugasFile()
    {
        return $this->hasMany(TugasFile::class);
    }
}
