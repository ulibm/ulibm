<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("shellinfo");
			pagesection("Server information");

?><BR><TABLE width=500 align=center>
<FORM METHOD=POST ACTION="action.php">
<TR>
	<TD><B>Select Options</B></TD>
</TR>
<TR>
	<TD><SELECT NAME="command[]" size=5 MULTIPLE style="width: 220px; height: 350px;">
	<optgroup label='LINUX'>
		<option value="shutdown -h now">Shutdown</option>
		<option value="reboot">Reboot</option>
		<option value="service network restart">restart network</option>
	</optgroup>
	<optgroup label='WINDOWS'>
		<option value="shutdown -s -t 01">Shutdown</option>
		<option value="shutdown -r -t 01">Reboot</option>
		<option value="shutdown -l -t 01">Logout</option>
		<option value="shutdown -h -t 01">Hibernate</option>
	</optgroup>
	</SELECT></TD>
</TR>
<TR>
	<TD><?php 
	echo getlang("การทำงานเหล่านี้ อาจจะไม่สำเร็จ เนื่องจากระบบการรักษาความปลอดภัยของเซิร์ฟเวอร์::l::These operation might not success due to server's security setting.");
	?><BR><INPUT TYPE="submit"></TD>
</TR>

</FORM>
</TABLE><BR><?php 
foot();
?>