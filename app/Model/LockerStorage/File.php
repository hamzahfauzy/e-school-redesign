<?php

namespace App\Model\LockerStorage;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    function shares(){
        return $this->hasMany(FileShare::class);
    }
}
