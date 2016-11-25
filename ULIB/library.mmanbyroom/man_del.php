<?php 
    ;
	include ("../inc/config.inc.php");// พ
if ($issave=="yes") {

$s=tmq("select * from member where room ='$ID'");
while ($r=tfa($s)) {
   tmq("insert into member_bin SELECT NULL,UserAdminID,UserAdminName,email,descr,type,address,address2,tel,prefi,dat,mon,yea,room,major,libsite,credit FROM `member` WHERE UserAdminID='$r[UserAdminID]'") ;  
}


	tmq("delete from member

	where room='$ID'
	");
	redir("media_type.php");
	die;
}
?>