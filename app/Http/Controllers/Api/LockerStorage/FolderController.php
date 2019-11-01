<?php

namespace App\Http\Controllers\Api\LockerStorage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\LockerStorage\Folder;

class FolderController extends Controller
{
    function index()
    {

    }

    function create(Request $request)
    {
    	$folder = new Folder;
    	$folder->create([
    		'parent_id' => $request->parent_id,
    		'name' => $request->name,
    		'user_id' => $request->user_id,
    	]);

    	return 1;
    }

    function delete(Request $request)
    {
        $folder = Folder::where('id',$request->id)->where('user_id',$request->user_id)->first();
        $folder->delete();
        return 1;
    }
}
