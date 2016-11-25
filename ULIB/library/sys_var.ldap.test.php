<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_varldap";
        mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-ทั่วไป::l::System variables-General"));

?><form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<table border = 0 cellpadding = 0 width = 800 align = center cellspacing=30>


	<tr valign = "top">
	  <td colspan=2 align=center>User: <input type=text name=uuu value="<?php echo $uuu;?>"> Password: <input type=text name=ppp value="<?php echo $ppp;?>">
	  <BR><input type=submit value=' Submit '> <a href='sys_var.ldap.php' class='smaller a_btn'>Back</a></td>
</tr>
</table></form><?php 
if ($issave=="yes") {
   $errarr=Array();
	$errarr["525"]="user not found";
	$errarr["52e"]="invalid credentials";
	$errarr["530"]="not permitted to logon at this time";
	$errarr["531"]="not permitted to logon from this computer";
	$errarr["532"]="password expired";
	$errarr["533"]="account disabled";
	$errarr["701"]="account expired";
	$errarr["773"]="user must reset password";
	$errarr["775"]="account locked";
	define('LDAP_OPT_DIAGNOSTIC_MESSAGE', 0x0032);
	
   $ldapuser = trim(getval("LDAP","ldapuser"));
   $ldappassword = trim(getval("LDAP","ldappassword"));
   $ldaphost =trim(getval("LDAP","ldaphost"));
   $ldapdomain = trim(getval("LDAP","ldapdomain"));
   $ldapbasedn = trim(getval("LDAP","ldapbasedn"));
   $ldapgroup = trim(getval("LDAP","ldapgroup"));
   $ldapmemfid = trim(getval("LDAP","memfield"));
   echo "checklogin:($uuu, $ppp)[$ldapuser,$ldappassword,$ldaphost,$ldapdomain,$ldapbasedn,$ldapgroup,$ldapmemfid]<BR>";
   //$ad = ldap_connect("ldap://{$ldaphost}.{$ldapdomain}") or die('Could not connect to LDAP server.');
   $ad = ldap_connect($ldaphost);
   if (!$ad) {
      echo "ldap_connect error:";
      if (ldap_get_option($ad, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
         echo "Error Binding to LDAP: $extended_error";
      }
      echo "<BR>";
   } else {
      echo "ldap_connect OK:";
      echo "<BR>";
   }
   ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
   ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
   $ldapdnmapid=trim(getval("LDAP","ldapdnmapid"));
    echo  "($ldapdnmapid={$uuu})<BR>";
   //echo "Binding ..."; 
   ldap_set_option($ad, LDAP_OPT_REFERRALS,0);
   $r= ldap_bind($ad,$ldapuser,$ldappassword);
   if (!$r) {
      echo "ldap_bind($ad,$ldapuser,$ldappassword); error:";
      if (ldap_get_option($ad, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
         echo "Error Binding to LDAP: $extended_error";
      }
      echo "<BR>";
   } else {
      echo "ldap_bind($ad,$ldapuser,$ldappassword); OK:";
      echo "<BR>";
   }

   //ldap_bind($ad, "{$ldapuser}@{$ldapdomain}", $ldappassword) or die('Could not bind to AD.');
   echo "Getting User DN getDN($ad, $uuu, $ldapbasedn)<BR>";
   $userdn = getDN($ad, $uuu, $ldapbasedn);
   if ($userdn=="") {
      echo "UserDN not found<BR>";
   } else {
      echo "UserDn=[$userdn];<BR>";
   }
   /*
   $tmpgetdn=getDN($ad, $ldapgroup, $ldapbasedn);
   echo "(checkGroupEx($ad, $userdn, $tmpgetdn))<BR>";
   if (checkGroupEx($ad, $userdn, $tmpgetdn)) {
   //if (checkGroup($ad, $userdn, getDN($ad, $group, $basedn))) {
       echo "<BR><b style='color:darkgreen'>You're authorized as ".getCN($userdn)."</b>";
   } else {
      if (ldap_get_option($ad, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
         echo "Error Binding to LDAP: $extended_error";
      }   
       echo "<BR><b style='color:darkred'>Authorization failed</b>";
   }*/
    
   if (@ldap_bind($ad, $userdn, $ppp)&& $userdn!="") { 
       echo "<BR><b style='color:darkgreen'>You're authorized as ".getCN($userdn)."</b>";
   } else {
      if (ldap_get_option($ad, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
         echo "Error Binding to LDAP: $extended_error";
      }   
       echo "<BR><b style='color:darkred'>Authorization failed</b>";
   }
}
?>
<?php 
				foot();
?>