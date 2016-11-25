<?php // พ

function iconvutf($str) {
	global $_DEFDBENCODE;
  //mb_language("Thai");
  //mb_detect_order ("TIS620, UTF-8, ASCII");
	//printr(mb_get_info());
	$currentenc=mb_detect_encoding($str, "auto");
	//iconv_set_encoding('output_encoding','TIS620');
	//echo "[$currentenc]";
	//if (isUTF8($str)) { echo "yes";} else { echo "no";}
	if ($currentenc=='') {
		 $currentenc=$_DEFDBENCODE;
	}
	if ($currentenc=='UTF-8') {
	//echo "ttt";
	   $str=iconv("$_DEFDBENCODE","UTF-8",$str); /// important
		 return $str;
	}
	if ($currentenc!="" ) {
		 $str2=iconv("$currentenc","UTF-8",$str);///SJIS/EUC-JP/
		 //$str2=mb_convert_encoding($str,'TIS-620',$currentenc); 
	} else {
	  $str=iconv("auto","UTF-8",$str);
		$str2=$str;
	}
	//echo"$currentenc [$str=>$str2]<br />";
	return $str2;
}
?>