<?php

namespace App\Model\InformationSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\User;

class ClassroomStudy extends Pivot
{
	protected $table = 'classroom_study';

    function study()
    {
    	return $this->belongsTo(Study::class);
    }

    function teacher()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }

    function classroom()
    {
    	return $this->belongsTo(Classroom::class);
    }
}
