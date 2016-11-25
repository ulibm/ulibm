<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="marcdspmod";
mn_lib();
$tbname="marcdspmod_modrule";

$c[2][text]="Nested::l::Nested";
$c[2][field]="pid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$main;


$c[4][text]="แท็ก::l::TAG";
$c[4][field]="tagid";
$c[4][fieldtype]="foreign:-localdb-,bkedit,fid,name,,,displaykey,leader=LEADER";
$c[4][fieldtype]="foreign:-localdb-,bkedit,fid,name,,,displaykeyfirst,leader=LEADER";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="รูปแบบการเปลี่ยน::l::Modification type";
$c[5][field]="decis";
$c[5][fieldtype]="list:set subfield,remove subfield,set tag,remove tag,replace string";
$c[5][descr]="";
$c[5][defval]="";

$c[8][text]="Subfield::l::Subfield";
$c[8][field]="subfield";
$c[8][fieldtype]="text";
$c[8][descr]="a, b, c, d .......";
$c[8][defval]="";

$c[6][text]="ข้อความ 1::l::value";
$c[6][field]="val1";
$c[6][fieldtype]="longtext";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="ข้อความ 2::l::value 2";
$c[7][field]="val2";
$c[7][fieldtype]="longtext";
$c[7][descr]="";
$c[7][defval]="";

$c[77][text]="เรียงลำดับ::l::order #";
$c[77][field]="ordr";
$c[77][fieldtype]="number";
$c[77][descr]="";
$c[77][defval]="";


//dsp

$dsp[4][text]="แท็ก::l::TAG";
$dsp[4][field]="tagid";
$dsp[4][filter]="foreign:-localdb-,bkedit,fid,name,,,leader=LEADER";
$dsp[4][width]="20%";

$dsp[5][text]="รูปแบบ::l::Type";
$dsp[5][field]="decis";
$dsp[5][width]="15%";

$dsp[7][text]="Subfield";
$dsp[7][field]="subfield";
$dsp[7][width]="15%";

$dsp[6][text]="ข้อความ 1::l::value 1";
$dsp[6][field]="val1";
$dsp[6][width]="20%";

$dsp[8][text]="ข้อความ 2::l::value 2";
$dsp[8][field]="val2";
$dsp[8][width]="20%";

$o[addlink][] = "index.php::".getlang("กลับ::l::Back");;
?><BR><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td><B><?php  echo getlang("กฏของการปรับเปลี่ยน:::l::Rule for:");
	$s=tmq("select * from marcdspmod_main where id='$main' ");
	$s=tmq_fetch_array($s);
	?></B> <?php 
	echo $s[name];
	?></TD>
</TR>
</TABLE><BR><?php 
html_libmann("marcdspmod_modrule","yes");
fixform_tablelister($tbname," pid='$main' ",$dsp,"yes","yes","yes","main=$main",$c," ordr ",$o);

foot();
?>