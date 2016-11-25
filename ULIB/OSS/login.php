<?php 
include("../inc/config.inc.php");
//head();

html_start();
pagesection("Logging in");
$now=time();

$chk=tmq("select * from oss_mem where cardid='$idcard' ");
if (tmq_num_rows($chk)!=1 || strlen($idcard)<13) {
   html_dialog("ผิดพลาด","ไม่พบรหัสประจำตัวประชาชนที่คุณกรอก");
   ?><center>
   <a href="newuser.php?dest=<?php  echo $dest?>" class=a_btn><?php  echo getlang("สมัครใหม่ / ลองล็อกอินอีกครั้ง::l::Register/Try again")?></a>
   <a href="index.php" class=a_btn><?php echo getlang("กลับหน้าหลัก::l::Back to home")?></a>
   </center><?php 
   die;
}
?><center><?php 
$chk=tfa($chk);
if ($chk[email]==$email) {
echo getlang("การล็อกอินสำเร็จ กรุณารอสักครู่::l::Login success, please wait");
sessionval_set("ossmemid",$idcard);
sessionval_set("idcard",$idcard);
sessionval_set("email",$email);

redir("$dest.php",1);



} else {
   html_dialog(getlang("ผิดพลาด::l::Error"),getlang("อีเมล์หรือรหัสประจำตัวประชาชนผิด::l::Invalid Email addrress or invalid ID Card Number"));
}
   ?><center>
   <a href="newuser.php?dest=<?php  echo $dest?>" class=a_btn><?php  echo getlang("สมัครใหม่ / ลองล็อกอินอีกครั้ง::l::Register/Try again")?></a>
   <a href="index.php" class=a_btn><?php echo getlang("กลับหน้าหลัก::l::Back to home")?></a>
   </center><?php 
?>