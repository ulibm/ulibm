<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
$tmp=mn_lib();
pagesection($tmp);

$tbname="reminderscalendar";


$c[1][text]="ชื่อการเตือน::l::Reminder's name";
$c[1][field]="title";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="ข้อความเพิ่มเติม::l::Description";
$c[2][field]="descr";
$c[2][fieldtype]="longtext";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="วันเดือนปีที่ให้เตือน::l::Date";
$c[3][field]="dt";
$c[3][fieldtype]="date";
$c[3][descr]="";
$c[3][defval]=time()+(60*60*34*7);

$c[4][text]="เตือนทุกคน::l::Alert all";
$c[4][field]="isglobal";
$c[4][fieldtype]="yesno";
$c[4][descr]=getlang("เตือนทุกคนหรือเตือนเฉพาะตนเอง::l::Alarm all librarian or just yourself");
$c[4][defval]="no";

$c[5][text]="";
$c[5][field]="loginid";
$c[5][fieldtype]="autoofficer";
$c[5][descr]="";
$c[5][defval]=$useradminid;

//dsp


$dsp[1][text]="ชื่อการเตือน::l::Reminder's name";
$dsp[1][field]="title";
$dsp[1][width]="20%";

$dsp[2][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[2][field]="descr";
$dsp[2][filter]="module:localdesc";
$dsp[2][width]="40%";
function localdesc($w) {
   $r=stripslashes($w[descr]);
   if (trim($r)!="") {
      $r.="<br>";
   }
   $r.=getlang("โดย::l::by")." ".get_library_name($w[loginid]);
   return $r;
}


$dsp[3][text]="วันเดือนปี::l::Date";
$dsp[3][field]="dt";
$dsp[3][filter]="date";
$dsp[3][width]="30%";

$dsp[5][text]="เตือนทุกคน::l::alert all member";
$dsp[5][field]="isglobal";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="10%";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>