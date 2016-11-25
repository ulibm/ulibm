<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("librarymenu");

$tbname="library_modules";



$c[2][text]="Icon::l::Icon";
$c[2][field]="icon";
$c[2][fieldtype]="listimgfile:/neoimg/menuicon/";
$c[2][descr]="";
$c[2][defval]="normal.png";
$c[2][addon]="list-previewimg:$dcrURL"."neoimg/menuicon,24,";

$c[3][text]="Code::l::Code";
$c[3][field]="code";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Name::l::Name";
$c[4][field]="name";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Url::l::Url";
$c[5][field]="url";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="[dcr]";

$c[6][text]="Nested::l::Nested";
$c[6][field]="nested";
$c[6][fieldtype]="foreign:-localdb-,library_modules_cate,code,name";
$c[6][descr]="";
$c[6][defval]=$main;

$c[8][text]="Isshow::l::Isshow";
$c[8][field]="isshow";
$c[8][fieldtype]="list:yes,no";
$c[8][descr]="";
$c[8][defval]="yes";

$c[10][text]="isbold::l::isbold";
$c[10][field]="isbold";
$c[10][fieldtype]="list:yes,no";
$c[10][descr]="";
$c[10][defval]="no";

$c[9][text]="Ordr::l::Ordr";
$c[9][field]="ordr";
$c[9][fieldtype]="number";
$c[9][descr]="";
$c[9][defval]="99999";

//dsp


$dsp[2][text]="Icon::l::Icon";
$dsp[2][field]="icon";
$dsp[2][filter]="module:localicon";
$dsp[2][width]="5%";

$dsp[3][text]="Code::l::Code";
$dsp[3][field]="code";
$dsp[3][width]="30%";

$dsp[4][text]="Name::l::Name";
$dsp[4][field]="name";
$dsp[4][width]="30%";

$dsp[5][text]="Url::l::Url";
$dsp[5][field]="url";
$dsp[5][width]="30%";

$dsp[6][text]="Nested::l::Nested";
$dsp[6][field]="nested";
$dsp[6][width]="30%";

$dsp[8][text]="Isshow::l::Isshow";
$dsp[8][field]="isshow";
$dsp[8][width]="30%";

function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/menuicon/$wh[icon]' width=16 height=16> [$wh[ordr]]";
}

$o[addlink][] = "index.php::back";

fixform_tablelister($tbname," nested='$main' ",$dsp,"yes","yes","yes","main=$main",$c,"ordr",$o);

foot();
?>