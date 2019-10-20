<?php

namespace App\Elearning;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = [];

    function items(){
    	return $this->hasMany(ExamItem::class,'exam_id','id');
    }

    function students(){
    	return $this->hasMany(ExamStudent::class,'exam_id','id');
    }
}
