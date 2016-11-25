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


$tbname="webbox_customlist_cate";


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
       
$dsp[3][text]="หัวข้อย่อย::l::Sub Categories";
$dsp[3][field]="id";
$dsp[3][align]="center";
$dsp[3][filter]="module:localsubcate";
$dsp[3][width]="30%";

function localsubcate($wh) {
   global $cate;
   global $pid;
   $c=tmq("select * from webbox_customlist_catesub where cateid='$wh[id]'");
   $c=tnr($c);
   return "<a href='man.box.customlist.catesub.php?pid=$pid&cate=$cate&cateid=$wh[id]'>".getlang("หัวข้อย่อย::l::Sub categories")." ($c)</a>";
}
       
$dsp[4][text]="Description";
$dsp[4][field]="descr";
$dsp[4][align]="";
$dsp[4][width]="70%";


fixform_tablelister($tbname," 1  ",$dsp,"yes","yes","yes","pid=$pid&cate=$cate",$c," id desc ");


?><b><a href="man.box.customlist.php?pid=<?php  echo $pid?>"><center><?php  echo getlang("กลับ::l::Back");?></center></a></b><?php 


?>