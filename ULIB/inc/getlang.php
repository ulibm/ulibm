<?php  // พ
function getlang($str,$tmplang="") {
	global $_SESSION;
	if (trim($_SESSION["lang_control_val"])=="") {
		//debug_print_backtrace();
		$_SESSION["lang_control_val"]=getval("_SETTING","default_lang");
	}
	$str=str_replace("::|::","::l::",$str);
	$str=explode("::l::",$str);
	if ($tmplang=="th" && $str[0]!="") {
			return $str[0];
	}
	if ($tmplang=="en" && $str[1]!="" ) {
			return $str[1];
	}
		if (!isset($_SESSION['lang_control_val']) || $_SESSION['lang_control_val']=='th' || trim($str[1])=="" ) {
			$tmpl1= $str[0];
		} elseif ($_SESSION['lang_control_val']=='en' ) {
			$tmpl1= $str[1];
		}

	return $tmpl1;
}
?>