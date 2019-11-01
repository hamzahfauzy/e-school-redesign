<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class ExamItem extends Model
{
    protected $guarded = [];

    function exam()
    {
    	return $this->hasOne(Exam::class,'id','exam_id');
    }

    function question()
    {
    	return $this->hasOne(Question::class,'id','question_id');
    }
}
