<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Elearning\Exam;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!auth()->user()->isRole($role))
            abort(401, 'You are not allowed to access this page');

        if($role == 'siswa')
        {
            $now = \Carbon\Carbon::now();
            $exams = Exam::where('start_at','<',$now)->where('finish_at','>',$now)->get();

            foreach($exams as $exam)
            {
                $checker = $exam->students()->where('student_id',auth()->user()->id)->first();
                if(!empty($checker) && \Request::route()->getName() != 'students.exams.show' && $checker->pivot->status == 1)
                    return redirect()->route('students.exams.show', $exam->id);
            }
        }
        
        return $next($request);
    }
}
