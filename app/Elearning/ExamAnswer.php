<?php

namespace App\Elearning;

use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    protected $guarded = [];

    public function answer()
    {
    	return $this->hasOne(QuestionAnswer::class,'id','question_answer_id');
    }
}
