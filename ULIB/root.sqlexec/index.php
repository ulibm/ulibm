<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("sqlexec");


			pagesection("SQL Executor");

?><BR><TABLE align=center width=550>

<TR>
		<TD align=center>
<?php 
//echo "<PRE>$sqlentered</PRE><HR>";
if ($issave=="yes") {
	filelogs("sql executor",$sqlentered,"SQLEXEC");
	$sqlentered=stripslashes($sqlentered);
	$s=tmq($sqlentered);
	/////////////////////
	?><TABLE width=550 bgcolor=666666 cellpadding=1 cellspacing=1>
	<TR bgcolor=FFFFFF><TD colspan="10"><B>ROWS=<?php echo number_format(tmq_num_rows($s));?></B></TD></TR>
	<TR bgcolor=#A0A0A0>
	<TD width=20><B>#</B></TD>
	<?php  while ($i < tmq_num_fields($s)) {
		$meta = tfa($s, $i);?>
		<TD><B><?php  echo $meta->name;?></B></TD>
	<?php 
		$i++;
		} ?>
	</TR>
	<?php  
	$s=tmq($sqlentered);
	$icount=0;
	while ($row=tmq_fetch_array($s)) {	
		$icount++;
		if ($icount>=3500) {
			?><TD colspan=10><B>DIE; via icount>=3500</B></TD><?php 
		}
	?>
	<TR bgcolor=FFFFFF>
	<TD><B><?php  echo $icount;?></B></TD>
	<?php  for ($i=0;$i<=mysql_num_fields($s);$i++) {?>
		<TD><?php echo $row[$i]?></TD>
	<?php  } ?>
	</TR>
	<?php 
	}?>
	</TABLE><?php 



	/////////////////////
}
?></TD>
</TR>

<TR>
<FORM METHOD=POST ACTION="index.php">
		<TD align=center>
		<INPUT TYPE="hidden" name=issave value="yes">
<TEXTAREA NAME="sqlentered" ROWS="8" COLS="64"><?php  echo $sqlentered?></TEXTAREA><BR>
<INPUT TYPE="submit" value=" EXEC SQL ">
</TD>
	</FORM>
</TR>


<TR>
	<TD>
<BR><BR>
<HR>
<?php  echo getlang("<B>หมายเหตุ</B> ใส่ครั้งละ 1 คำสั่งเท่านั้น <BR>
คำสั่งทั้งหมดจะถูกบันทึกไว้อ้างอิงภายหลัง และ การใช้คำสั่งผิด อาจทำให้เกิด<BR>ความเสียหายกับระบบได้
<BR><BR>
หากเกิดความเสียหายกับระบบ โดยการใช้คำสั่งที่ไม่ถูกต้อง จะไม่อยู่ในความรับผิดชอบ<BR>
ของทีมงานผู้พัฒนาฯ <B>และขอแนะนำให้ ทำการสำรองข้อมูลก่อนการใช้คำสั่งทุกครั้ง!</B>::l::<B>Note</B> Only 1 command per time <BR>
all command will be loged to log file and some command may caused system work incorrectly.
<BR><BR>
Any error or data-losing by command enterd by administrator is not responsible of ULIB developer team<BR>
 <B>We recommended to full backup database befor use any command!</B>"); ?>

</TD>
</TR>
</TABLE><BR><?php 
foot();
?>