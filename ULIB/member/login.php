<?php 
;
	include("../inc/config.inc.php");
	//session_destroy();
	if ($_ISULIBMASTER=="yes") {
		/// chk uug logins
		 $userSQL="Select * From ulib_clientlogins Where loginid='$useradminidx'  AND lower(isallowed) ='yes' ";
        $result=tmq($userSQL);
        $num=tmq_num_rows($result);

        $rs=tmq_fetch_array($result);
		//printr($_POST);
		if ($rs[passwd]!=$passwordadminx) {
			/*
			head();
			form_member_login();
			echo "<center><font face ='ms sans serif' size =2 color = red>";
			echo "Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง";
			echo "</font></center>";
			foot();
			die;*/
		} elseif ($num==1) { // uug ok
			tmq("update  ulib_clientlogins  set logincount=logincount+1 Where loginid='$useradminidx'  ");
			$_memid="uug:$useradminidx";
			ulibsess_register("_memid");
			$backto=trim($backto);
			if ($backto=="") {
				redir("$dcrURL",1);
			} else {
				redir(urldecode($backto),1);
			}
			die;
			}
		
	} //end uug login

   if (substr($useradminidx,0,5)=="ecard") {
      $ecardid=substr($useradminidx,5);
      $ecard=tmq("select * from ulibecard where id='$ecardid' ",false);
      if (tnr($ecard)!=0) {
         $ecard=tfa($ecard);
         $useradminidx=$ecard[memid];
      }
      //die;///
   }
   
   
	if ($rememberusername=="yes") {
		setcookie("lastmemberloginid",$useradminidx,time()+(60*60*24*30),"/$dcr/");
	} else {
		setcookie("lastmemberloginid",$useradminidx,time()-(60*60*24*30),"/$dcr/");
	}
	//
	$user_id=ChkLoginAdminmember($useradminidx, $passwordadminx);
	//echo "user_id=[$user_id]";
	if ($user_id == false) {
		head();
		form_member_login();
		echo "<center><font face ='ms sans serif' size =2 color = red>";
		echo "Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง";
		echo "</font></center>";
		foot();
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
		$LIBSITE=$row3[libsite];
		ulibsess_register("LIBSITE");
		ulibsess_register("_memid");
		member_log($_memid,"login");

statordr_add("memberlogin_member",$_memid);	
stat_add("memberlogin_membertype",$row3[type]);
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