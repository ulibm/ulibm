<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

?>
<TABLE class=table_border width=100% align=center>
<FORM METHOD=POST ACTION="working.finelist.php">
<TR>
	<TD class=table_head><?php  echo getlang("กรุณากรอกบาร์โค้ดสมาชิกเพื่อค้นหา::l::Please enter member's barcode to search");?></TD>
	<TD class=table_td> <INPUT TYPE="text" NAME="memberbarcode" ID="memberbarcode" value="<?php  echo $memberbarcode?>">
	<INPUT TYPE="submit" value=" OK "> <?php 
	if ($memberbarcode!="") {
		?><A HREF="working.finelist.php"><?php echo getlang("แสดงทั้งหมด::l::Show all");?></A><?php 
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

$dsp[6][text]="จัดการ::l::Manage";
$dsp[6][field]="dat";
$dsp[6][align]="center";
$dsp[6][filter]="module:letclickmanage";
$dsp[6][width]="10%";

$dsp[7][text]="Barcode";
$dsp[7][field]="memberId";
$dsp[7][width]="15%";

$dsp[2][text]="สมาชิก::l::Member";
$dsp[2][field]="memberId";
$dsp[2][filter]="memberbarcode";
$dsp[2][width]="20%";

$dsp[3][text]="รายการ::l::Topic";
$dsp[3][field]="topic";
$dsp[3][width]="30%";



$dsp[4][text]="Fine::l::Fine";
$dsp[4][field]="fine";
$dsp[4][filter]="number";
$dsp[4][width]="10%";

$dsp[5][text]="วันที่::l::Date";
$dsp[5][field]="dt";
$dsp[5][filter]="date";
$dsp[5][width]="20%";


function letclickmanage($wh) {
	return "<B><A HREF='main.fine.php?memberbarcode=$wh[memberId]&submitnow=yes' target=main>".getlang("จัดการ::l::Manage")."</A></B>";
}

$tbname="fine";

$limit=" 1 ";
if ($memberbarcode!="") {
	$limit.=" and memberId = '$memberbarcode' ";
}


fixform_tablelister($tbname," $limit and isdone='no' ",$dsp,"no","no","no","memberbarcode=$memberbarcode",$c,"","");

?>