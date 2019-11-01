<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    public function customer(){
    	return $this->hasOne(Customer::class,'id','customer_id');
    }

}
