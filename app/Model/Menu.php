<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];

    public function role()
    {
    	return $this->belongsTo(Role::class);
    }
}
