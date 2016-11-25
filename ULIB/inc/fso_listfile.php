<?php // พ
function fso_listfile($s,$limitsize=0) {
//  $limitsize as kb
	////func("fso_listfile");
$res=Array();
	if ($handle = opendir($s)) {

	    /* This is the correct way to loop over the directory. */
	    while (false !== ($file = readdir($handle))) { 
  			if ($file=="." || $file == "..") {
  				continue;
  			}
			//echo "$file";
				if ($limitsize!=0) {
					 //echo filesize("$s/$file")."<br>";
					 if ((filesize("$s/$file"))<($limitsize*1000)) {
					 		continue;
					 }
				}
			 $res[]="$file";
	    }

	    closedir($handle); 
	} else {
		//echo "fso_listfile($s,$limitsize=0) error, cannot open dir;";
	}
	@sort($res);
	return $res;
}
?>