<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

?>
<TABLE class=table_border width=100% align=center>
<FORM METHOD=POST ACTION="working.finehistlist.php">
<TR>
	<TD class=table_head><?php  echo getlang("กรุณากรอกบาร์โค้ดสมาชิกเพื่อค้นหา::l::Please enter member's barcode to search");?></TD>
	<TD class=table_td> <INPUT TYPE="text" NAME="memberbarcode" ID="memberbarcode" value="<?php  echo $memberbarcode?>">
	<INPUT TYPE="submit" value=" OK "> <?php 
	if ($memberbarcode!="") {
		?><A HREF="working.finehistlist.php"><?php echo getlang("แสดงทั้งหมด::l::Show all");?></A><?php 
	}
	?></TD>
</TR>
</FORM>
<SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('memberbarcode').select();
//-->
</SCRIPT>
</TABLE>
<?php 
 //dsp

//dsp
$dsp[6][text]="จัดการ::l::Manage";
$dsp[6][field]="dat";
$dsp[6][align]="center";
$dsp[6][filter]="module:letclickmanage";
$dsp[6][width]="10%";

$dsp[2][text]="ใบเสร็จ::l::Reciept";
$dsp[2][field]="idid";
$dsp[2][filter]="linkout:working.fine.fdd.php?id=[value-idid]&memberbarcode=[value-member],_blank";
$dsp[2][width]="15%";

$dsp[3][text]="จำนวนเงิน::l::Cach";
$dsp[3][field]="cach";
$dsp[3][width]="10%";

$dsp[4][text]="ผู้รับจ่าย::l::Librarian";
$dsp[4][field]="lib";
$dsp[4][width]="20%";
$dsp[4][filter]="module:locallib";

$dsp[5][text]="สมาชิก::l::Member";
$dsp[5][field]="member";
$dsp[5][width]="20%";
$dsp[5][filter]="memberbarcode";

$dsp[9][text]="วันที่ชำระ::l::Paid date";
$dsp[9][filter]="date";
$dsp[9][field]="dt";
$dsp[9][width]="30%";

function locallib($wh) {
	return get_library_name($wh[lib]);
}
function letclickmanage($wh) {
	return "<B><A HREF='main.fine.php?memberbarcode=$wh[member]&submitnow=yes' target=main>".getlang("จัดการ::l::Manage")."</A></B>";
}

$tbname="finedone";
$limit=" 1 ";
if ($memberbarcode!="") {
	$limit.=" and member = '$memberbarcode' ";
}
$_TBWIDTH="100%";

fixform_tablelister($tbname,"  $limit  ",$dsp,"no","no","no","xx=$xx",$c);

?>