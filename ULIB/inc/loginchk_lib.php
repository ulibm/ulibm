<?php 
function loginchk_lib($mode="normal") {
	global $loginadmin;
	global $Level;
	global $_SESSION;
	//printr($_SESSION);
	if ($mode=="normal") {
		if ($loginadmin != true || $Level != "Library")
        {
		//session_destroy();
		head();
        form_lib_login();
        echo "<center><font face ='ms sans serif' size =2 color = red>";
        echo getlang("Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง::l::Login or Password is incorrect, please try again");
        echo "</font></center>";
		foot();
		die;
        }
	} else {
		if ($loginadmin != true || $Level != "Library") {
			return false;
		} else {
			return true;
		}
	}
}
?>