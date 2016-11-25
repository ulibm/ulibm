<?php 
include("../inc/config.inc.php");

$tbname="webpage_bookcomment";
//printr($selectlist);
$now=time();

$c[2][text]="Member id";
$c[2][field]="memid";
$c[2][fieldtype]="readonlytext";
$c[2][descr]="";
$c[2][defval]="";
/*
$c[11][text]="Librarian";
$c[11][field]="libid";
$c[11][fieldtype]="readonlytext";
$c[11][descr]="";
$c[11][defval]=$useradminid;

*/
$c[3][text]="Text";
$c[3][field]="body";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[9][text]="เปิดให้ใช้สืบค้น::l::Grant";
$c[9][field]="granted";
$c[9][fieldtype]="list:yes,no";
$c[9][descr]="";
$c[9][defval]="yes";

$c[10][text]="Date";
$c[10][field]="dt";
$c[10][fieldtype]="date";
$c[10][descr]="";
$c[10][defval]=time();;

$c[14][text]="Date";
$c[14][field]="bibid";
$c[14][fieldtype]="addcontrol";
$c[14][descr]="";
$c[14][defval]=$ID;

//dsp



$dsp[2][text]="ข้อความ::l::Text";
$dsp[2][field]="body";
$dsp[2][filter]="module:local_detail";
$dsp[2][width]="50%";

$dsp[3][text]="ทรัพยากรสารสนเทศ::l::Matedrials";
$dsp[3][field]="granted";
$dsp[3][width]="40%";
$dsp[3][filter]="module:local_mediaid";

$dsp[4][text]="อนุญาตแล้ว::l::Granted";
$dsp[4][field]="allowed";
$dsp[4][width]="11%";
$dsp[4][filter]="switchsingle";



function local_mediaid($wh) {

	return "<A HREF='../dublin.php?ID=$wh[bibid]' target=_blank>".marc_gettitle($wh[bibid])."</A>";
}

function local_detail($wh) {
	$s="$wh[body] <BR> <font class=smaller2>";
	$s.=getlang("เมื่อ::l::Date").":".ymd_datestr($wh[dt])."
	</font>";

	return $s;
}
?><TABLE width=780 align=center>
	<TR>
	<TD><?php 
fixform_tablelister($tbname," memid='$_memid' ",$dsp,"no","no","no","mempagemode=$mempagemode&submempagemode=$submempagemode",$c);
?></TD>
</TR>
</TABLE><BR>