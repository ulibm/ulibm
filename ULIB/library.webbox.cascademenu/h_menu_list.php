<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
pagesection(getlang("จัดการรายการ::l::Manage List"));
?>
                <div align = "center">
<?php 


$tbname="webbox_topmenu_list";


$c[2][text]="ชื่อหัวข้อ::l::Title";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="การแสดงผล::l::Display Type";
$c[4][field]="dsptype";
$c[4][fieldtype]="list:list,box,thumbnail_list";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="สีตัวอักษร::l::Font Color";
$c[5][field]="fgcol";
$c[5][fieldtype]="color";
$c[5][descr]="";
$c[5][defval]="";

$c[55][text]="สีพื้นหลัง::l::Background Color";
$c[55][field]="bgcol";
$c[55][fieldtype]="color";
$c[55][descr]="";
$c[55][defval]="";

$c[6][text]="เรียงลำดับ::l::Order";
$c[6][field]="ordr";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="";
$c[7][field]="pid";
$c[7][fieldtype]="addcontrol";
$c[7][descr]="";
$c[7][defval]=$pid;

//dsp


$dsp[2][text]="ชื่อหัวข้อ::l::Title";
$dsp[2][field]="name";
$dsp[2][width]="20%";
       
$dsp[4][text]="Description";
$dsp[4][field]="descr";
$dsp[4][align]="";
$dsp[4][width]="30%";

$dsp[3][text]="รายการย่อย::l::List";
$dsp[3][field]="name";
$dsp[3][filter]="module:localman";
$dsp[3][width]="20%";
function localman($w) {
   global $pid;
   $cc=tmq("select * from webbox_topmenu_list_sub where pid='$w[id]' ");
   $cc=tnr($cc);
   return "<a href='h_menu_list_sub.php?pid=$w[id]&parentpid=$w[pid]'>".getlang("จัดการ::l::Manage")." ($cc)</a>";
}

fixform_tablelister($tbname," pid='$pid'  ",$dsp,"yes","yes","yes","pid=$pid",$c," ordr ");


?><b><a href="h_menu.php"><center><?php  echo getlang("กลับ::l::Back");?></center></a></b><?php 


?>