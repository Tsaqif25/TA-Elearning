<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelas_mapel_id',
          'no_telp',
        'nip',
    ];

    // protected $guarded = [
    //     'id'
    // ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }
}
