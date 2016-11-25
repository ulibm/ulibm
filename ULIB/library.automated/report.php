<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
		include("./sv/conf.php");
//printr($jobsdb);       // mn_lib();
	//pagesection(getlang("ดึงข้อมูลผู้ใช้::l::Re generate data"));
$_TBWIDTH="100%";
$tbname="automatedsv_log";


//dsp




$dsp[2][text]="Activity";
$dsp[2][field]="id";
$dsp[2][filter]="module:localjob";
$dsp[2][width]="20%";
function localjob($wh) {
	global $jobsdb;
	//printr($wh);
	//printr($jobsdb);
	return $jobsdb[$wh[job]][name]."<br>&nbsp;&nbsp;<font class=smaller>".ymd_datestr($wh[dt])."</font> <font class=smaller2>(".ymd_ago($wh[dt]).")</font>";
}

$dsp[3][text]="Result";
$dsp[3][field]="id";
$dsp[3][filter]="module:localinfo";
$dsp[3][width]="20%";
function localinfo($wh) {
	global $jobsdb;
	if ($wh[result]=="200") {
		$wh[result]="<b style='color: darkgreen;'>".$wh[result]."</b>";
	}
	$s="Status : $wh[result] <div ID='btn$wh[id]' style='display:inline'><a href='javascript:void(null);' onclick=\"tmp=getobj('btn$wh[id]'); tmp.style.display='none';tmp=getobj('det$wh[id]'); tmp.style.display='block';\" class=smaller2>".getlang("แสดง::l::Show")."</a></div>
	<div ID='det$wh[id]' style='display:none' onclick=\"this.style.display='none';tmp=getobj('btn$wh[id]'); tmp.style.display='inline'\">".stripslashes($wh[result_full])."</div>";
	//$wh[result_full]
	return $s;
}



fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c," "."dt desc",$o);
?>