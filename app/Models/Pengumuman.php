<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengumuman extends Model
{
    use HasFactory;
        // ✅ Baris penting agar Laravel tidak salah menebak nama tabel
    protected $table = 'pengumumans';
    protected $fillable = ['user_id', 'judul', 'isi', 'lampiran', 'published_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
