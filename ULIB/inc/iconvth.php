<?php // พ

function iconvth($str) {
   //return $str;
  //mb_language("Thai");
  //mb_detect_order ("TIS620, UTF-8, ASCII");
	//printr(mb_get_info());
	  ini_set('mbstring.substitute_character', "none"); 

	$currentenc=mb_detect_encoding($str, "auto");
	//return "iconvth\$currentenc=$currentenc;";die;
	//iconv_set_encoding('output_encoding','TIS620');
	
	//if (isUTF8($str)) { echo "yes";} else { echo "no";}
	if ($currentenc!="" && isUTF8($str)) {
	    //$str=html_entity_decode(htmlentities($str, ENT_QUOTES, 'UTF-8'), ENT_QUOTES , 'TIS620');;
	    //$str=mb_convert_encoding($oldstring, 'TIS620', 'UTF-8');
		 $str2=iconv("$currentenc","TIS620//TRANSLIT",$str);///SJIS/EUC-JP/
		 $str3=iconv("$currentenc","TIS620//IGNORE",$str);///SJIS/EUC-JP/
		 if ($str2=="") {
		    $str2=$str3;
		 }
		 //$str2=mb_convert_encoding($str,'TIS-620',$currentenc); 
	} else {
		$str2=$str;
	}
	//return "$currentenc [$str=>$str2]<br />";
	return $str2;
}
?>