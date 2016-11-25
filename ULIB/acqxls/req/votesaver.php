<?php 
include("../../inc/config.inc.php");
$_sessiud=session_id();

if ($_sessiud=="") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("กรุณาล็อกอินก่อน");
	//-->
	</SCRIPT><?php 
	die;
}
$voted=tmq("select * from acqn_voted where memid='$_sessiud' and pid='$pid'  ");
$voted=tfa($voted);
$voted=$voted[data];
$voted=str_replace(",on-$votefor,",'',$voted);
$voted=str_replace(",off-$votefor,",'',$voted);
$voted=str_replace("---",'-',$voted);
if ($votetype=='on') {
	$voted.="-----,on-$votefor,";
}
if ($votetype=='off') {
	$voted.="-----,off-$votefor,";
}
echo $voted;
tmq("delete from acqn_voted where memid='$_sessiud' and pid='$pid'  ");
tmq("insert into acqn_voted set data='$voted' , memid='$_sessiud' , pid='$pid'");

?>done=true