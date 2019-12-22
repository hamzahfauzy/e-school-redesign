<?php

namespace App\Http\Controllers\Api\LockerStorage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\LockerStorage\{Folder,File,FileShare};
use App\User;

class FileController extends Controller
{
    function index(Request $request, $folder)
    {
    	$folder = $folder ? $folder : 0;
    	$folders = Folder::where('user_id',$request->user_id)->where('parent_id',$folder)->get();
    	$files = File::where('user_id',$request->user_id)->where('folder_id',$folder)->get();

    	return response()->json(['folders'=>$folders,'files'=>$files],200);

    }

    function all(Request $request){
        $files = File::where('user_id',$request->user_id)->orderBy('id','desc')->get();
        foreach($files as $file)
    		$file->storage_url = Storage::url($file->url);
        return response()->json($files,200);
    }

    function single($id){
        $file = File::find($id);
    	$file->storage_url = Storage::url($file->url);
        return response()->json($file,200);
    }

    function upload(Request $request)
    {
    	if($request->hasfile('file'))
        {
            foreach($request->file('file') as $file)
            {
                $user = User::find($request->user_id);

                $destinationPath = public_path()."/uploads/schools/".$user->school[0]->id.'/'.$request->user_id;
                if(!file_exists($destinationPath))
                    mkdir($destinationPath);

                $name=$file->getClientOriginalName();
                $file->move($destinationPath, $name);

                $url = $destinationPath.'/'.$name;

    			$model = new File;
                $model->create([
		    		'folder_id' => $request->parent_id,
		    		'name' => $name,
		    		'url' => $url,
		    		'size' => $file->getSize(),
		    		'user_id' => $request->user_id,
		    	]);
            }
        }

    	return response()->json([
            'success' => 1
        ],200);
    }

    function share(Request $request){
        $input = $request->only('file_id','user_id');
        $fs = FileShare::create($input);
        return response()->json([
            'success' => 1
        ],200);
    }

    function delete(Request $request)
    {
        $file = File::where('id',$request->id)->where('user_id',$request->user_id)->first();
        unlink($file->url);
        $file->delete();
        return response()->json([
            'success' => 1
        ],200);
    }

    function updateVisibility(Request $request)
    {
        $file = File::where('id',$request->id)->where('user_id',$request->user_id)->first();
        $visibility = $file->visibility ? 0 : 1;
        $file->update([
            'visibility' => $visibility
        ]);
        return response()->json([
            'success' => 1
        ],200);
    }
}
