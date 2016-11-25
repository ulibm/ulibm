<?php 
function form_root_login() {
		global $dcrURL;
		global $dcr;
		head();
		redir($dcrURL,75);
?>
<TABLE width=700 height= 260 align=center border=0 cellpadding=0 cellspacing=0
background="/<?php  echo $dcr;?>/neoimg/formlogin_root.png">
<FORM METHOD=POST ACTION="/<?php  echo $dcr;?>/root/login.php">
<TR>
	<TD valign=middle style="padding-right: 100px;">

	<TABLE align=right>
<TR>
	<TD bgcolor="#840000" style="font-size: 18px; font-weight: bold; color: #FFF4CA" align=center colspan=2><?php  echo getlang("กรุณาป้อนล็อกอินและรหัสผ่าน::l:: Enter login and password "); ?></TD>
</TR>
	<TR>
		<TD><B><?php  echo getlang("รหัสล็อกอิน::l::Loginid"); ?></B></TD>
		<TD>: <input ID = "FC" type = "text" name = "useradminidx" autocomplete=off>
<SCRIPT LANGUAGE = "JavaScript">
<!--
getobj('FC').focus()
          //-->
</SCRIPT></TD>
	</TR>
	<TR>
		<TD><B><?php  echo getlang("รหัสผ่าน::l::Password"); ?></B></TD>
		<TD>: <input type = "password" name = "passwordadminx" autocomplete=off></TD>
	</TR>

<TR>
	<TD></TD>
	<TD><input  type = submit  style='color:darkred' value = "<?php  echo getlang("เข้าสู่ระบบ::l::Login"); ?>" name = "submit" class=frmbtn>
<input type = reset style='color:darkred'  value = "<?php  echo getlang("ลบข้อมูล::l::Reset"); ?>" name = "submit2" class=frmbtn></TD>
</TR>
</TABLE>
	
	</TD>
</TR>

</FORM>
</TABLE>


							<CENTER><BR>
							<A HREF="/<?php echo $dcr;?>/library/"><?php  echo getlang("ระบบเจ้าหน้าที่ห้องสมุด::l::Librarian system"); ?></A> : 
							<A HREF="/<?php echo $dcr;?>/">Home Page</A><BR>
<BR>
</CENTER><?php 

	foot();
}
?>