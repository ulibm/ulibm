<?php  //พ
$dsp[2][text]="Statistic";
$dsp[2][field]="head";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localheaddsp";

$dsp[3][text]="Counted";
$dsp[3][field]="cc";
$dsp[3][align]="center";
$dsp[3][width]="10%";

$dsp[7][text]="Last Update";
$dsp[7][field]="lastdt";
$dsp[7][filter]="date";
$dsp[7][align]="center";
$dsp[7][width]="30%";



function localheaddsp($wh) {
	global $db;
	global $sdb;
	return local_getdspstr($wh[head],$sdb[$db][headmode]);
}

$tbname=$tbl;
$limit=" 1 ";


fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","db=$db&mode=detail&$addquery",$c," lastdt desc ");

?>