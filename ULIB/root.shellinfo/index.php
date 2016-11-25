<?php  //พ
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
	<TD><SELECT NAME="command[]" size=7 MULTIPLE style="width: 220px; height: 350px;">
	<optgroup label='LINUX'>
		<option value="uptime">Uptime</option>
		<option value="uname -a">System Information</option>
		<option value="free -m">Memory Usage (MB)</option>
		<option value="df -h">Disk Usage</option>
		<option value='cat /proc/cpuinfo | grep \"model name\\|processor\"'>CPU Information</option>
		<option value="ifconfig">Ifconfig</option>
		<option value="ps">Process</option>
		<option value="ps -a">Process [all]</option>
		<option value="ping www.ulibm.net">Ping Ulibm.net</option>
		<option value="traceroute www.ulibm.net">TRACERT Ulibm.net</option>
		<option value="httpd -v">httpd -v</option>
	</optgroup>
	<optgroup label='WINDOWS'>
		<option value="ipconfig  /all">IPCONFIG</option>
		<option value="time">Time</option>
		<option value="date">Date</option>
		<option value="ver">Windows version</option>
		<option value="vol">Harddisk</option>
		<option value="set"> Windows environment variables</option>
		<option value="netstat">Netstat</option>
		<option value="netstat -a">Netstat (all)</option>
		<option value="ping www.ulibm.net">Ping Ulibm.net</option>
		<option value="pathping www.ulibm.net">PathPing Ulibm.net</option>
		<option value="SYSTEMINFO">SYSTEMINFO</option>
		<option value="TASKLIST">TASKLIST</option>
		<option value="TRACERT www.ulibm.net">TRACERT Ulibm.net</option>
		<option value="Driverquery">Driverquery</option>
		<option value="Mountvol ">Mountvol </option>
		<option value="Hostname">Hostname</option>
	</optgroup>
	</SELECT></TD>
</TR>
<TR>
	<TD><INPUT TYPE="submit"></TD>
</TR>

</FORM>
</TABLE><BR><?php 
foot();
?>