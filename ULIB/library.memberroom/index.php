<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
$tmp=mn_lib();
pagesection($tmp);

$tbname="room_cate";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";
$c[1][unediton]="code,default";

$c[2][text]="ชื่อกลุ่ม::l::Group name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="เรียงลำดับ::l::Order";
$c[3][field]="ordr";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";


//dsp

$dsp[5][text]="Order";
$dsp[5][field]="ordr";
$dsp[5][width]="4%";



$dsp[1][text]="รหัส::l::Code";
$dsp[1][field]="code";
$dsp[1][width]="20%";

$dsp[2][text]="ชื่อกลุ่ม::l::Group name";
$dsp[2][field]="name";
$dsp[2][filter]="module:localname";
$dsp[2][width]="30%";
function localname($wh) {
   return getlang($wh[name]);//." <font class=smaller>($wh[ordr])</font>";
}

$dsp[4][text]="จัดการ::l::Manage";
$dsp[4][field]="id";
$dsp[4][align]="center";
$dsp[4][filter]="module:local_man";
$dsp[4][width]="10%";

function local_man($w) {
   $res="";
   $res.="<a href='sub.php?pid=$w[code]'>".getlang("จัดการ::l::Manage")."</a>";
   if ($w[code]!="default") {
      $c=tmq("select id from room where pid='$w[code]' ");
      $res.="(".tnr($c).")";
   } else {
      $c=tmq("select id from room where pid='default' or pid not in (select code from room_cate) ");
      $res.="(".tnr($c).")";
   }
   return $res;
}

//$o[undelete][field]="code";
//$o[undelete][value]="onlineregist";
$o[undeletearr][code]="default";
//$o[unedit][field]="type";
//$o[unedit][value]="onlineregist";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," ordr ",$o);
?><center> <BR><BR> <?php
echo getlang("ตัวอย่าง::l::Example")." ";
form_room("test","");
?></center><?php
foot(); 
?>