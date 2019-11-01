<?php

namespace App\Model\InformationSystem;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $guarded = [];

    public function major(){
        return $this->belongsTo(Major::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class);
    }
}
