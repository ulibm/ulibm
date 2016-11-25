<?php 
include("../inc/config.inc.php");
html_start();

include("_REQPERM.php");
$tmp=mn_lib();

pagesection("Template: ".getlang($pid));

$tbname="memcard";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="เรียงลำดับ::l::Order";
$c[3][field]="ordr";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ความกว้าง::l::Width";
$c[4][field]="w";
$c[4][fieldtype]="number";
//$c[4][descr]=getlang("มิลลิเมตร::l::Millimetre");
$c[4][defval]="";

$c[5][text]="ความสูง::l::Height";
$c[5][field]="h";
$c[5][fieldtype]="number";
//$c[5][descr]=getlang("มิลลิเมตร::l::Millimetre");
$c[5][defval]="";
/*
$c[6][text]="-";
$c[6][field]="pid";
$c[6][fieldtype]="addcontrol";
$c[6][descr]="";
$c[6][defval]=$pid;*/
/*
$c[7][text]="จำนวนก๊อปปี้::l::Copy";
$c[7][field]="copyno";
$c[7][fieldtype]="number";
$c[7][descr]="";
$c[7][defval]="1";*/

//dsp


//$dsp[1][text]="รหัส::l::Code";
//$dsp[1][field]="code";
//$dsp[1][width]="20%";

$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";


$dsp[4][text]="จัดการ::l::Manage";
$dsp[4][align]="center";
$dsp[4][field]="name";
$dsp[4][filter]="module:local_man";
$dsp[4][width]="20%";
function local_man($wh) {
	$s= "<a href=\"man.php?pid=$wh[code]\"><font >".getlang("จัดการ::l::Manage")." </font>
   <a href=\"mantp.php?dupid=$wh[code]\"><font >".getlang("ทำสำเนา::l::Duplicate")." </font></a>";
	return $s;
}
/*
$dsp[5][text]="จัดการส่วนท้ายกระดาษ::l::Manage Footer";
$dsp[5][align]="center";
$dsp[5][field]="name";
$dsp[5][filter]="module:local_manfoot";
$dsp[5][width]="20%";
function local_manfoot($wh) {
	$s= "<a href=\"man.php?pid=FOOT::$wh[code]\"><font >".getlang("จัดการส่วนท้ายกระดาษ::l::Manage Footer")." </font></a>";
	return $s;
}*/

/*
$dsp[5][text]="ยังใช้งาน::l::is active?";
$dsp[5][field]="isactive";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="10%";
*/

if ($dupid!="") {
   $s=tmq("select * from memcard where code='$dupid' ");
   if (tnr($s)==0) die("error");
   $s=tfa($s);
   $newid=randid();
   $s=tmq("insert into memcard set 
   code='".$newid."',
   name='Duplicated from ".addslashes($s[name])."',
   w='$s[w]',
   h='$s[h]'
   ");
   $si=tmq("select * from memcard_sub_i where pid='$dupid' ");
   while ($sir=tfa($si)) {
      tmq("insert into memcard_sub_i set pid='$newid' ,
      ordr='".addslashes($sir[ordr])."',
      type1='".addslashes($sir[type1])."',
      pos='".addslashes($sir[pos])."',
      data='".addslashes($sir[data])."',
      string_fontsize='".addslashes($sir[string_fontsize])."',
      varid='".addslashes($sir[varid])."',
      font='".addslashes($sir[font])."',
      fontisbold='".addslashes($sir[fontisbold])."'
      ");
   }
}

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","pid=$pid",$c," ordr ",$o);
?><center><a href=index.php>Back</a><?php
foot(); 
?>