<?php 
;
include("../inc/config.inc.php");
head();
	include("_REQPERM.php");
	mn_lib();
pagesection("ตัวเลือกบัตรรายการ::l::Catalogue Card options");

$tbname="catcard";

$c[1][text]="ชื่อ::l::Name";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="บัตร";

$c[2][text]="loginid";
$c[2][field]="loginid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$useradminid;

$c[3][text]="โครงสร้างบัตรรายการ::l::Catalogue Card Structure";
$c[3][field]="data";
$c[3][fieldtype]="longtext";
$c[3][descr]="<br>".getlang("ตัวอย่าง ใช้ \$data[tag100] แทนข้อมูลในแท็ก 100::l::Example: use \$data[tag100] for data in tag100");
$c[3][defval]="";

$c[4][text]="ความกว้าง::l::Catalogue Card Width";
$c[4][field]="w";
$c[4][fieldtype]="number";
$c[4][descr]=getlang("มิลลิเมตร::l::Millimetre");
$c[4][defval]="127";

$c[5][text]="ความสูง::l::Catalogue Card Height";
$c[5][field]="h";
$c[5][fieldtype]="number";
$c[5][descr]=getlang("มิลลิเมตร::l::Millimetre");
$c[5][defval]="76.2";

//dsp
$dsp[1][text]="ชื่อบัตรรายการ::l::Catalogue Card Name";
$dsp[1][field]="name";
$dsp[1][width]="70%";

$dsp[2][text]="พิมพ์::l::Print";
$dsp[2][field]="ID";
$dsp[2][align]="center";
$dsp[2][filter]="module:localprint";
$dsp[2][width]="30%";

function localprint($wh) {
	return "<a href='catcard.print.php?id=$wh[id]' target=_blank class=a_btn>".getlang("พิมพ์::l::Print")."</a>";
}

//echo "[$delable]";
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);
?><center><br>
	<a href="media_type.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a></center><?php 
foot();
?>