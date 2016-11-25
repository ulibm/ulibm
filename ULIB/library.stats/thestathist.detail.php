<?php  //พ
$dsp[2][text]="Statistic";
$dsp[2][field]="head";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localheaddsp";

$dsp[3][text]="Detail";
$dsp[3][field]="foot";
$dsp[3][filter]="module:localfootdsp";
$dsp[3][width]="30%";

$dsp[7][text]="Date";
$dsp[7][field]="dt";
$dsp[7][filter]="datetime";
$dsp[7][align]="center";
$dsp[7][width]="30%";

function localfootdsp($wh) {
	global $db;
	global $sdb;
	return local_getdspstr($wh[foot],$sdb[$db][footmode]);
}

function localheaddsp($wh) {
	global $db;
	global $sdb;
	return local_getdspstr($wh[head],$sdb[$db][headmode]);
}


$tbname=$tbl;
$limit=" 1 ";
if ($limitfoot!="") {
	$limit.=" and foot='$limitfoot' ";
}
$limit.=" and dt>='$limitdates' and dt<='$limitdatee' ";

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","db=$db&mode=detail&$addquery",$c);

sessionval_set("stat_getcsvfromcache_source",$tbname);
sessionval_set("stat_getcsvfromcache_cmd",$limit);

?><center><a href="_getcsvfromcache.php?&getcsv=yes" class="a_btn smaller2" target=_blank>get .csv</a>
</center>