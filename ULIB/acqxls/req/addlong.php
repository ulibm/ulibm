<?php  
session_start();
include("../inc/config.inc.php");
include("./_REQPERM.php");
               
     head();   
loginchk_lib();
if (!library_gotpermission("suggestbookbylist")) {
	die("adminonly");

}

if ($issave=="yes"&&$pid!="") {
	$longdata=str_replace("\t"," ",$longdata);
	$s=explodenewline($longdata);
	$s=arr_filter_remnull($s);
//	printr($s);
$cc=0;
	while (list($k,$v)=each($s)) {
		$v=addslashes($v);
		$sql="insert into suggestbookbylist_sub set pid='$pid' , text='$v' ";
		tmq($sql);
		$cc++;
	}
	html_dialog("","ทำการบันทึกข้อมูลไปแล้ว $cc รายการ");
}

?>
<TABLE width=<?php echo $_TBWIDTH?> align=center>
<FORM METHOD=POST ACTION="addlong.php">
<INPUT TYPE="hidden" NAME="issave" value="yes">
<INPUT TYPE="hidden" NAME="pid" value="<?php echo $pid?>">
	<TR>
	<TD>กรุณาวางรายการทรัพยากรที่ต้องการสั่งซื้อ โดยจัดให้อยู่ในลักษณะ 1 บรรทัด ต่อ 1 รายการ จากนั้นกดปุ่มบันทึกข้อมูล<BR>
	<TEXTAREA NAME="longdata" style="width: 990; height: 500" ROWS="" COLS="" wrap=off ></TEXTAREA><BR>
	<INPUT TYPE="submit" value="บันทึกข้อมูล"> <B><A HREF="sub.php?pid=<?php echo $pid;?>">กลับ</A></B>
	</TD>
</TR>
</FORM>
</TABLE>
<?php  

foot();
?>