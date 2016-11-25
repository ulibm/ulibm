<?php 
include("cfg.inc.php");
$now=time();
/*
if ($_sessiud=="") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("กรุณาล็อกอินก่อน");
	//-->
	</SCRIPT><?php 
	die;
}
*/

if ($mode=="saveall") {
	tmq("update acqn_sub set stat='$stat' where pid='$pid' ");
	echo "saveall=done";
	?><script type="text/javascript">
	<!--
		top.location="sub.php?pid=<?php  echo $pid; ?>";
	//-->
	</script><?php 
	$s=tmq("select * from acqn_sub set stat='$stat' where pid='$pid'");
	while ($r=tfa($s)) {
		tmq("insert into acqn_sub_clog set subid='$r[id]',stat='$stat',dt='$now' ");
	}
	die;
}
tmq("update acqn_sub set stat='$stat' where id='$id' ");
tmq("insert into acqn_sub_clog set subid='$id',stat='$stat',dt='$now' ");
?>done=true