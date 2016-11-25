<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

?>
<TABLE class=table_border width=100% align=center>
<FORM METHOD=POST ACTION="working.fine.searchuser.php">
<TR>
	<TD class=table_head><?php  echo getlang("กรุณากรอกข้อมูลบางส่วนของสมาชิกเพื่อทำการค้นหา::l::Please enter some information to search");?></TD>
	<TD class=table_td> <INPUT TYPE="text" NAME="memberbarcode" ID="memberbarcode" value="<?php  echo $memberbarcode?>">
	<?php 
	frm_genlist("membertype","select * from member_type order by descr","type","descr","-localdb-","yes",$membertype);
	?>
	<INPUT TYPE="submit" value=" OK "></TD>
</TR>
</FORM><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('memberbarcode').select();
//-->
</SCRIPT>
</TABLE>
<?php 
 //dsp


$dsp[1][text]="บาร์โค้ด::l::Barcode";
$dsp[1][field]="UserAdminID";
$dsp[1][width]="15%";

$dsp[9][text]="จัดการ::l::Manage";
$dsp[9][align]="center";
$dsp[9][field]="memberbarcode";
$dsp[9][filter]="module:letclickmanage";
$dsp[9][width]="10%";

$dsp[2][text]="สมาชิก::l::Member";
$dsp[2][field]="UserAdminID";
$dsp[2][filter]="memberbarcode";
$dsp[2][width]="25%";

$dsp[3][text]=$_ROOMWORD;
$dsp[3][field]="room";
$dsp[3][align]="center";
$dsp[3][filter]="module:localroom";
$dsp[3][width]="15%";

/*
$dsp[3][text]="Date::l::Date";
$dsp[3][field]="dt";
$dsp[3][filter]="date";
$dsp[3][width]="20%";
*/

$dsp[8][text]="สาขาห้องสมุด::l::Lib. Campus";
$dsp[8][field]="libsite";
$dsp[8][align]="center";
$dsp[8][filter]="module:locallibsite";
$dsp[8][width]="20%";


function locallibsite($wh) {
	return "<FONT class=smaller>".get_libsite_name($wh[libsite])."</FONT>";
}
function localroom($wh) {
	$sname=get_room_name($wh[room]);
	return "<FONT class=smaller>".getlang($sname)."</FONT>";
}
function letclickmanage($wh) {
	return "<B><A HREF='main.fine.php?memberbarcode=$wh[UserAdminID]&submitnow=yes' target=main>".getlang("จัดการ::l::Manage")."</A></B>";
}

$tbname="member";

$limit=" 1 ";
if ($memberbarcode!="") {
	$limit.=" and UserAdminID like '%$memberbarcode%' ";
	$limit.=" or UserAdminName like '%$memberbarcode%' ";
}
if ($membertype!="") {
	$limit.=" and type = '$membertype' ";
}

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","memberbarcode=$memberbarcode&membertype=$membertype",$c,"","");

?>