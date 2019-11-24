<?php

namespace App\Model\Elearning;

use Illuminate\Database\Eloquent\Model;
use App\Model\InformationSystem\{Study,Student,Classroom};
use App\User;
use App\Model\Post;

class Exam extends Model
{
    protected $guarded = [];

    function questions(){
    	return $this->belongsToMany(Question::class)->withPivot('id');
    }

    function students(){
    	return $this->belongsToMany(User::class,'exam_student','exam_id','student_id')->withPivot('exam_id','student_id','status');
    }

    function study()
    {
    	return $this->belongsTo(Study::class);
    }

    function teacher()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    function classroom()
    {
    	return $this->belongsTo(Classroom::class);
    }

    function student()
    {
        return $this->hasOne(ExamStudent::class);
    }

    function post()
    {
        $model = Post::whereIn('post_as',['Latihan','Ulangan Harian','UTS','UAS'])->where('post_as_id',$this->id)->first();
        return $model;
    }

}
