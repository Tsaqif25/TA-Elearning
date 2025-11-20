<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalUjian extends Model
{
    protected $fillable = [
        'ujian_id' ,
        'pertanyaan',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'answer',
    ];

    public function ujian(){
        return $this->belongsTo(Ujian::class);
    }
}
