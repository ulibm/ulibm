<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("activateulib");
		if ($deactivateusisinfo=="yes") {
			tmq("delete from barcode_val where classid like 'activateulib-%' ");
		}
		tmq("delete from barcode_valmem");
?><BR><?php 
			pagesection(getlang("ULIBM - Current License Information"),"login");
?><style>
.localhead {
	font-size: 36px;
}
</style><BR><TABLE width=550 align=center cellpadding=10 >
<TR>
	<TD style="padding-left: 2px;"><?php 
	$cl=barcodeval_get("activateulib-status");
	$cl=trim($cl);
	if ($cl=="") {
		?><IMG SRC="./d.png" WIDTH="128" HEIGHT="128" BORDER="0" ALT="" align=left hspace=10> <B style="color: #9F0F0F" class=localhead>Not registered</B><BR><BR>
		<A HREF="register.php"><?php  echo getlang("คลิกที่นี่เพื่อลงทะเบียน::l::Click here to register.");?></A>
		<?php 
	}
	if ($cl=="registered") {
		?><IMG SRC="./a.png" WIDTH="128" HEIGHT="128" BORDER="0" ALT="" align=left hspace=10> <B style="color: darkgreen" class=localhead>Registered</B><BR><BR>
		<A HREF="register.php"><?php  echo getlang("คลิกที่นี่เพื่อดู/แก้ไขข้อมูล::l::Click here to view/edit your information");?></A><br />

<center><br />
<br />
<br />
<iframe width=450 scrolling="no" height=300 src="<?php  echo getval("SYSCONFIG","ulibmasterurl");?>activateulib/sv/cert.php?certid=<?php  echo barcodeval_get("activateulib-refcode")?>" frameborder="1"></iframe></center>
		<CENTER><A HREF="index.php?deactivateusisinfo=yes" onclick="return confirm('please confirm') && confirm('please register again!');" style="font-size:12; color:darkred"><?php 
		echo getlang("หากต้องการยกเลิกการลงทะเบียน กรุณาคลิกที่นี่::l::If need to un-register, click here");
	?></A></CENTER><?php 
	}
	?></TD>
</TR>
</TABLE><?php 

foot();
?>