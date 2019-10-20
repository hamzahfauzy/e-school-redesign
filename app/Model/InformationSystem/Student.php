<?php

namespace App\Model\InformationSystem;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function class_room(){
        return $this->belongsToMany(Classroom::class);
    }
}
