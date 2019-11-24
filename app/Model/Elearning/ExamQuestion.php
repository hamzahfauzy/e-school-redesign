<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $guarded = [];
    protected $table = 'exam_question';

    function exam()
    {
    	return $this->hasOne(Exam::class,'id','exam_id');
    }

    function question()
    {
    	return $this->hasOne(Question::class,'id','question_id');
    }

}
