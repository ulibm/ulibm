<?php // พ
function fso_file_importmelt($fpath,$reclimit=10,$roundlimit=10000,$sep_rec="\n",$sep_field=",",$cover_field="'") {
	$handle = fopen("$fpath", "rb");
	$i=0;
	$reclist=Array();
	$wholebuffer="";
	$roundcount=0;
	while (!feof($handle)) {
		$roundcount++;
		if ($i>$reclimit || $roundcount>=$roundlimit) {
			break;
		}
		$buffer =  fread($handle, 1) ;
		//echo "(".("$buffer")."==".$sep_rec.")";
		if ($buffer==$sep_rec) {
		//echo "(*************************)";
			$i++;
			$reclist[]=$wholebuffer;
			$wholebuffer="";
		} else {
			$wholebuffer=$wholebuffer.$buffer;
		}
	}
	//$reclist[]=$buffer;
	//print_r($reclist);
	//echo "$roundcount";
	fclose($handle);

	$reclistcount=count($reclist);
	for ($i=0;$i<=$reclistcount;$i++) {
		$reclist[$i]=explode($sep_field,$reclist[$i]);
	}

	for ($i=0;$i<=$reclistcount;$i++) {
		$fieldcount=count($reclist[$i]);
		for ($j=0;$j<=$fieldcount;$j++) {
			$tmp=trim($reclist[$i][$j],$cover_field);
			$tmp=trim($tmp);
			$reclist[$i][$j]=$tmp;
		}
	}
	return $reclist;
}
?>