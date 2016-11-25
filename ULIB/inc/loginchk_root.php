<?php 
function loginchk_root() {
	global $loginadmin;
	global $Level;

	if ($loginadmin != true || $Level != "Root")
        {
        form_root_login();
        echo "<center><font face ='ms sans serif' size =2 color = red>";
        echo getlang("Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง::l::Login or Password is incorrect, please try again.");
        echo "</font></center>";
		die;
        }
}
?>