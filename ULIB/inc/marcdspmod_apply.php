<?php // พ
function marcdspmod_apply($raw,$id) {
	//echo "marcdspmod_apply($tag,$str)";
	if (!is_array($raw)) {
		return $raw;
	}
	$s=tmq("select * from marcdspmod_main where id='$id' ");
	if (tnr($s)!=1) {
		return $raw;
	}
	$s=tfa($s);
	$s2=tmq("select * from marcdspmod_modrule where pid='$id' order by ordr ");
	while ($r=tfa($s2)) {
		//printr($r);
	  $base=substr($raw[$r[tagid]],0,2);
	  $raw[$r[tagid]]=substr($raw[$r[tagid]],2);
	  
		if ($r[decis]=="add subfield" || $r[decis]=="set subfield") {
			$raw[$r[tagid]]=rtrim($raw[$r[tagid]]);
			if (strlen($raw[$r[tagid]])==0) {
				$raw[$r[tagid]]="  ";
			}
			$tmp=marc_getsubfields($raw[$r[tagid]],"no"); //printr($tmp);
			//$base=substr($raw[$r[tagid]],0,2);
			$tmp[$r[subfield]]=$r[val1];
			@ksort($tmp);
			@reset($tmp);
			$tmpstr="$base";
			while (list($k,$v)=each($tmp)) {
				$tmpstr.="^$k$v";
			}
			$raw[$r[tagid]]=$saveindi.$tmpstr;

		}
		if ($r[decis]=="remove subfield") {
			$raw[$r[tagid]]=rtrim($raw[$r[tagid]]);
			if (strlen($raw[$r[tagid]])==0) {
				$raw[$r[tagid]]="  ";
			}
			$tmp=marc_getsubfields($raw[$r[tagid]],"no"); //printr($tmp);
			$base=substr($raw[$r[tagid]],0,2);
			$tmp[$r[subfield]]="";
			unset($tmp[$r[subfield]]);
			$tmp=arr_filter_remnull($tmp);
			@ksort($tmp);
			@reset($tmp);
			$tmpstr="$base";
			while (list($k,$v)=each($tmp)) {
			   //echo "[$k] ";
			   if (trim($k)=="") continue;
				$tmpstr.="^$k$v";
			}
			$raw[$r[tagid]]=$tmpstr;
		}
		if ($r[decis]=="set tag") {
			$raw[$r[tagid]]=$r[val1];
		}
		if ($r[decis]=="remove tag") {
			$raw[$r[tagid]]="";
		}
		if ($r[decis]=="replace string") {
			$raw[$r[tagid]]=str_replace($r[val1],$r[val2],$raw[$r[tagid]]);
		}
	}
	//printr($raw);
	return $raw;
}
?>