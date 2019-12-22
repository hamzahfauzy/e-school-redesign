<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Model\{SchoolProfile,Role,Customer};
use App\Model\Elearning\{Question,Exam};
use App\Model\InformationSystem\{Classroom,Study,ClassroomStudy};

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status','picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class)->withPivot('id','user_id','role_id');
    }

    public function isRole($role_name)
    {
        $roles = $this->roles()->where('slug',$role_name)->first();
        return $roles;
    }

    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function school(){
        return $this->belongsToMany(SchoolProfile::class,'school_users', 'user_id', 'school_id', 'id')->withPivot('id','user_id','school_id');
    }

    public function customer(){
        return $this->hasOne(Customer::class, 'user_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class,'user_id');
    }

    public function studies()
    {
        return $this->belongsToMany(Study::class,'classroom_study')->using(ClassroomStudy::class)->withPivot('id','study_id','classroom_id','user_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class,'classroom_study')->using(ClassroomStudy::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function getClassroom()
    {
        return $this->belongsToMany(Classroom::class,'classroom_student')->withPivot('id','user_id','classroom_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }


}
