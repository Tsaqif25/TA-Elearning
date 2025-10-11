<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'multiple_id',
        'user_id',
        'soal_ujian_answer_id',
        'user_jawaban', 
      
    ];

 public function soalUjianMultiple()
{
    return $this->belongsTo(SoalUjianMultiple::class, 'multiple_id');
}


     public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function answer()
    {
        return $this->belongsTo(SoalUjianAnswer::class, 'soal_ujian_answer_id');
    }

  
}
