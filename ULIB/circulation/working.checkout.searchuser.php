<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

?>
<TABLE class=table_border width=100% align=center>
<FORM METHOD=POST ACTION="working.checkout.searchuser.php">
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

$dsp[9][text]="ให้ยืม::l::Checkout";
$dsp[9][align]="center";
$dsp[9][field]="memberbarcode";
$dsp[9][filter]="module:letcheckout";
$dsp[9][width]="10%";

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
	return "<FONT class=smaller2>".get_room_name($wh[room])."</FONT>";
	$s=tmq_fetch_array($s);
	return "<FONT class=smaller>".getlang($s[name])."</FONT>";
}
function letcheckout($wh) {
	return "<B><A HREF='main.checkout.php?memberbarcode=$wh[UserAdminID]' target=main>".getlang("ให้ยืม::l::Checkout")."</A></B>";
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

?><a href="<?php echo $dcrURL;?>library.member/addDBddal.php" target=_blank class=a_btn><?php echo getlang("เพิ่มสมาชิกใหม่::l::Add new member");?></a>