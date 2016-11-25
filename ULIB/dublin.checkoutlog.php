<?php 
include("./inc/config.inc.php");
head();
$_REQPERM="mainmenu";
mn_lib();
//printr($selectlist);
$now=time();
echo "<center>";
?><BR><TABLE width=500 align=center>
<TR>
	<TD><?php 
			res_brief_dsp($ID);
?></TD>
</TR>
</TABLE><?php 
echo "</center>";


//dsp


$tbname="media_mid";

$dsp[2][text]="-";
$dsp[2][field]="memid";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_detail";
/*
$dsp[3][text]="อนุญาต::l::Granted";
$dsp[3][field]="granted";
$dsp[3][width]="2%";
$dsp[3][filter]="switchsingle";


*/

function local_detail($wh) {
	//printr($wh);
	$s="Barcode=$wh[bcode]
	 (".get_media_type($wh[RESOURCE_TYPE]).")<BR>
	 <B>".getlang("เก็บไว้ที่::l::Shelf") ."</B>:".get_itemplace_name($wh[place])."
	 <B>".getlang("เป็นของห้องสมุด::l::campus") ."</B>:".get_libsite_name($wh[libsite])."<FONT class=smaller> 
	<I>$wh[adminnote]</I><BR>";
	$sc=tmq("select * from stathist_checkout_member_media  where foot='$wh[bcode]' order by dt  ");
	if (tmq_num_rows($sc)==0) {
		$s.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -".getlang("ไม่มีข้อมูลการถูกยืมออก::l::No check out history")." -<BR>";
	}
	while ($scr=tmq_fetch_array($sc)) {
		$s.=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".getlang("ถูกยืมโดย::l::Checked out by ")."::".get_member_name($scr[head])." ($scr[head]) " .getlang("เมื่อ::l::Since")." ".ymd_datestr($scr[dt])." ".ymd_ago($scr[dt])."<BR>";
	}
	$s.="</FONT>";

	return $s;
}

fixform_tablelister($tbname," pid='$ID' ",$dsp,"no","no","no","ID=$ID",$c);

index_reindex($ID);
foot();
?>