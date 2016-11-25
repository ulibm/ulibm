<?php 
include("../inc/config.inc.php");
/*@tmq("ALTER TABLE  `member` ADD  `FP` LONGTEXT NOT NULL ;");
tmq("delete from  member_customfield where fid='FP' ");
tmq("insert into  member_customfield set
name='FingerPrint',
fid='FP',
ftype='longtext'
");
isshow='no',
usercanedit='no',*/
$s=tmq("select * from member where UserAdminID<>'' and FP<>'' ");
@unlink("data.txt");
while ($r=tmq_fetch_array($s)) { //printr($r);
	fso_file_write($dcrs."_fingerscan/data.txt","a+",$r[UserAdminID]."::l::".iconvutf($r[UserAdminName])."::l::".$r[FP]."
");
}
// พ 
?>OK