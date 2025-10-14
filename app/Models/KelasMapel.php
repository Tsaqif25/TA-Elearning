<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'mapel_id',
    ];

    // protected $guarded = [
    //     'id',
    // ];

    public function editorAccess()
    {
        return $this->hasMany(EditorAccess::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class);
    }


}
