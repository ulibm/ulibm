<?php  //พ
include("../inc/config.inc.php");
head();
$_REQPERM="mailsman";
if (!library_gotpermission($_REQPERM)) {
	die('_REQPERM $_REQPERM');
}

 if (barcodeval_get("mailsetting-isenable")!="yes") {
	die( "Email Module Disabled" );
 }

include("../inc/email/ini.php");

$sql ="select * from umail_que where status='wait' and setid='$setid'  limit 20" ;
$s=tmq($sql);

if (tmq_num_rows($s)==0) {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("Done");
		
	//-->
	</SCRIPT><?php 
	redir("index.php");
	die;
}

mn_lib();


$done=tmq("select * from umail_que where status<>'wait' and setid='$setid' ");
$done=tmq_num_rows($done);
$all=tmq("select * from umail_que where  setid='$setid' ");
$all=tmq_num_rows($all);

	?><BR><BR>
	<CENTER><?php 
	echo html_graph("V",$done,$all,20,500,"#3DB66D");
?><BR><?php  echo number_format($done)."/".number_format($all);?></CENTER>
	<?php 


$now=time();
while ($r=tmq_fetch_array($s)) {
	//printr($r);
	$mailres=umail_mail($r[email],$r[mail_title],$r[mail_body]);
	if ($mailres=="") {
		$mailres="error";
	}
	tmq("update umail_que set status='$mailres' where id='$r[id]'  ");

}
redir("send.php?setid=$setid",1);
foot();
?>