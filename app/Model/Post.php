<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Elearning\Exam;
use App\User;

class Post extends Model
{
    //
    protected $guarded = [];

    function exam()
    {
    	if(!in_array($this->post_as,['Latihan','Ulangan Harian','UTS','UAS']))
    		return false;
    	return Exam::find($this->post_as_id);
    }

    function user()
    {
    	return $this->belongsTo(User::class);
    }

    function comments()
    {
    	return $this->hasMany(Comment::class);
    }

    function comment($user_id)
    {
    	return Comment::where('post_id',$this->id)->where('user_id',$user_id)->first();
    }

}
