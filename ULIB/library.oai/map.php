<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="oaiman_map";
        $tmp=mn_lib();

$tbname="index_ctrl";

$c=Array();

//dsp


$dsp[1][text]="Index";
$dsp[1][filter]="module:localdsp";
$dsp[1][field]="type";
$dsp[1][width]="70%";
function localdsp($w) {
	$s="";
	$s=getlang($w[name]);
	return $s;
}

$dsp[2][text]="Index";
$dsp[2][filter]="module:localedit";
$dsp[2][field]="type";
$dsp[2][align]="center";
$dsp[2][width]="20%";
function localedit($w) {
	$s="<a href='map.sub.php?indexid=$w[code]'>".getlang("แก้ไข::l::Edit")."</a><br>";
	$s.=barcodeval_get("oaiman_map-$w[code]");
	$s.="";
	return $s;
}


fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"",$o);

				foot();
?>