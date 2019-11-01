<?php

namespace App\Http\Controllers\Api\InformationSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\InformationSystem\Major;
use Validator;

class MajorController extends Controller
{
    public $success = 200;

    public function index(){
        $majors = Major::get();
        return response()->json($majors,$this->success);
    }

    public function single($id){
        $major = Major::find($id);
        return response()->json($major,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('name');
        $major = Major::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'name'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('name');
        $major = Major::find($request->id);
        $major->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $major = Major::find($request->id);
        $major->delete();
        return response()->json(['success'=>1],$this->success);
    }
}
