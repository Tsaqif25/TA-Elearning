<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
      protected $fillable = [
        'judul',
        'deskripsi',
        'kelas',
        'jurusan',
        'user_id',
        
    ];

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(RepositoryFile::class);
    }
}
