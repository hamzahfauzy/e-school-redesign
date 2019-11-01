<?php

namespace App\Model\InformationSystem;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function studies(){
        return $this->belongsToMany(Study::class);
    }

    public function class_rooms(){
        return $this->belongsToMany(Classroom::class,'employee_study');
    }

    public function employee_studies(){
        return $this->hasMany(EmployeeStudy::class);
    }
}
