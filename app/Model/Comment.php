<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Comment extends Model
{
    protected $guarded = [];

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
