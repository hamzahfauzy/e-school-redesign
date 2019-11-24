<?php

namespace App\Model\InformationSystem;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Elearning\Exam;

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

    public function studies(){
        return $this->belongsToMany(Study::class)->using(ClassroomStudy::class)->withPivot('user_id');
    }

    public function teachers(){
        return $this->belongsToMany(User::class,'classroom_study')->using(ClassroomStudy::class)->withPivot('study_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

}
