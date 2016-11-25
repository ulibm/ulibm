<?php 
include("../inc/config.inc.php");
head();
	include("_REQPERM.php");
mn_lib();
$tbname="authoritydb_rule";


$c[2][text]="Nested::l::Nested";
$c[2][field]="fid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$fid;


$c[3][text]="โยงกับมาร์คแท็ก::l::Work on MARC tag";
$c[3][field]="workonmarctag";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[20][text]="แท็กที่เป็นแหล่งข้อมูล::l::Source inf. tag";
$c[20][field]="pullfromtag";
$c[20][fieldtype]="text";
$c[20][descr]="";
$c[20][defval]="";


$c[4][text]="รูปแบบการโยง::l::Relation mode";
$c[4][field]="checkmode";
$c[4][fieldtype]="list:SEE FROM TRACING,SEE ALSO FROM TRACING,ESTABLISHED HEADING LINKING,SUBDIVISION LINKING,COMPLEX LINKING";
$c[4][descr]="";
$c[4][defval]="";

//dsp


$dsp[3][text]="โยงกับมาร์คแท็ก::l::Work on MARC tag";
$dsp[3][field]="workonmarctag";
$dsp[3][width]="30%";

$dsp[4][text]="แท็กที่เป็นแหล่งข้อมูล::l::Source inf. tag";
$dsp[4][field]="pullfromtag";
$dsp[4][width]="30%";

$dsp[5][text]="รูปแบบการโยง::l::Relation mode";
$dsp[5][field]="checkmode";
$dsp[5][width]="30%";

$o[addlink][] = "index.php::".getlang("กลับ::l::Back");;


fixform_tablelister($tbname," fid='$fid' ",$dsp,"yes","yes","yes","fid=$fid",$c,"",$o);

foot();
?>