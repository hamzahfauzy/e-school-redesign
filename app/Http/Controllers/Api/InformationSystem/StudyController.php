<?php

namespace App\Http\Controllers\Api\InformationSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\InformationSystem\Study;
use Validator;

class StudyController extends Controller
{
    public $success = 200;

    public function index(){
        $studies = Study::get();
        return response()->json($studies,$this->success);
    }

    public function single($id){
        $study = Study::find($id);
        return response()->json($study,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('name');
        $study = Study::create($input);
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
        $study = Study::find($request->id);
        $study->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $study = Study::find($request->id);
        $study->delete();
        return response()->json(['success'=>1],$this->success);
    }
}
