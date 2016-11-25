<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("configinfo");


		?><BR><?php 
			pagesection(getlang("การตั้งค่าทั่วไปของระบบ::l::Base system configuration"));

?><TABLE align=center width=400>
<TR>
	<TD>
<?php  
echo "<BR>DB.host=$host";
echo "<BR>DB.user=$user";
echo "<BR>DB.passwd=$passwd";
echo "<BR>DB.dbname=$dbname";
echo "<BR>EXT.memberspechtml=$memberspechtml";
echo "<BR>EXT._STR_A_Z=$_STR_A_Z";
echo "<BR>PATH.dcr=$dcr";
echo "<BR>PATH.dcrs=$dcrs";
echo "<BR>PATH.dcrURL=$dcrURL";
echo "<BR>VAL._CONFIG=$_CONFIG";
echo "<BR>VAL._MSTARTY=$_MSTARTY";
echo "<BR>VAL._MENDY=$_MENDY";
echo "<BR>VAL._ROOMWORD=$_ROOMWORD";
echo "<BR>VAL._CONFIG=$_CONFIG";
echo "<BR>VAL._FACULTYWORD=$_FACULTYWORD";
echo "<BR>VAL._IS_ENABLE_AUTO_INDEXWORD=$_IS_ENABLE_AUTO_INDEXWORD";
echo "<BR>SESS.lang_control_val=$lang_control_val";
	?>
</TD>
</TR>
</TABLE><BR><?php 
foot();
?>