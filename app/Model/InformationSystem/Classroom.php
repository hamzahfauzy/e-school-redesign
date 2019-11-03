<?php

namespace App\Model\InformationSystem;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Classroom extends Model
{
    protected $guarded = [];

    public function major(){
        return $this->belongsTo(Major::class);
    }

    public function students(){
        return $this->belongsToMany(User::class,'classroom_student');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
