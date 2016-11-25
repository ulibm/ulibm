<?php 
include("../inc/config.inc.php");
head();
mn_root("libmann");

$tbname="libmann";
if ($freecate!="yes") {
	$parent=tmq("select * from library_modules where code='$main' ",false);
	$parent=tfa($parent);
	$parent2=tmq("select * from library_modules_cate where code='$parent[nested]' ",false);
	$parent2=tfa($parent2);

	//printr($parent);
	//printr($parent2);
	$parent2[name]=getlang($parent2[name]);
	$parent[name]=getlang($parent[name]);

	html_dialog("Managing"," $parent2[name] -&gt; $parent[name]");
} else {
	$parent2=tmq("select * from libmann_freecate where code='$main' ",false);
	$parent2=tfa($parent2);

	//printr($parent);
	//printr($parent2);
	$parent2[name]=getlang($parent2[name]);

	html_dialog("Managing FREECATE"," <b>FREECATE</b>: <br>$parent2[code] -&gt; $parent2[name]");

}

$c[4][text]="Text";
$c[4][field]="name";
$c[4][fieldtype]="longtext";
$c[4][descr]="";
$c[4][defval]="";

$c[44][text]="div ID";
$c[44][field]="jsid";
$c[44][fieldtype]="text";
$c[44][descr]="optional";
$c[44][defval]="";


$c[6][text]="Nested::l::Nested";
$c[6][field]="nested";
$c[6][fieldtype]="foreign:-localdb-,library_modules,code,name";
$c[6][descr]="";
$c[6][defval]=$main;
if ($freecate=="yes") {
	$c[6][defval]="FREECATE-".$main;
	$c[6][fieldtype]="readonlytext";
}
$c[8][text]="Isshow::l::Isshow";
$c[8][field]="isshow";
$c[8][fieldtype]="list:yes,no";
$c[8][descr]="";
$c[8][defval]="yes";

$c[10][text]="Position";
$c[10][field]="position";
$c[10][fieldtype]="list:bottom,left,right,top";
$c[10][descr]="";
$c[10][defval]="bottom";


$c[9][text]="Ordr::l::Ordr";
$c[9][field]="ordr";
$c[9][fieldtype]="number";
$c[9][descr]="";
$c[9][defval]="99999";

$c[7][text]="ภาพ::l::Image";
$c[7][field]="imgfile";
$c[7][fieldtype]="singlefile";
$c[7][descr]="";
$c[7][defval]="";
//dsp




$dsp[4][text]="Text";
$dsp[4][filter]="module:localname";
$dsp[4][field]="name";
$dsp[4][width]="30%";
function localname($wh) {
	global $tbname;
	$img=fft_upload_get($tbname,"imgfile",$wh[id]);
	//printr($img);
	if ($img[status]!="ok") {
		$s="";
	} else {
		$s="<img src='$img[url]' align=left width=100>";
	}
	$wh[name]=trim($wh[name]);
	if ($wh[name]=="") {
		$wh[name]="<I>- no title -</I>";
	}
	return $s.$wh[name];
}

$dsp[6][text]="ordr";
$dsp[6][field]="ordr";
$dsp[6][width]="10%";

$dsp[7][text]="position";
$dsp[7][field]="position";
$dsp[7][width]="10%";

$dsp[8][text]="Isshow::l::Isshow";
$dsp[8][field]="isshow";
$dsp[8][width]="15%";

function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/menuicon/$wh[icon]' width=16 height=16> [$wh[ordr]]";
}
if ($freecate!="yes") {
	$o[addlink][] = "sub.php?main=$parent[nested]::back";
	$limit="$main";
} else {
	$o[addlink][] = "freecate.php::back";
	$limit="FREECATE-$main";
}
//echo $limit;
fixform_tablelister($tbname," nested='$limit' ",$dsp,"yes","yes","yes","main=$main&freecate=$freecate",$c,"ordr",$o);

foot();
?>