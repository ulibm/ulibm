<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
	 $_REQPERM="webbox";
	 mn_lib();
	 $s=tmq("select * from webbox_customlist_cate where id='$cateid' ");
	 $s=tfa($s);
pagesection(getlang("หัวข้อย่อย::l::Sub Category").": ".$s[name]);
?>
                <div align = "center">
<?php 


$tbname="webbox_customlist_catesub";


$c[2][text]="ชื่อหัวข้อ::l::Title";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[4][text]="";
$c[4][field]="cateid";
$c[4][fieldtype]="addcontrol";
$c[4][descr]="";
$c[4][defval]=$cateid;

//dsp


$dsp[2][text]="ชื่อหัวข้อ::l::Title";
$dsp[2][field]="name";
$dsp[2][width]="30%";
       

       


fixform_tablelister($tbname," cateid='$cateid'  ",$dsp,"yes","yes","yes","pid=$pid&cate=$cate&cateid=$cateid",$c," id desc ");


?><b><a href="man.box.customlist.cate.php?pid=<?php  echo $cateid?>"><center><?php  echo getlang("กลับ::l::Back");?></center></a></b><?php 


?>