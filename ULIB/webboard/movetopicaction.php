<?php 
include("./cfg.inc.php");
               
     head();

$ismanager=loginchk_lib("check");
if ($ismanager!=true) {
	die();
}

$now=time();
$sql2 ="SELECT *  FROM webboard_boardcate where id='$ID' "; 
$sql2=tmq($sql2);
if (tmq_num_rows($sql2)==0) {
	die("webboard_boardcate not found $ID");
}

tmq("update webboard_posts set boardid='$ID' where id='$TID' and nestedid=0 ");

?><CENTER><BR><BR><?php  echo getlang("ทำการย้ายสำเร็จแล้ว::l::Moved");?><BR>
<A HREF="index.php"><?php  echo getlang("ไปหน้าหลักเว็บบอร์ด::l::Go to webboard's home");?></A>
 - <A HREF="viewforum.php?ID=<?php  echo $ID;?>"><?php  echo getlang("ไปหน้าหัวข้อนี้::l::View this topic");?></A><BR></CENTER><?php 


foot();

?>