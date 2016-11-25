<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

pagesection("จัดการผู้ลงชื่อเข้าร่วมอบรม");
$tbname="eventsreg_reg";

for ($i=1; $i<=10; $i++) {
   $source=tmq("select * from eventsreg_memfid where pid=$pid and code=$i");
   $sr=tfa($source);
   if (strtolower($sr[isshow])=="yes") {
      $c[100+$i][text]=$sr[txt];
      $c[100+$i][field]="fid$i";
      $c[100+$i][fieldtype]="text"; 
      $c[100+$i][fieldtype]=$sr[type1];
      $c[100+$i][descr]=" ";
      $c[100+$i][defval]="";
   }
}

$c[10][text]="การเข้าร่วมกิจกรรม";
$c[10][field]="subdata";
$c[10][fieldtype]="special_eventsreg_regdata";
$c[10][special]=$pid;
$c[10][descr]="";
$c[10][defval]="";

$c[11][text]="เพิ่มเติม";
$c[11][field]="reqdata";
$c[11][fieldtype]="special_eventsreg_reqdata";
$c[11][special]=$pid;
$c[11][descr]="";
$c[11][defval]="";



$c[9][text]="";
$c[9][field]="pid";
$c[9][fieldtype]="addcontrol";
$c[9][descr]="";
$c[9][defval]=$pid;



$c[50][text]="อนุญาต";
$c[50][field]="isallowed";
$c[50][fieldtype]="yesno";
$c[50][descr]="";
$c[50][defval]="";


//dsp

$dsp[5][text]="วันเดือนปี::l::Date";
$dsp[5][field]="dt";
$dsp[5][filter]="datetime";
$dsp[5][width]="5%";

$dsp[2][text]="รายละเอียด::l::Registration Detail";
$dsp[2][field]="name";
$dsp[2][filter]="module:localdet";
$dsp[2][width]="30%";

$dsp[3][text]="การเข้าร่วม::l::Request and particapation";
$dsp[3][field]="name";
$dsp[3][filter]="module:localpart";
$dsp[3][width]="30%";


$dsp[4][text]="Allow?";
$dsp[4][field]="isallowed";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="5%";

function localdet($w) {
   $s="";
   $dd=tmq("select * from eventsreg_memfid where pid='$w[pid]' and lower(isshow)='yes' order by code",false);
   while ($ddr=tfa($dd)) { //printr($ddr);
      $s.=" $ddr[txt] : ".$w["fid".$ddr[code]]."<BR>";
   }
   $s.="";
   
   return $s;
}
function localpart($w) {
   //printr($w);
   $chksub=tmq("select * from eventsreg_sub where pid='$w[pid]' ");
   if (tnr($chksub)!=0) {
      $subdata=explode(",",$w[subdata]);
      $subdata=arr_filter_remnull($subdata);
      $subdata=implode(",",$subdata);
      $s="<b>เข้าร่วม </b><BR>";
      $dd=tmq("select * from eventsreg_sub where pid='$w[pid]' and id in ($subdata) order by ordr",false);
      while ($ddr=tfa($dd)) { //printr($ddr);
         $s.=" $ddr[name],";
      }
      $s=rtrim($s,",");
   }
   //req
   $chksub=tmq("select * from eventsreg_requests where pid='$w[pid]' ");
   if (tnr($chksub)!=0) {
      $reqdata=explode(",",$w[reqdata]);
      $reqdata=arr_filter_remnull($reqdata);
      $reqdata=implode(",",$reqdata);
      $s.="<BR><b>อื่น ๆ </b><BR>";
      $dd=tmq("select * from eventsreg_requests_sub where id in ($reqdata) order by ordr",false);
      while ($ddr=tfa($dd)) { //printr($ddr);
         $ddp=tmq("select * from eventsreg_requests where id='$ddr[pid]' ");
         $ddpr=tfa($ddp);
         $s.=" $ddpr[name]=$ddr[name]<BR>";
      }
      $s=rtrim($s,",");
      $s.="";
   }
   return $s;
}
/*
$dsp[3][text]="กิจกรรมย่อย";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_sub";
$dsp[3][width]="30%";

function local_sub($wh) {
	$s=tmq("select * from areceventjournal_sub where pid='$wh[id]' ");
	$res= "<CENTER><A HREF='edit_event_sub.php?pid=$wh[id]'>กิจกรรมย่อย ".tmq_num_rows($s)."</A></CENTER>";
	return $res;
}
*/
fixform_tablelister($tbname," pid=$pid  ",$dsp,"no","yes","yes","pid=$pid",$c," dt desc ");
?><A HREF="index.php"><CENTER>กลับ</CENTER></A><?php

foot();
?>