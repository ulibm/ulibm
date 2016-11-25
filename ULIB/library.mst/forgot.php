<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("_REQPERM.php");
	 loginchk_lib();

?>
<TABLE class=table_border width=100% align=center>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF; ?>">
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

$dsp[9][text]="พิมพ์::l::Print";
$dsp[9][align]="center";
$dsp[9][field]="memberbarcode";
$dsp[9][filter]="module:localmem";
$dsp[9][width]="10%";

$dsp[19][text]="แก้ไขและพิมพ์::l::Edit and Print";
$dsp[19][align]="center";
$dsp[19][field]="memberbarcode";
$dsp[19][filter]="module:localmemedit";
$dsp[19][width]="15%";

$dsp[2][text]="สมาชิก::l::Member";
$dsp[2][field]="UserAdminID";
$dsp[2][filter]="memberbarcode";
$dsp[2][width]="25%";

$dsp[3][text]=$_ROOMWORD;
$dsp[3][field]="room";
$dsp[3][align]="center";
$dsp[3][filter]="module:localroom";
$dsp[3][width]="20%";

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
	$s=tmq("select * from room where id='$wh[room]' ");
	if (tmq_num_rows($s)==0) {
		return "-";
	}
	return get_room_name($wh[room]);
	$s=tmq_fetch_array($s);
	return "<FONT class=smaller>".getlang($s[name])."</FONT>";
}
function localmem($wh) {
	return "<B><A HREF='_print.temp.php?memberbarcode=$wh[UserAdminID]' target=_blank>".getlang("พิมพ์::l::Print")."</A></B>";
}
		$resulttmp=tmq("select * from room where istemp='YES' ");
		$resulttmp=tfa($resulttmp);
		$resulttmp=$resulttmp[id];

function localmemedit($wh) {
	global $resulttmp;
	if ($wh[room]!=$resulttmp) {
		return "-";
	}
	return "<B><A HREF='forgotedit.php?ID=$wh[UserAdminID]' target=_self>".getlang("แก้ไขและพิมพ์::l::Edit and Print")."</A></B>";
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
$_TBWIDTH="100%";

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","memberbarcode=$memberbarcode&membertype=$membertype",$c,"","");

?>