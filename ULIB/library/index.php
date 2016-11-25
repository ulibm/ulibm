<?php 

    ;

	include ("../inc/config.inc.php");

	if (loginchk_lib("check")) {
		redir("mainadmin.php");
		die;
	}
	$prevlang=$_SESSION[lang_control_val];

    session_unset($useradminid, $passwordadmin, $loginadmin, $Level);


	$lang_control_val=$prevlang;
	ulibsess_register("lang_control_val");


	head();

	?><BR><?php 
		pagesection("ระบบเจ้าหน้าที่ห้องสมุด::l::Librarian system","login","#333300");
		form_lib_login();
		foot();
?>
