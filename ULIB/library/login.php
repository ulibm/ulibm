<?php 
;
//  session_unset($useradminid,$passwordadmin,$loginadmin,$Level);
//include("../head.php");
    include("../inc/config.inc.php");
//print_r($_POST);
$ise=barcodeval_get("rootallowlibrarianlogin");

if ($ise=="no") {
	html_start();
	html_dialog("Block mode","ขณะนี้ ไม่อนุญาตให้เจ้าหน้าที่ห้องสมุดล็อกอินเข้าระบบ<BR>กรุณาติดต่อเจ้าหน้าที่สูงสุดของระบบ::l::Currently disallow librarian to login to system.<BR>Please contact your system administrator.");
	die;
}
	$libraryautologincookie=trim($_COOKIE[LIBAUTHC]);
	if ($cookielogin!="" && $libraryautologincookie!="") {
		$s=tmq("select * from library_cookielogin where dat='$libraryautologincookie' and loginid='$cookielogin' ",false);
		if (tmq_num_rows($s)==1) {
			$s=tmq("select * from library where UserAdminID='$cookielogin' ");
			filelogs("cookieautologin",print_r($_POST,true),"cookieautologin");
			$s=tmq_fetch_array($s);
			$useradminid=$cookielogin;
			$passwordadmin=$s[Password];
			$ipautologin_system="yes";
		}
	}
	$ipuse=trim($_SERVER[REMOTE_ADDR]);
	if ($ipuse==$refererip && $choosedid!="") {
		$s=tmq("select * from library where UserAdminID='$choosedid' and ipautologin='$ipuse' ");
		if (tmq_num_rows($s)==1) {
			filelogs("ipautologin",print_r($_POST,true),"ipautologin");
			$s=tmq_fetch_array($s);
			$useradminid=$choosedid;
			$passwordadmin=$s[Password];
			$ipautologin_system="yes";
		}
	}

     $user_id =ChkLoginLibrary($useradminid,$passwordadmin);
	// $useradminid=$useradminidx ."1";

     if($user_id == false)
         {
			 head();
       form_lib_login();
       echo "<center><font face ='ms sans serif' size =2 color = red class=stupidmenu>";
       echo getlang("Login หรือ Password ไม่ถูกต้อง หรือ ถูกระงับการล็อกอิน โปรดตรวจสอบอีกครั้ง::l::Incorrect Loginid or Password  or Loginid is disabled.");
       echo "</font></center>";
	   foot();
         }
  else{
		$loginadmin = true;
		$s=tmq("Select * From library Where UserAdminID='$useradminid' ");
		$s=tmq_fetch_array($s);
		$LIBSITE=$s[libsite];
		$lang_control_val=$s[autolang];

         $Level=$user_id;
         //;

		ulibsess_register("useradminid","loginadmin","Level","LIBSITE","lang_control_val");

		stathist_add("librarian_login_ip",$ipuse,$useradminid);	
	if ($s[defmenu]!="") {
		$homebtn=tmq("select * from library_modules where code='$s[defmenu]' ");
		$homebtn=tmq_fetch_array($homebtn);
		$homebtn[url]=str_replace('[dcr]',$dcrURL,$homebtn[url]);
		redir($homebtn[url]."?rnd=".randid(),1);
	} else {
		redir("mainadmin.php?firsttimemenu=yes&rnd=".randid(),0);
	}

        echo"Please wait.........";
		//echo   "   '$useradminid','$passwordadmin','$loginadmin','$Level'";
  }
 //การล็อกอินไม่ได้บางครั้งจะเกิดจากการที่บางภาพ เรียกโดยใช้ src=' ' แล้วมันจะโหลด ./index.php ขึ้นมาโดยอัตโนมัติ ทำให้ล็อกเอาท์ พอไปหน้าต่อไปมันก็จะบอกว่า ล็อกอินผิดพลาด

?>