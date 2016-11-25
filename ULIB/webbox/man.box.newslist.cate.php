<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
	 $_REQPERM="webbox";
	 mn_lib();
	 
pagesection(getlang("หัวข้อข่าว::l::News Category"));
?>
                <div align = "center">
<?php 


$tbname="webbox_newslist_cate";


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

//dsp


$dsp[2][text]="ชื่อหัวข้อ::l::Title";
$dsp[2][field]="name";
$dsp[2][width]="30%";
       
$dsp[4][text]="Description";
$dsp[4][field]="descr";
$dsp[4][align]="";
$dsp[4][width]="70%";


fixform_tablelister($tbname," 1  ",$dsp,"yes","yes","yes","pid=$pid&cate=$cate",$c," id desc ");


?><b><a href="man.box.newslist.php?pid=<?php  echo $pid?>"><center><?php  echo getlang("กลับ::l::Back");?></center></a></b><?php 


?>