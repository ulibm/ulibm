<?php 
include("../inc/config.inc.php");
html_start();

$tbname="keyhelp_callngenner";

if ($actioncalln!="") {
	tmq("update $tbname set lastuse='no' where 1 ");
	tmq("update $tbname set lastuse='yes',current=current+1 where id='$actioncalln' ");

	$s=tmq("select * from $tbname where id='$actioncalln' ");
	$s=tmq_fetch_array($s);
	$next=floor($s[current]);
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
			parent.getobj('<?php  echo $parentjsid ?>').value=parent.getobj('<?php  echo $parentjsid ?>').value+'^a<?php  echo trim($s[prefix]) ." ".$next?>';
			parent.showhidesuggestme_justhide();
		//-->
		</SCRIPT><?php 
	die;
}


$c[2][text]="ชื่อชุด::l::Set Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ตัวอักษรนำหน้า::l::Prefix";
$c[3][field]="prefix";
$c[3][fieldtype]="text";
$c[3][descr]="<BR>".getlang("เช่น vcd, dvd,df::l::Ex: vcd, dvd, df");
$c[3][defval]="";

$c[4][text]="Running ปัจจุบัน::l::Current Running";
$c[4][field]="current";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="0";

/*
$c[5][text]="Lastuse::l::Lastuse";
$c[5][field]="lastuse";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="no";
*/

//dsp


$dsp[2][text]="ชื่อชุด::l::Set Name";
$dsp[2][field]="name";
$dsp[2][width]="60%";

$dsp[3][text]="คลิกใช้::l::Click use";
$dsp[3][field]="prefix";
$dsp[3][align]="center";
$dsp[3][filter]="module:localclickuse";
$dsp[3][width]="40%";

$o[tablewidth]="100%";

function localclickuse($wh) {
	global $parentjsid;
	$next=floor($wh[current])+1;
	$wh[prefix]=trim($wh[prefix]);
	$r=" <A style='font-size: 24px' HREF='callngenner.php?actioncalln=$wh[id]&parentjsid=$parentjsid'>$wh[prefix] $next</A> ";
	

	return $r;
}
$managecallngennerval="no";
$managecallngenner=library_gotpermission("managecallngenner");
if ($managecallngenner==true) {
   $managecallngennerval="yes";
}
fixform_tablelister($tbname," 1 ",$dsp,"$managecallngennerval","$managecallngennerval","$managecallngennerval","parentjsid=$parentjsid&tagid=$tagid",$c,"lastuse desc",$o);

?>