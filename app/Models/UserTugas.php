<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'tugas_id',
        'user_id',
        'status',
        'nilai',
    ];

 

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    // public function users()
    // {
    //     return $this->belongsTo(User::class);
    // }

public function user()
{
    return $this->belongsTo(User::class);
}


    public function userTugasFile()
    {
        return $this->hasMany(UserTugasFile::class);
    }
}
