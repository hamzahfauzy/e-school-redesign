<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    protected $hidden = ['key_answer_id'];

    public function answers()
    {
    	return $this->hasMany(QuestionAnswer::class);
    }
}
