<?php

namespace App\Http\Controllers\Api\LockerStorage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\LockerStorage\{File,FileShare};

class ShareFileController extends Controller
{
    function index(Request $request){
        $files = FileShare::where('user_id',$request->user_id)->get();
        foreach($files as $file){
            $file->file;
        }
        return response()->json($files,200);
    }
}
