<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Role;
use App\Model\InformationSystem\{Study,Major,Classroom};

class SchoolProfile extends Model
{
    protected $guarded = [];

    public function users()
    {
    	return $this->belongsToMany(User::class,'school_users', 'school_id', 'user_id', 'id', 'id');
    }

    public function students()
    {
        $students = [];
    	$users = $this->users;
        foreach($users as $user)
            if($user->isRole('siswa'))
                $students[] = $user;
        return $students;
    }

    public function teachers()
    {
        $students = [];
        $users = $this->users;
        foreach($users as $user)
            if($user->isRole('guru'))
                $students[] = $user;
        return $students;
    }

    public function studies()
    {
    	return $this->hasMany(Study::class,'school_id','id');
    }

    public function majors()
    {
        return $this->hasMany(Major::class,'school_id','id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class,'school_id','id');
    }
}
