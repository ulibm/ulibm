<?php 
;
include("../inc/config.inc.php");
$token=trim($token);
if ($token=="") {
	die("error : missing access token, halting");
} else {
	$mybc=file_get_contents(getval("_SETTING","useulibmconnect_url")."/token_get_membc.php?token=$token&REFCODE=".barcodeval_get("activateulib-refcode"));
	$mybc=trim($mybc);
	//echo $mybc;
	$_memid=$mybc;
	if ($_memid=="") {
		html_dialog("error","return empty barcode"); 
		die;
	}
	if ($_ISULIBMASTER=="yes") {
		/// chk uug logins
		 $userSQL="Select * From ulib_clientlogins Where loginid='$_memid'  AND lower(isallowed) ='yes' ";
        $result=tmq($userSQL);
        $num=tmq_num_rows($result);
		if ($num==1) { // uug ok
			tmq("update  ulib_clientlogins  set logincount=logincount+1 Where loginid='$_memid'  ");
			$_memid="uug:$_memid";
			ulibsess_register("_memid");
			$backto=trim($backto);
			if ($backto=="") {
				redir("$dcrURL",1);
			} else {
				redir(urldecode($backto),1);
			}
			die;
		}
	}
	ulibsess_register("_memid");
	member_log($_memid,"login");
	statordr_add("memberlogin_member",$_memid);	

	//stat
	$sql3="SELECT *  FROM member where UserAdminID='$_memid'"; //หา old data
	//echo $sql3; 
	$result3=tmq($sql3);
	if (tmq_num_rows($result3)==1) {
		$row3=tmq_fetch_array($result3);
	} 

	statordr_add("memberlogin_member",$_memid);	
	stat_add("memberlogin_membertype",$row3[type]);
	// redir
	$memberloginthengoto=barcodeval_get("webpage-o-memberloginthengoto");
	$backto=trim($backto);
	if ($backto=="") {
		if ($memberloginthengoto=="Homepage") {
			redir("$dcrURL",1);
		} else {
			redir("mainadmin.php",1);
		}
	} else {
			redir(urldecode($backto),1);
	}
		echo "Please wait.........";
}
?>