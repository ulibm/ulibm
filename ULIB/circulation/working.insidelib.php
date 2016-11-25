<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

 //dsp


 //tab display
 $tmp=Array();
$tmp[checkout]="1";
$tmp[checkin]="2";
$tmp[all]="3";
$now=time();
if ($memberbarcode=="") {
	die("not spec. memberbarcode");
}

if ($tabmode=="") {
	$tabmode="all";
}
if ($tabmode=="checkin" && $bcode!="") {
	tmq("delete from useinsidelib where bcode='$bcode' ");
}
if ($tabmode=="checkout" && $bcode!="") {
	$chk=tmq("select * from useinsidelib where bcode='$bcode'  ");
	if (tmq_num_rows($chk)!=0) {
		localdisplayerror(getlang("ขออภัย ไอเทมนี้ ถูกบันทึกว่าถูกยืมใช้ในห้องสมุดไปแล้ว::l::Sorry, this item already checked-out for use inside library."));
	} else {
		$chk=tmq("select * from media_mid where bcode='$bcode'  ");
		if (tmq_num_rows($chk)==0) {
			localdisplayerror(getlang("ขออภัย ไม่พบวัสดุบาร์โค้ดดังกล่าว::l::Sorry, not found barcode."));
		} else {
			tmq("insert into useinsidelib set
			memid='$memberbarcode',
			loginid='$useradminid',
			dt='$now',
			bcode='$bcode'
			");
			$chk=tmq_fetch_array($chk);
			$tmptitle=marc_gettitle($chk[pid]);
			localdisplayerror(getlang("ทำการยืม:$tmptitle::l::Checkout:$tmptitle"),"#236ABA");
			stathist_add("insidelib_member",$memberbarcode,$bcode);	
			stathist_add("insidelib_mid",$bcode,$memberbarcode);	
			stathist_add("insidelib_restype",$bcode,$chk[RESOURCE_TYPE]);	
		}
	}
}

$count=tmq("select * from useinsidelib where memid='$memberbarcode' ");
$count="(".tmq_num_rows($count).")";
$tabstr=$tmp[$tabmode]."::r";
$tabstr.="::".getlang("ยืมออก::l::Checkout")." $count,working.insidelib.php?memberbarcode=$memberbarcode&tabmode=checkout";
$tabstr.="::".getlang("ส่งคืน::l::Checkin").",working.insidelib.php?memberbarcode=$memberbarcode&tabmode=checkin";
$_TBWIDTH="100%";

$tabstr.="::".getlang("ดูทั้งหมด::l::View all").",working.insidelib.php?memberbarcode=$memberbarcode&tabmode=all";

html_xptab($tabstr);
if ($returnbc!="") {
	localloadmember($memberbarcode,"yes");
}
if ($tabmode=="checkout" || $tabmode=="checkin") {
	?><TABLE width=100% cellpadding=0 cellspacing=0>
<FORM METHOD=POST ACTION="working.insidelib.php">
<INPUT TYPE="hidden" NAME="tabmode" value="<?php  echo $tabmode?>">
<INPUT TYPE="hidden" NAME="memberbarcode" value="<?php  echo $memberbarcode?>">
			<TR>
		<TD><?php  echo getlang("กรุณาสแกนบาร์โค้ดที่นี่::l::Please scan barcode here.");?> 
		<INPUT TYPE="text" NAME="bcode" ID="bcode" style=" background-image:url(book-icon.png); background-repeat: no-repeat; padding-left: 22px;" value="<?php  echo $returnbc;?>" autocomplete=off> <INPUT TYPE="submit" value=" OK "></TD>
	</TR>
	</FORM>
<SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('bcode').select();
//-->
</SCRIPT>

	</TABLE><?php 
}


$dsp[1][text]="ทรัพยากร::l::Material";
$dsp[1][field]="id";
$dsp[1][filter]="module:local_mat";
$dsp[1][width]="40%";

$dsp[9][text]="รายละเอียด::l::Details";
$dsp[9][field]="id";
$dsp[9][filter]="module:local_detail";
$dsp[9][width]="20%";


/*
$dsp[3][text]="Date::l::Date";
$dsp[3][field]="dt";
$dsp[3][filter]="date";
$dsp[3][width]="20%";
*/

$dsp[2][text]="สมาชิก::l::Member";
$dsp[2][field]="memid";
$dsp[2][filter]="memberbarcode";
$dsp[2][width]="25%";
$dsp[2][align]="center";

function local_detail($wh) {
	global $memberbarcode;
	global $tabmode;
	return "<FONT class=smaller>Barcode=<A class=smaller style='color: red;' HREF='working.insidelib.php?memberbarcode=$wh[memid]&tabmode=checkin&returnbc=$wh[bcode]'>$wh[bcode]</A><BR>".ymd_datestr($wh[dt])."<BR>".ymd_ago($wh[dt])."<BR>".getlang("โดย ::l::By ").get_library_name($wh[loginid])."</FONT>";
}
function local_mat($wh) {
	$chk=tmq("select * from media_mid where bcode='$wh[bcode]'  ");
	$chk=tmq_fetch_array($chk);
	//printr($wh);
	$s.= res_brief_dsp($chk[pid],true,true,false);;
	return $s;
}

$tbname="useinsidelib";
$limit=" 1 ";

if ($tabmode!="all") {
	$limit=" memid='$memberbarcode' ";
}


fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","memberbarcode=$memberbarcode&tabmode=$tabmode",$c," dt desc ","");

?>