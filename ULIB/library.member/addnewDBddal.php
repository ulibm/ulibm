<?php  
    ;
include ("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
?><!-- <?php  
tmq("ALTER TABLE  `member` ADD  `FP` LONGTEXT NOT NULL ;");
?> --><?php  
$now=time();
     echo $Sstr;
    // คำสั่งบันทึกลงฐานข้อมูล
     if ($UserAdminID==""||$type==""||$UserAdminName=="") {
		html_dialog("","หมายเลขสมาชิก,ชื่อสมาชิกและประเภทสมาชิกต้องไม่เป็นค่าว่าง");
		die();
	 }
	t("select","*");
	t("from","member");
	t("where","UserAdminID","=","$UserAdminID");

	$chk=t(false);
	if (tnr($chk)!=0) {
		html_dialog("","บาร์โค้ด $UserAdminID ถูกใช้ไปแล้ว กรุณาตรวจสอบ<BR>กรุณาคลิก Back เพื่อลองอีกครั้ง");
		die();
	}

form_quickedit_memval();
t("insert","member");
t("set","UserAdminID","=","$UserAdminID");
t("set","Password","=","$Password");
t("set","UserAdminName","=","$UserAdminName");
t("set","email","=","$email");
t("set","descr","=","$descr");
t("set","type","=","$type");
t("set","library","=","$useradminid");
t("set","prefi","=","$pref");
t("set","tel","=","$tel");
t("set","address","=","$address");
t("set","address2","=","$address2");
t("set","dat","=","$dat");
t("set","mon","=","$mon");
t("set","yea","=","$yea");
t("set","room","=","$room");
t("set","major","=","$major");
t("set","libsite","=","$LIBSITE");
t("set","credit","=","$credit");
t("set","dtadd","=","$now");
t("set","FP","=","$FP");
t("set","cust01","=","$cust01");
t("set","cust02","=","$cust02");
t("set","cust03","=","$cust03");
t("set","cust04","=","$cust04");
t("set","cust05","=","$cust05");
t("set","cust06","=","$cust06");
t("set","cust07","=","$cust07");
t("set","cust08","=","$cust08");
t("set","cust09","=","$cust09");
t("set","cust10","=","$cust10");
t("set","cust11","=","$cust11");
t("set","cust12","=","$cust12");
t("set","cust13","=","$cust13");
t("set","cust14","=","$cust14");
t("set","cust15","=","$cust15");
t("set","cust16","=","$cust16");
t("set","cust17","=","$cust17");
t("set","cust18","=","$cust18");
t("set","cust19","=","$cust19");
t("set","cust20","=","$cust20");

$sql=t("g");


$newname=$_FILES['updatephoto']['name'];
$phoext=explode(".",$newname);
$phoext=$phoext[count($phoext)-1];
$phoext=strtolower($phoext);
//echo "[$phoext]";
if ($phoext!="") {
  if ($phoext!="jpg" && $phoext!="jpeg") {
  	 html_dialog("","อัพโหลดได้เฉพาะไฟล์ JPG เท่านั้น::l::Only JPG file");
  }
  
  if (strlen($_FILES['updatephoto']['tmp_name'])!=0) { 
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		$target="$dcrs/pic/$pref$UserAdminID$suff";
		//echo "[$target]";
     copy($_FILES['updatephoto']['tmp_name'], $target); 
		 fso_image_fixsize($target,$phoext,200);
		 
		 
		 $now=time();
tmq("insert into member_edittrace set 
login='$useradminid',
dt='$now',
memid='$UserAdminID',
edittype='upload photo   '   ");



  } else { 
     echo "Possible file upload attack. Filename: " . $_FILES['updatephoto']['name']; 
     echo "ท่านไม่ได้เลือกไฟล์";
  	   die;
  } 
} else {
	$suff=barcodeval_get("memberpic-local-suffix");
	$pref=barcodeval_get("memberpic-local-prefix");
	$target="$dcrs/pic/$pref$UserAdminID$suff";
	if (file_exists($target) && !is_dir($target)) {
		@unlink($target);
	} 
if (file_exists("./ulibcamcap-newmem/file/temp$useradminid.jpg")) {
	$suff=barcodeval_get("memberpic-local-suffix");
	$pref=barcodeval_get("memberpic-local-prefix");
	$target="$dcrs/pic/$pref$UserAdminID$suff";
	//echo "[$target]";
	@copy("./ulibcamcap-newmem/file/temp$useradminid.jpg", $target); 
	
			 $now=time();
tmq("insert into member_edittrace set 
login='$useradminid',
dt='$now',
memid='$UserAdminID',
edittype='upload photo by camera   '   ");


}

}


  if(tmq($sql)) {

			if ($isaddcreditfee=="yes") {
				$credit=floor($credit);
				if ($credit!=0) {
					t("insert","fine");
					t("set","memberId","=","$UserAdminID");
					t("set","topic","=","FEE: Add credit: $credit credit for new member.");
					t("set","fine","=","$credit");
					t("set","dt","=","$now");
					t("set","lib","=","$useradminid");
					t("e");
				}
			}

$now=time();
tmq("insert into member_edittrace set 
login='$useradminid',
dt='$now',
memid='$UserAdminID',
edittype='add new member'   ");


  echo"<font face ='ms sans serif'  size ='3'>";
	echo"<div align=center><br><b>ทำการเพิ่มข้อมูลเรียบร้อยแล้ว
</b><br></div>";
if ($isback=="on") {
	redir($dcrURL."library.member/addDBddal.php?fixtype=$type&fixdat=$dat&fixmon=$mon&fixyea=$yea&fixroom=$room&fixmajor=$major&");
} else {
	if ($remoteedit!="yes") {
		redir("DBddal.php",1);
	} else {
		redir($backto);
	}
}
 
       } else {
      echo"<font face ='ms sans serif'  size ='3'>";
		echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";
    	echo tmq_error() . "</font>";
	}
	echo $Estr;

  foot();
  ?>