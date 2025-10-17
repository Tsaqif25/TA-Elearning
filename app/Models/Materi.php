<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
use HasFactory;

protected $fillable = [
    'kelas_mapel_id',
    'name',
    'content',
    'youtube_link'
];

// protected $guarded = [
//     'id',
// ];

public function kelasMapel()
{
    return $this->belongsTo(KelasMapel::class);
}

public function files()
{
return $this->hasMany(MateriFile::class);
}





public function userMateri()
{
    return $this->hasMany(UserMateri::class);
}
}
