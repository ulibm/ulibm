<?php 
	;
	include ("../inc/config.inc.php");
	include ("./inc.php");
	html_start();
	if ($id!="" && $setstat!="") {
		$isfound_reason=addslashes($isfound_reason);

		tmq("update oss_req set
		dt_lastupdate='$now',
		isfound_reason='$isfound_reason',
		stat='$setstat',
		fee='$fee'
		where id='$id'
		",false);
		?><script type="text/javascript">
		<!--
			window.open("_slip.php?id=<?php  echo $id;?>");
		//-->
		</script><?php 
		redir("desk.waitpayment.php");
	}
	$s=tmq("select * from oss_req where id='$id' ");
	$s=tfa($s);
	$now=time();

	$pickupatdb=tmq_dump2("oss_pickuptype","classid","name");
	$sourcesdb=tmq_dump2("oss_sources","classid","name");
?>
<table cellpadding=20>
<tr>
	<td><?php  echo stripslashes($s[mat_info]);?><br>
	โน๊ต/ข้อความถึงบรรณารักษ์: <?php  echo stripslashes($s[bknote]);?><br>
	ทรัพยากรของ: <?php  echo stripslashes($sourcesdb[$s[sources]]);?><br>
	การรับเอกสาร: <?php  echo stripslashes($pickupatdb[$s[pickupat]]);?><br>
	สถานะปัจจุบัน: <b><?php  
	echo $statdb[$s[stat]];
	
	?></b>
	
	
	
	</td>
</tr>
</table>
<TABLE width=100% class=table_border>
<TR>
	<TD align=center style="background-color: #eeeeee">กรุณากำหนดสถานะ</TD>
</TR>
</TABLE>
<TABLE width=100% style="border: 1px solid darkgreen; padding: 3 3 3 3; margin: 5 5 5 5;background-color: #EFFCED">
<FORM METHOD=POST ACTION="updatepaystatus.php">
<INPUT TYPE="hidden" NAME="id" value="<?php  echo $id?>">
<TR valign=top>
	<TD align=center width=100 valign=top> <B>พบ</B></TD>
	<TD align=left><TABLE width=100%>
	<TR valign=top>
	
		<TD class=smaller> <TEXTAREA NAME="isfound_reason" ROWS="3" COLS="40" style="width: 100%;font-family: Tahoma;"><?php  echo $s[isfound_reason]?></TEXTAREA>
		</TD>
	</TR>
	<tr>
		<td>ค่าใช้จ่าย <input type="text" name="fee" value="<?php  echo number_format($s[fee],2);?>"> บาท</td>
	</tr>
	<tr>
		<td>กำหนดสถานะเป็น<br>
		<!-- <label><input type="radio" name="setstat" value='done' checked> รายการเสร็จเรียบร้อยแล้ว</label> -->
		<label><input type="radio" name="setstat" value='new'  <?php  if ($s[stat]=="new") echo "checked"; ?>> รายการใหม่</label>
		<label><input type="radio" name="setstat" value='waitpayment'  <?php  if ($s[stat]=="waitpayment") echo "checked"; ?>> รอชำระเงิน</label>
		<label><input type="radio" name="setstat" value='waitpickup'  <?php  if ($s[stat]=="waitpickup") echo "checked"; ?> > รอผู้มารับเอกสาร</label>
		</td>
	</tr>
	</TABLE><INPUT TYPE="submit" style="font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;"  value=" บันทึก " class=a_btngreen></TD>
</TR>
</FORM>
</TABLE>

<TABLE width=100% style="border: 1px solid darkred; padding: 3 3 3 3; margin: 5 5 5 5;background-color: #FCEDED">
<FORM METHOD=POST ACTION="updatepaystatus.php">
<INPUT TYPE="hidden" NAME="id" value="<?php  echo $id?>">
<INPUT TYPE="hidden" NAME="setstat" value="cancelbylib">

<TR valign=top>
	<TD align=center width=100 valign=top> <B>ยกเลิกรายการ</B></TD>
	<TD align=left><TABLE width=100%>
	<TR valign=top>
		<TD width=100>สาเหตุ<br>
		<TEXTAREA ID="isfound_reasonid" name="isfound_reason" rows="3" cols="" style="width: 100%;font-family: Tahoma;"><?php  echo $s[isfound_reason]?></TEXTAREA><BR>
		<A HREF="javascript:void(null);" onclick="tmp=getobj('isfound_reasonid'); tmp.value='ผู้ใช้ขอยกเลิกรายการ';" class=smaller>ผู้ใช้ขอยกเลิกรายการ</A>, 
		<A HREF="javascript:void(null);" onclick="tmp=getobj('isfound_reasonid'); tmp.value='ผู้ใช้บริการไม่มาชำระ';" class=smaller>ผู้ใช้บริการไม่มาชำระ</A>
		
		</TD>
	</TR>

	</TABLE><INPUT TYPE="submit" style="font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;"  value=" บันทึก " class=a_btngreen></TD>
</TR>
</FORM>
</TABLE> <a href="desk.waitpayment.php" class=a_btn>กลับ</a>
<?php 
?>