<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Elearning\Announcement;
use Validator;

class AnnouncementController extends Controller
{
    public $success = 200;

    public function index($teacher_id){
        $announcements = Announcement::where('teacher_id',$teacher_id)->get();
        return response()->json($announcements,$this->success);
    }

    public function single($id){
        $announcement = Announcement::find($id);
        return response()->json($announcement,$this->success);
    }

    public function getByClassroom($classroom){
        $announcements = Announcement::where('classroom_id',$classroom)->where('expired_at','>=',Carbon::now())->orderby('created_at','desc')->get();
        return response()->json($announcements,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'classroom_id'  =>  'required',
            'teacher_id'    =>  'required',
            'messages'      =>  'required',
            'expired_at'    =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('classroom_id','teacher_id','messages','expired_at');
        $announcement = Announcement::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'classroom_id'  =>  'required',
            'teacher_id'    =>  'required',
            'messages'      =>  'required',
            'expired_at'    =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('classroom_id','teacher_id','messages','expired_at');
        $announcement = Announcement::find($request->id);
        $announcement->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $announcement = Announcement::find($request->id);
        if($announcement->teacher_id == $request->teacher_id)
        {
            $announcement->delete();
            return response()->json(['success'=>1],$this->success);
        }
        return response()->json(['success'=>0],$this->success);
    }
}
