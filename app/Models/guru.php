<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nip','no_telp', 'user_id'];
protected $table = 'gurus';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function pengajarKelasMapels()
    {
        return $this->hasMany(PengajarKelasMapel::class, 'guru_id');
    }
}
