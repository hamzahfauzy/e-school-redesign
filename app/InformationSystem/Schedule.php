<?php

namespace App\InformationSystem;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    function employee_study(){
        return $this->belongsTo(EmployeeStudy::class,'study_teacher_id');
    }
}
