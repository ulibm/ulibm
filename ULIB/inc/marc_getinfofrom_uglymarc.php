<?php  //พ
function marc_getinfofrom_uglymarc($d) {
	$res="";
	$a=explodenewline($d);
//		$a=explode("\n",$d);
foreach ($a as $value) {
	$dec=substr($value,0,3);
	if ($dec=="245" || $dec=="110") {
		$str=substr($value,7);
		$str=str_replace('$',"^",$str);
		$str=dspmarc($str);
		$res=$res.", ".$str;
	}
}

$dec=str_replace(",","",$res);
if (trim($dec)=="") {
	$res="[No Title]";
}
$res=trim($res,",");
return stripslashes($res);
}
?>