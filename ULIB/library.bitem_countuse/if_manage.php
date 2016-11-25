<?php 
	; 
		
        include ("../inc/config.inc.php");
html_start();
loginchk_lib();
 if (!library_gotpermission("bitem_countuse_manage")) { die("no permission") ; }

	$s=tmq("select * from countuse_name where countuse='$qnid' ");

	if (tmq_num_rows($s) ==0 )  {
		$name="[".getlang("ยังไม่ได้ตั้งชื่อ::l::Name not set")."]";
		echo $name;
		die;
	} else {
		$s=tmq_fetch_array($s);
		$name=$s[name] ;
	}
?><style>
body {
	background-color: #F4F4F4;
}
</style>
<?php 	echo "<H2><IMG SRC='../neoimg/Document32.gif' WIDTH='32' HEIGHT='32' BORDER='0' ALT='' align=absmiddle> $name</H2>";
?>
<TABLE align=center width=100%>
<TR>
	<TD><?php 
		$s=tmq("select count(id) as cc from media_mid where $qnid='YES' ");
	$s=tmq_fetch_array($s);
	$totalcc=number_format($s[cc]);
	if ($s[cc]!=0) {
		?><BR> <CENTER><B><?php  echo getlang("จัดการรายการที่ สแกน แล้ว::l::Manage Scanned Records"); ?> (<?php  echo number_format($s[cc]);?> <?php  echo getlang("รายการ::l::records"); ?>)</B></CENTER> <BR><B><?php  echo getlang("คำเตือน::l::Warning"); ?>!</B> <?php  echo getlang(" ส่วนนี้จะเป็นการแก้ไขรายการวัสดุโดยการคลิกเพียงครั้งเดียว<BR> ขอแนะนำให้ทำการสำรองข้อมูลไว้ก่อน เพื่อป้องกันความผิดพลาด::l::This operation is a Single-Click command.<BR>We recommended to backup database befor continuing."); ?><BR><BR>

		<TABLE width=100% align=center>
		<TR>
			<TD align=center colspan=2>	<B><?php  echo getlang("กรุณาเลือกคำสั่ง::l::Choose command."); ?></B></TD>
		</TR>


<FORM METHOD=POST ACTION="ch_inverse.php" onsubmit="return ( confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง ::l::Please confirm again."); ?>!'));">
				<TR>
			<TD><B><?php  echo getlang("นับรายการที่ยังไม่สแกน <BR>และยกเลิกรายการที่สแกนไปแล้ว::l::Inverse scanned items"); ?></B></TD>
			<TD  ><INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7"> (Invert Selection)</TD>
		</TR>
		<INPUT TYPE="hidden" name=qnid value="<?php  echo $qnid;?>">
		</FORM>



<FORM METHOD=POST ACTION="ch_status.php" onsubmit="return confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!');">
				<TR>
			<TD><B><?php  echo getlang("เปลี่ยนสถานะเป็น::l::Change Status to"); ?></B> </TD>
			<TD><SELECT NAME="status">
<?php 
	echo "<option value=''>ปกติ ";
$s=tmq("select * from media_mid_status order by name");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[code]'>".getlang($r[name])." ($r[code]) ";
}
?> 
			</SELECT> <INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7"></TD>
		</TR>
		<INPUT TYPE="hidden" name=qnid value="<?php  echo $qnid;?>">
		</FORM>
				
				
				
				
				
				
<FORM METHOD=POST ACTION="ch_siteoflib.php" onsubmit="return confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!');">
				<TR>
			<TD><B><?php  echo getlang("เปลี่ยนห้องสมุดที่เป็นเจ้าของ::l::Change Library campus"); ?></B></TD>
			<TD>
			<?php 
frm_libsite("siteoflib");	
?> <INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7"></TD>
		</TR>
		<INPUT TYPE="hidden" name=qnid value="<?php  echo $qnid;?>">
		</FORM>




<FORM METHOD=POST ACTION="ch_place.php"  onsubmit="return confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!');">
				<TR>
			<TD><B><?php  echo getlang("เปลี่ยนสถานที่จัดเก็บ::l::Change Shelf"); ?></B></TD>
			<TD><?php frm_itemplace("itemplace","NONE","NO");
?> <INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7"></TD>
		</TR>
		<INPUT TYPE="hidden" name=qnid value="<?php  echo $qnid;?>">
		</FORM>



<FORM METHOD=POST ACTION="ch_del.php" onsubmit="return ( confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!') && confirm('<?php  echo getlang("กรุณายืนยันการลบ::l::CONFIRM DELETION"); ?>'));">
				<TR>
			<TD><B><?php  echo getlang("ลบ::l::Delete"); ?></B></TD>
			<TD  ><INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการลบ::l::Operate deletion"); ?>"  style="background-color: #FFC4C7"></TD>
		</TR>
		<INPUT TYPE="hidden" name=qnid value="<?php  echo $qnid;?>">
		</FORM>
		<?php 
	} else {
		?><BR> <CENTER><B><?php  echo getlang("ยังไม่ได้ สแกน รายการใดไว้::l::No record scanned"); ?></B></CENTER> <BR><?php 
	}
	

	?></TD>
</TR>
</TABLE><BR><BR><CENTER>
<?php  echo getlang("ส่งออก Bib ::l::Export Bib. ");?> [<?php  echo ($totalcc);?>] 
<a href="exportxls_b.php?qnid=<?php echo $qnid;?>&main=<?php echo $main;?>&exportmode=csv" class=a_btn>CSV</a> 
<a href="exportxls_b.php?qnid=<?php echo $qnid;?>&main=<?php echo $main;?>&exportmode=csvreadable" class=a_btn>CSV เฉพาะเนื้อหา</a> 
<a href="exportxls_b.php?qnid=<?php echo $qnid;?>&main=<?php echo $main;?>&exportmode=full" class=a_btn>ข้อมูลเต็ม</a>
<a href="exportxls_b.php?qnid=<?php echo $qnid;?>&main=<?php echo $main;?>&exportmode=brieve" class=a_btn>ข้อมูลย่อ</a>
<a href="exportxls_b.php?qnid=<?php echo $qnid;?>&main=<?php echo $main;?>&exportmode=shorted" class=a_btn>เฉพาะชื่อเรื่อง</a>
<a href="exportxls_b.php?qnid=<?php echo $qnid;?>&main=<?php echo $main;?>&exportmode=marc" class=a_btn>MARC</a><br>

<?php  echo getlang("ส่งออก Item ::l::Export Item.");?> [<?php  echo $totalcc;?>] <a href="exportxls_i.php?qnid=<?php echo $qnid;?>&exportmode=full" class=a_btn>CSV</a><br />


<BR><B><CENTER><A class=a_btn HREF="if.php?qnid=<?php  echo $qnid;?>"><?php  echo getlang("กลับ::l::Back"); ?> </A></CENTER></B>