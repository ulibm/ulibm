<?php 
include("../inc/config.inc.php");
//print_r($_SERVER);


html_start();
//echo "<h2><center>ขออภัยครับ e-request กำลังอยู่ในระหว่างการทดสอบระบบ กรุณาทดลองใช้ภายหลังครับ<BR> 25 มีนาคม 2556</center></h2>"; die;

$x=Array();
$s=tmq("select * from media where id='$bibid' ");
$s2=tfa($s);
$x[tag100]=dspmarc(substr($s2[tag100],2));
$x[tag245]=dspmarc(substr($s2[tag245],2));
$x[tag344]=dspmarc(substr($s2[tag344],2));
$x[mat_id]=$bibid;
$x[bibid]=$bibid;

	/*
	echo $x[tag100]."<BR>";
	echo $x[tag245]."<BR>";
	echo $x[tag344]."<BR><BR><BR>";
	//echo "<font style='font-size:8px'>";
	//print_r($x);
	*/
	sessionval_set("landingdata",serialize($x));
	include("new.php");











;die;
?>