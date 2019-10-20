<?php

namespace App\Model\LockerStorage;

use Illuminate\Database\Eloquent\Model;

class FileShare extends Model
{
    protected $guarded = [];

    function file(){
        return $this->belongsTo(File::class);
    }
}
