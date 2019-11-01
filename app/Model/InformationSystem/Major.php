<?php

namespace App\Model\InformationSystem;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function class_rooms(){
        return $this->hasMany(Classroom::class);
    }
}
