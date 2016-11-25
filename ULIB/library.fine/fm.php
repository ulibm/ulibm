<?php 
    ;
	include("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
function local_finemenu($text,$url,$descr) {
   global $dcrURL;
	?><table width = "550" align=center border = "0" cellspacing = "0" cellpadding = "0">
		<tr>
			<td rowspan = "2">
				&nbsp;</td>
			<td width = "525">
				<font face = "MS Sans Serif, Microsoft Sans Serif" size = "2"><a class = stupidmenu href = "<?php  echo $url;?>">
				<font size = "5" class = stupidmenu><?php  echo getlang($text);?></font></a></font></td>
		</tr>
		<tr>
			<td width = "525">
				<font face = "MS Sans Serif, Microsoft Sans Serif" size = "2"><?php  echo getlang($descr);?></font></td>
		</tr>
		<tr>
			<td colspan = "2" height = "2">
				<font size = "2" face = "MS Sans Serif, Microsoft Sans Serif">
				<img src = "<?php echo "$dcrURL"; ?>neoimg/spacer.gif" width = "1" height = "5"></font></td>
		</tr>
	</table>
<?php 
}
?><br><br>
<table border=0 align=center width=700>
<tr>
	<td><FIELDSET style="background-color: white;">
	<LEGEND ><b><?php  echo getlang("รายงานค่าปรับ::l::Fine Report"); ?></b></LEGEND>
		<?php 
	local_finemenu("สรุปค่าปรับ::l::Fine Summary","fine-summary.php","รายงานสรุปค่าปรับ::l::Brief report of fine payment");
	//local_finemenu("รายการชำระค่าปรับ::l::Fine Report","fine-report.php","แสดงรายการค่าปรับแบบละเอียด::l::Detailed History");

?>
	</FIELDSET></td>
</tr>
</table>

<BR><?php 
	//local_finemenu("ชำระค่าปรับ::l::Pay fine","fine.php","สำหรับดูค่าปรับของสมาชิก โดยเรียกดูจากบาร์โค้ด::l::Member need to pay/view his/her fines");
	//local_finemenu("รายการค่าปรับ::l::Fine list","finelist.php","แสดงรายการค่าปรับที่ยังไม่ได้ชำระทั้งหมด::l::View all unpaid fine");
	//local_finemenu("ประวัติค่าปรับที่ชำระแล้ว::l::Paid fine","finedone.php","แสดงรายการค่าปรับที่ชำระแล้วทั้งหมด::l::List all paid fine");
	local_finemenu("รายการชำระค่าปรับรายวัน::l::View fines by date","finedaily.php","แสดงรายการค่าปรับที่รับชำระแบบรายวัน::l::View paid fines by date");
	local_finemenu("แสดงรายการค่าปรับที่ชำระแล้วของทุกสาขาห้องสมุด::l::View paid fine from all campus","finedaily-alllib.php","แสดงรายการค่าปรับที่ชำระแล้วของทุกสาขาห้องสมุด พร้อมแสดงรายการย้อนหลัง::l::View paid fin from all campus");
	local_finemenu("รายการชำระค่าปรับรายวัน (รายละเอียด)::l::View fines by date (Detailed)","finelimit.php","แสดงรายการค่าปรับที่รับชำระแบบรายวัน::l::View paid fines by date");

?>
<?php 
	foot();
?>