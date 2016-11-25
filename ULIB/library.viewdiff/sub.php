<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="viewstrdiff";
$tmp=mn_lib();
$cate=tmq("select * from viewdiffman_cate where code='$pid' ");
$cate=tfa($cate);

pagesection($tmp.":".getlang($cate[name]));

$tbname="viewdiffman";


$c[1][text]="รหัส::l::Code";
$c[1][field]="type";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="student";

//dsp

/*
$dsp[1][text]="รหัส::l::Code";
$dsp[1][field]="type";
$dsp[1][width]="20%";
*/

$dsp[2][text]="รายละเอียด::l::Detail";
$dsp[2][field]="name";
$dsp[2][filter]="module:local_name";
$dsp[2][width]="50%";
function local_name($wh) {
	return ymd_datestr($wh[dt])." (".ymd_ago($wh[dt]).") :".get_library_name($wh[loginid]);
}

$dsp[3][text]="ดู::l::View";
$dsp[3][field]="id";
$dsp[3][align]="center";
$dsp[3][filter]="module:local_man";
$dsp[3][width]="30%";
function local_man($wh) {
	$s="<a href=\"viewdiff.php?viewid=$wh[id]\" class=a_btn target=_blank>".getlang("ดู::l::View")."</a>";
		
	return $s;
}
$limit="";
if ($filterid!="") {
	$limit=" and code='$filterid' ";
}
fixform_tablelister($tbname," cate='$pid' $limit",$dsp,"no","no","no","mi=$mi&pid=$pid&filterid=$filterid",$c,"id desc",$o);
?><center><a href="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a></center><?php 
foot(); 
?>