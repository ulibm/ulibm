<?php 
    /*ฟังก์ชั่นตรวจสอบ Login และ Password */
    function ChkLoginAdminmember($useradminid, $passwordadmin) {
    
if (strtolower(getval("LDAP","isenable"))=="yes") {
   $ldapuser = trim(getval("LDAP","ldapuser"));
   $ldappassword = trim(getval("LDAP","ldappassword"));
   $ldaphost =trim(getval("LDAP","ldaphost"));
   $ldapdomain = trim(getval("LDAP","ldapdomain"));
   $ldapbasedn = trim(getval("LDAP","ldapbasedn"));
   $ldapgroup = trim(getval("LDAP","ldapgroup"));
   $ldapmemfid = trim(getval("LDAP","memfield"));
   //echo "--ChkLoginAdminmember($useradminid, $passwordadmin)[$ldapuser,$ldappassword,$ldaphost,$ldapdomain,$ldapbasedn,$ldapgroup,$ldapmemfid]";
   //$ad = ldap_connect("ldap://{$ldaphost}.{$ldapdomain}") or die('Could not connect to LDAP server.');
   $ad = ldap_connect($ldaphost) ;
   if (!$ad) { 
      echo ('Could not connect to LDAP server.');
   }
   ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
   ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
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
   //echo "Binding ..."; 
   //ldap_set_option($dsconn, LDAP_OPT_PROTOCOL_VERSION, 3);
   ldap_set_option($ad, LDAP_OPT_REFERRALS,0);
   //echo ldap_bind($ad,$ldapuser,$ldappassword);
   if (ldap_get_option($ad, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
      $exterror=explode(", data ",$extended_error);
      $exterror=explode(",",$exterror[1]);
      $exterror=trim($exterror[0]);
      echo "<br><b>[".$extended_error."]</b>";
      //echo "<br><b>[".$errarr[$exterror]."]</b>";
     echo "<br><b style='font-size:18px; font-weight:bold; color:red;'>[".$errarr[$exterror]."]</b>";
      echo "Error Binding to LDAP: $extended_error";
   }
   //ldap_bind($ad, "{$ldapuser}@{$ldapdomain}", $ldappassword) or die('Could not bind to AD.');
   $userdn = getDN($ad, $useradminid, $ldapbasedn);
   /*echo "UserDn=$userdn;";
   if (checkGroupEx($ad, $userdn, getDN($ad, $group, $basedn))) {
   //if (checkGroup($ad, $userdn, getDN($ad, $group, $basedn))) {
       echo "You're authorized as ".getCN($userdn);
   } else {
       echo 'Authorization failed';
   }*/
   if (@ldap_bind($ad, $userdn, $passwordadmin) && $userdn!="") { 
       echo "<BR><b style='color:darkgreen'>LDAP: You're authorized as ".getCN($userdn)."</b>";
       $userSQL="Select * From member Where $ldapmemfid='$useradminid'  AND statusactive ='normal' ";
       $result=tmq($userSQL,false);
       if (tnr($result)==1) {
         $rs=tfa($result);
         return $rs[UserAdminID];
       } else {
         echo "<BR><b style='color:darkred'>LDAP: $useradminid not match any member in database, skipping</b>";
         //return false;
       }
   } else {
      if (ldap_get_option($ad, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
         echo "Error Binding to LDAP: $extended_error<BR>";
      }   
       echo "<BR><b style='color:darkred'>LDAP: Authorization failed</b>";
   }
   
   
    }
    //die;
    
        $userSQL="Select * From member Where UserAdminID='$useradminid'  AND statusactive ='normal' ";
        //echo $userSQL;
        $result=tmq($userSQL);
        $num=tmq_num_rows($result);
		//echo "[$num]";
		if ($num!=1) {
			if (barcodeval_get("webpage-o-canmemberloginbyemail")=="yes" && umail_chk($useradminid)) {
				$userSQL="Select * From member Where email='$useradminid'  AND statusactive ='normal' ";
				$result=tmq($userSQL);
				$num=tmq_num_rows($result);
			} else {
				return false;
			}
		}
        $rs=tmq_fetch_array($result);
		//printr($rs);
	   if ($rs[Password]!=$passwordadmin) {
		return false;
	   }
		
        if ($num!=1)
            return false;
        else
            return $rs[UserAdminID];
        }
?>