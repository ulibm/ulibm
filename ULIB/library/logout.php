<?php 
	include ("../inc/config.inc.php");// พ
    session_unset($useradminid, $passwordadmin, $loginadmin, $Level);
    ulibsess_unset("useradminid", "passwordadmin", "loginadmin", "Level");
    echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
?>