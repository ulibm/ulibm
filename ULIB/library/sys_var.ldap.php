<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_varldap";
        mn_lib();
				include("sys_var.inc.php");
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-ทั่วไป::l::System variables-General"));

?>
<table border = 0 cellpadding = 0 width = 800 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<?php 
local_mn("ldapisenable","LDAP","isenable","yesno");
local_mn("ldaphost","LDAP","ldaphost","text");
local_mn("ldapmemfield","LDAP","memfield","text");
local_mn("ldapuser","LDAP","ldapuser","text");
local_mn("ldappassword","LDAP","ldappassword","text");
local_mn("ldapdomain","LDAP","ldapdomain","text");
local_mn("ldapbasedn","LDAP","ldapbasedn","text");
local_mn("ldapgroup","LDAP","ldapgroup","text");
local_mn("ldapdnmapid","LDAP","ldapdnmapid","text");

?>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <a href='sys_var.ldap.test.php' class='smaller a_btn'>LDAP Test</a></td>
</tr></form>
</table>
<?php 
				foot();
?>