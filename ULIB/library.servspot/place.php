<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();


$tbname="servicespot_room";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ข้อความเพิ่มเติม::l::Description";
$c[3][field]="descr";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Icon::l::Icon";
$c[4][field]="icon";
$c[4][fieldtype]="listimgfile:/neoimg/servspoticon/";
$c[4][descr]="";
$c[4][defval]="Documents.png";
$c[4][addon]="list-previewimg:$dcrURL"."neoimg/servspoticon,64,";


$c[5][text]="Minutesallow::l::Minutesallow";
$c[5][field]="minutesallow";
$c[5][fieldtype]="number";
$c[5][descr]="";
$c[5][defval]="60";

//dsp

function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/collectionicon/$wh[icon]' width=48 height=48>";
}
function localdsp($wh) {
	global $dcrURL;
	return " <B>".getlang($wh[name])."</B> <BR>".getlang($wh[descr])." ";
}

function localmanbtn($wh) {
	return "<B><A HREF='placesub.php?PARENT=$wh[id]'>".getlang("จัดการ::l::Manage")."</A></B>";
}

$dsp[4][text]="Icon::l::Icon";
$dsp[4][field]="icon";
$dsp[4][filter]="module:localicon";
$dsp[4][width]="6%";


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][filter]="module:localdsp";
$dsp[2][width]="40%";

$dsp[3][text]="จัดการ::l::Manage";
$dsp[3][field]="id";
$dsp[3][align]="center";
$dsp[3][filter]="module:localmanbtn";
$dsp[3][width]="15%";

$dsp[5][text]="อนุญาต (นาที)::l::Allow (Minutes)";
$dsp[5][field]="minutesallow";
$dsp[5][align]="center";
$dsp[5][width]="20%";



fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);


foot();
?>