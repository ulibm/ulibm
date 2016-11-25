<?php // พ
function str_remjump_numeric($wh,$sepper="-") {
	$t=explode($sepper,$wh);
	$t=array_unique($t);
	$t=arr_filter_remnull($t);
	$tmp=each($t);
	$tmp=$tmp[key];
	$res="$t[$tmp]";
	$expect=($t[$tmp]);
	unset($t[$tmp]);
	//reset($t);
	$lastrepeat="";
	foreach ($t as $key => $value) {
		if ($value>($expect+1)) {
			$res.="-".$lastrepeat.",".$value;
			$lastrepeat="";
		} elseif ($value>=$expect) {
			$lastrepeat=$value;
			//$res.="$sepper".$value;
		} else {
			//$res.="?".$value;
		}
		$expect=($value+1);
	}
	$res.="-".$lastrepeat;
	/*
	$min=floor(min($t));
	$max=ceil(max($t));
	echo $min.".".$max;
	for ($i=$min;$i<=$max;$i++) {
		$str=($i-2)."$sepper".($i-1)."$sepper".$i;
		$res=str_replace("$str","",$res);
	}*/
	$res=trim($res,$sepper);
	$res=trim($res,",");
	$res=trim($res,"-");
	$res=str_replace("-,",",",$res);
	return $res;
}
?>