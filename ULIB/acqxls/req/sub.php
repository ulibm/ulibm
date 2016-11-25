<?php 
session_start();
include("../inc/config.inc.php");
include("./_REQPERM.php");
               
     head();   

if (library_gotpermission("suggestbookbylist")) {
	$permupload="yes";
} else {
	$permupload="no";
}


$tbname="suggestbookbylist_sub";


$c[1][text]="รายละเอียดทรัพยากร";
$c[1][field]="text";
$c[1][fieldtype]="longtext";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="-";
$c[2][field]="pid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$pid;


//

$dsp[1][text]="รายละเอียดทรัพยากร";
$dsp[1][field]="text";
$dsp[1][filter]="module:local_dsp";
$dsp[1][width]="60%";
if ($permupload=="yes") {
	$o[addlink][] = "addlong.php?pid=$pid::<B>เพิ่มทีละหลายรายการ</B>::_self";
}
$o[addlink][] = "index.php::กลับ::_self";

function local_dsp($wh) {
	$sayyes=tmq_num_rows(tmq("select id from suggestbookbylist_voted where data like '%,on-$wh[id],%' "));
	$sayno=tmq_num_rows(tmq("select id from suggestbookbylist_voted where data like '%,off-$wh[id],%' "));
	$s="<div style='width: 100%'>
<div style='width: 50;float:left; text-align:center; color: darkgreen;font-size:16;font-weight: bolder;'>".number_format($sayyes)."</div>
<div style='width: 50;float:left; text-align:center; color: darkred; font-size:16;font-weight: bolder; margin-right: 15; border: 0 black dotted; border-right-width:2; padding-right: 3'>".number_format($sayno)."</div>
".stripslashes($wh[text])."
</div>";

	return $s;
}

fixform_tablelister($tbname," pid='$pid' ",$dsp,"$permupload","$permupload","$permupload","pid=$pid",$c,"id",$o);

    
?>
<SCRIPT LANGUAGE="JavaScript" src="/counter2?Arec_suggestbookbylist">
<!--
//-->
</SCRIPT>


<?php 
foot();
?>