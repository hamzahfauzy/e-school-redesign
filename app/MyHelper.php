<?php

namespace App;

class MyHelper {

	public static function get($url)
	{
		$url = $url[0];
		// $file = file_get_contents($url);
		// $tmpfname = tempnam("/tmp", "FOO");
		// $handle = fopen($tmpfname, "w");
		// fwrite($handle, $file);

		// $size = getimagesize($tmpfname);
		// if(($size['mime'] == 'image/png') || ($size['mime'] == 'image/jpeg')){
		//    //do something with the $file
		//    return "<a href='$url' target='_blank'><img src='$url' width='100%'></a>";
		// }
		// else{
		    return "<a href='$url' target='_blank'>$url</a>";
		//     fclose($handle);
		// }
	}
}