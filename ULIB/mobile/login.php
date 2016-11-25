<?php include("../inc/config.inc.php");
include("func.php");

if ($_memid!="") {
	redir("index.php");
}

$user_id=ChkLoginAdminmember($useradminidx, $passwordadminx);
	if ($user_id == false) {
		//head();
		//form_member_login();
		include("html.start.php");
		include("html.loginform.php");
		echo "<center><font face ='ms sans serif' size =2 color = red>";
		echo ("Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง");
		echo "</font></center>";
		//foot();
		include("html.foot.php");
		die;
	} else {
		//$loginadmin="true";
		//$Level=$user_id;
		;
		/////////////เริ่มสถิติแบบสมาชิก
		$sql3="SELECT *  FROM member where UserAdminID='$useradminidx'"; //หา old data
		//echo $sql3; 
		$result3=tmq($sql3);
		if (tmq_num_rows($result3)==1) {
			$row3=tmq_fetch_array($result3);
		} elseif (barcodeval_get("webpage-o-canmemberloginbyemail")=="yes") {
			$sql3="SELECT *  FROM member where email='$useradminidx'"; //หา old data
			//echo $sql3; 
			$result3=tmq($sql3);
			$row3=tmq_fetch_array($result3);
		}
		//$oldc = $row3[room];
		//$mstat = $row3[type];
		//$passwordadmin=$row3[type];
		$_memid=$user_id;
		ulibsess_register("_memid");
		member_log($_memid,"login");

statordr_add("memberlogin_member",$_memid);	
stat_add("memberlogin_membertype",$row3[type]);
$memberloginthengoto=barcodeval_get("webpage-o-memberloginthengoto");
		redir("index.php#memberloginform",1);
		echo "Please wait.........";
   }

   ?>