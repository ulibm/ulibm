<?php 
	head();
	$_REQPERM="memexpire";
	mn_lib();
	pagesection(getlang("กรุณาระบุตัวเลือกการส่งอีเมล์::l::Please enter mail option"));
	$source_db=tmq("select * from memexpire_notif where setid='$setid' ",false);
	$num=number_format(tmq_num_rows($source_db));
	?><CENTER><?php 
	echo getlang("ส่งอีเมล์เตือนถึงผู้รับ $num ฉบับ::l::Send $num notification emails ");
	?></CENTER><BR><TABLE width=700 align=center class=table_border>
	<FORM METHOD=POST ACTION="emailsaction.php">
		<TR>
		<TD class=table_head><?php  echo getlang("หัวข้ออีเมล์");?></TD>
		<TD class=table_td><INPUT TYPE="text" NAME="mailsubj" value="<?php 
		echo stripslashes(barcodeval_get("memexpirenotif-email-mailsubj"));
		?>" size=60></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("เนื้อหาของอีเมล์");?></TD>
		<TD class=table_td><TEXTAREA NAME="mailbody" ROWS="10" COLS="60" wrap="off"><?php 
		echo stripslashes(barcodeval_get("memexpirenotif-email-mailbody"));
		?></TEXTAREA></TD>
	</TR>
	<TR>
		<TD class=table_td colspan=2 align=center><INPUT TYPE="submit" value=" Send Emails">
		<INPUT TYPE="hidden" NAME="setid" value="<?php  echo $setid;?>"> <A HREF="index.php" class=a_btn><?php echo getlang("กลับ::l::Back");?></A>
		</TD>
	</TR>
	</FORM>
	</TABLE><BR>
	<TABLE width=400 align=center class=table_border>
	<TR>
		<TD class=table_head><?php echo getlang("โค้ดที่ใช้ได้::l::Available code");?></TD>
	</TR>
	<TR>
		<TD class=table_td>
		[MEMBERNAME]=<?php echo getlang("ชื่อของสมาชิก::l::Member's Name");?><BR>
		[MEMBERBC]=<?php echo getlang("Barcode ของสมาชิก::l::Member's Barcode");?><BR>
		[MEMBERMAIL]=<?php echo getlang("Email ของสมาชิก::l::Member's Email");?><BR>
		[MYNAME]=<?php echo getlang("ชื่อของคุณ::l::Your name");?><BR>
		[LIBURL]=<?php echo getlang("URL เว็บไซต์::l::Website's URL");?><BR>
		[EXPDATE]=<?php echo getlang("วันหมดอายุสมาชิก::l::Expire date");?><BR>
		
		</TD>
	</TR>
	</TABLE>
	<?php 
	foot();
?>