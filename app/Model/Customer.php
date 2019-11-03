<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Customer extends Model
{
    protected $guarded = [];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function school(){
    	return $this->hasOne(SchoolProfile::class,'customer_id','id');
    }
}
