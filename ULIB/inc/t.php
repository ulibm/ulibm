<?php //พ
$_TFUNCARR=Array();
$_TTBSTRUCTARR=Array();
$_TFUNCID_CUR=0;
function t($q1=false,$q2="",$q3="",$q4=false,$_TFUNCID="") {
	//q1
	//e = execute
	//g = get sql
	//es = execute and show

	//echo "<br>[t($q1,$q2,$q3,$q4,$_TFUNCID)]";
	global $_TFUNCID_CUR;
	global $_TFUNCARR;
	if (floor($_TFUNCID_CUR)==0) {
		$_TFUNCID_CUR=1;
	}
	if (trim($_TFUNCID)=="") {
		//$_TFUNCID_CUR=floor($_TFUNCID_CUR)+1;
		$_TFUNCID=$_TFUNCID_CUR;
	}
	//echo "_TFUNCID=$_TFUNCID/_TFUNCID_CUR=$_TFUNCID_CUR/$q1,$q2<br>";
	//execute
	if ($q1=="g") { // get query
		$s=t_buildsql($_TFUNCARR[$_TFUNCID]);
		$_TFUNCID_CUR=floor($_TFUNCID_CUR)+1;
		return $s;
	}
	//printr( debug_backtrace());
	
	if ($q1=="e" || $q1=="es" || (is_bool($q1) && ($q1==false || $q1==true))) {
		//echo "<br>[q1=$q1]";
		//echo "<br>[t() execute $_TFUNCID;]";
		//build sql
		//echo "[$q1]";
		if ((is_bool($q1) && $q1==true) || $q1=="es") {
			//echo "t isbool";
			echo "current _TFUNCID_CUR is $_TFUNCID_CUR; running ID is $_TFUNCID<br>";
			printr($_TFUNCARR[$_TFUNCID]);
		}
		$s=t_buildsql($_TFUNCARR[$_TFUNCID]);
		//echo "[[[[$s]]]";
		if ((is_bool($q1) && $q1==true) || $q1=="es") {
			echo "<hr><pre>$s</pre><hr>";
		}
		if (is_numeric($_TFUNCID)) { // if auto by running
			$_TFUNCID_CUR=floor($_TFUNCID_CUR)+1;
		}
		//unset used array
		//echo "<br>t() unsetting $_TFUNCID";
		unset($_TFUNCARR[$_TFUNCID]);
		//printr($_TFUNCARR);
		//echo "<pre>$s</pre>";
		return tmq($s);
		//return $_TFUNCARR[$_TFUNCID];
	}
	if (!isset($_TFUNCARR[$_TFUNCID]) || !is_array($_TFUNCARR[$_TFUNCID])) {
		$_TFUNCARR[$_TFUNCID]=Array();
	}
	if (!isset($_TFUNCARR[$_TFUNCID][$q1]) || !is_array($_TFUNCARR[$_TFUNCID][$q1])) {
		$_TFUNCARR[$_TFUNCID][$q1]=Array();
	}
	$localnewid=@floor(@count($_TFUNCARR[$_TFUNCID][$q1]));
	$_TFUNCARR[$_TFUNCID][$q1][$localnewid]["a"]=$q2;
	$_TFUNCARR[$_TFUNCID][$q1][$localnewid]["b"]=$q3;
	$_TFUNCARR[$_TFUNCID][$q1][$localnewid]["c"]=$q4;
	/*
	if (is_bool($q3) && $q3=="") {
		$_TFUNCARR[$_TFUNCID][$q1][]=$q2;
	} else {
		$_TFUNCARR[$_TFUNCID][$q1][$q2]=$q3;
	}*/
}

?>