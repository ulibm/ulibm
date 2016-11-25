<?php 
    ;// พ
	include ("../inc/config.inc.php");
		if ($ID=="[EMPTY]") {
		 $ID="";
	}
if ($issave=="yes") {
$s=tmq("select * from member where libsite ='$ID'");
while ($r=tfa($s)) {
   tmq("insert into member_bin SELECT NULL,UserAdminID,UserAdminName,email,descr,type,address,address2,tel,prefi,dat,mon,yea,room,major,libsite,credit FROM `member` WHERE UserAdminID='$r[UserAdminID]'") ;  
}
	tmq("delete from member

	where libsite ='$ID'
	");
	redir("media_type.php");
	die;
}
?>