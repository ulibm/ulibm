<?php 
	include ("../inc/config.inc.php");
    $loginadmin=false;
	member_log($_memid,"logout");
    session_unset($_memid);
	//printr($_COOKIE);
	//die;
	redir("../index.php");// พ
?>