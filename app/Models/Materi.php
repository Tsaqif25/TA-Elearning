<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_mapel_id', 'name', 'konten', 'youtube_link','user_id'];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

    public function files()
    {
        return $this->hasMany(MateriFile::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
