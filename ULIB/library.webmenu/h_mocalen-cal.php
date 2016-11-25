<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="mocal-cal";
mn_lib();

$localcatehead="yes";

pagesection("จัดการข้อมูล ปฏิทินกิจกรรม");
$tbname="webpage_mocalen";



$c[2][text]="Title";
$c[2][field]="title";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[12][text]="วันเดือนปี::l::Date";
$c[12][field]="dt";
$c[12][fieldtype]="date";
$c[12][descr]="";
$c[12][defval]=time();

$c[10][text]="แสดงกิจกรรมนี้หรือไม่::l::Show this event";
$c[10][field]="isshow";
$c[10][fieldtype]="list:yes,no";
$c[10][descr]="";
$c[10][defval]="yes";

$c[11][text]="เนื้อหา::l::Content";
$c[11][field]="text";
$c[11][fieldtype]="html";
$c[11][addon]="globalupload::";
$c[11][descr]="";
$c[11][defval]="";

$c[14][text]="ไม่อนุญาตการคอมเมนท์::l::Disable comment";
$c[14][field]="disablecomment";
$c[14][fieldtype]="list:yes,no";
$c[14][descr]="";
$c[14][defval]="no";

$c[14][text]="จำนวนการคอมเมนท์ที่อนุญาต::l::max number of comment";
$c[14][field]="maxresp";
$c[14][fieldtype]="number";
$c[14][descr]="ถ้าหากอนุญาตการคอมเมนท์::l::If comment allowed";
$c[14][defval]="10";

$c[15][text]="สี::l::Color";
$c[15][field]="col";
$c[15][fieldtype]="color";
$c[15][descr]=" เป็นสีพื้นหลัง ควรใช้สีเข้ม::l::Background color, should select darken color";
$c[15][defval]="#660000";

//dsp
function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/webpagemenu/$wh[icon]' width=48 height=48>";
}



$dsp[2][text]="เนื้อหา::l::Title";
$dsp[2][field]="title";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localcol";

function localcol($wh) {
		 return "$wh[title] <BR><B style='color:$wh[col]'>(".$wh[col].")</B>";;
}

$dsp[3][text]="คอมเมนท์::l::Comments";
$dsp[3][field]="title";
$dsp[3][align]="center";
$dsp[3][width]="20%";
$dsp[3][filter]="module:locallink";

function locallink($wh) {
	$sc=tmq("select * from webpage_mocalen_resp where pid='$wh[id]' ");
	$currentresp=tmq("select distinct memid from webpage_mocalen_resp where pid='$wh[id]' ");
	$currentresp=tmq_num_rows($currentresp);
				 return "<a href='./h_mocalen-cal-resp.php?valid=$wh[id]'>".getlang("คอมเมนท์::l::Comments")."</a><BR> (".(number_format(tmq_num_rows($sc))).
				getlang(" ครั้ง::l:: Comments")." ".(number_format($currentresp))."/$wh[maxresp])";;
}

$dsp[4][text]="วันที่::l::Date";
$dsp[4][field]="dt";
$dsp[4][align]="center";
$dsp[4][filter]="date";
$dsp[4][width]="20%";

$dsp[5][text]="แสดงหรือไม่::l::Isshow";
$dsp[5][field]="isshow";
$dsp[5][align]="center";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="20%";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," dt ");

foot();

?>