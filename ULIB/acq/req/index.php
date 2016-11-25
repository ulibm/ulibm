<?php 
session_start();
include("../cfg.inc.php");
//include("./_REQPERM.php");
               
  
       html_start();        

	$permupload="no";


$tbname="acqn";


$c[1][text]="หัวข้อรายการ";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[12][text]="ข้อความเพิ่มเติม";
$c[12][field]="descr";
$c[12][fieldtype]="longtext";
$c[12][descr]="";
$c[12][defval]="";


$c[15][text]="แสดงให้ผู้ใช้เห็นหรือไม่";
$c[15][field]="showtovote";
$c[15][fieldtype]="list:yes,no";
$c[15][descr]=" ";
$c[15][defval]="";

//

$dsp[1][text]="ชื่อการเสนอราคาทรัพยากร";
$dsp[1][field]="title";
$dsp[1][filter]="module:localview";
$dsp[1][width]="60%";

if ($permupload=="yes") {
	$dsp[2][align]="center";
	$dsp[2][text]="จัดการรายการทรัพยากร";
	$dsp[2][field]="title";
	$dsp[2][filter]="module:local_dspsub";
	$dsp[2][width]="15%";
}

function localview($wh) {
	return "<A HREF='./vote.php?pid=$wh[id]'><B>".stripslashes($wh[name])."</B> <FONT class=smaller color=black>".stripslashes($wh[descr])."<BR>คลิกเพื่อเข้าไปเลือกรายการหนังสือที่จะแนะนำ</FONT></A> (".tnr(tmq("select id from acqn_sub where pid ='$wh[id]' ")).")";
}
function local_dspsub($wh) {
	return "<A HREF='./sub.php?pid=$wh[id]'>จัดการ</A>";
}

$limit=" 1 ";
if ($permupload!="yes") {
	$limit=" showtovote='yes' ";
}

fixform_tablelister($tbname," $limit ",$dsp,"$permupload","$permupload","$permupload","mi=$mi",$c,"id desc");

    
?>
<SCRIPT LANGUAGE="JavaScript" src="/counter2?Arec_acqn">
<!--
//-->
</SCRIPT>


<?php 
foot();
?>