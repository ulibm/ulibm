<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("libmann");

$tbname="libmann_freecate";


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

//dsp




$dsp[3][text]="Code::l::Code";
$dsp[3][field]="code";
$dsp[3][width]="15%";

$dsp[4][text]="Name::l::Name";
$dsp[4][field]="name";
$dsp[4][width]="30%";

$dsp[7][text]="Edit::l::Edit";
$dsp[7][field]="name";
$dsp[7][align]="center";
$dsp[7][filter]="module:locallink";
$dsp[7][width]="15%";
function locallink($wh) {
	$c=tmq("select * from libmann where nested='FREECATE-$wh[code]' ");
	$c=number_format(tnr($c));
	return "<a href='submann.php?freecate=yes&main=$wh[code]'>Edit ($c)</a>";
}


$o[addlink][] = "index.php::back";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","main=$main",$c,"id desc",$o);

foot();
?>