<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
	 $_REQPERM="webbox";
	 mn_lib();
pagesection(getlang("แก้ไขรูปแบบตัวแบ่ง::l::Edit seperator styles"));
?>
                <div align = "center">
<?php 

$tbname="webbox_sepper_type";


$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Code*";
$c[3][field]="code";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="โค้ด HTML::l::HTML";
$c[4][field]="tp";
$c[4][fieldtype]="longtext";
$c[4][descr]="<BR>%dcr = URL<BR>%col1 = Color 1<BR>%col2 = Color 2<BR>%w = width<BR>%str = main text<BR>%descr = Description";
$c[4][defval]="";


//dsp

$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="80%";
fixform_tablelister($tbname," 1  ",$dsp,"yes","yes","yes","pid=$pid&cate=$cate",$c," id desc ");



?>