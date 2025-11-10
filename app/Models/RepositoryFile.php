<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepositoryFile extends Model
{
    use HasFactory;

    protected $fillable = ['repository_id', 'file'];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
