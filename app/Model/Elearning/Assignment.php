<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = [];

    function answers()
    {
    	return $this->hasMany(AssignmentAnswer::class,'assignment_id','id');
    }
}
