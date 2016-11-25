<?php 
;
      include("inc/config.inc.php");
	   include("./index.inc.php");
	  head();
		mn_web('memregist');
		
		pagesection(getlang("รับสมัครสมาชิกออนไลน์::l::Online Registration"));

		captcha_e();
		$UserAdminName=addslashes(trim($UserAdminName));
		$Password=addslashes(trim($Password));
		$prefi=addslashes(trim($prefi));
		$email=addslashes(trim($email));
		$tel=addslashes(trim($tel));
		$descr=addslashes(trim($descr));
		if ($UserAdminName=="" || $Password=="") {
			html_dialog("","Please enter name,password");
			die;
		}
		//
	if (barcodeval_get("memregist-restrictemail")=="yes") {
		if ($email=="") {
			die(getlang("กรุณากรอกอีเมล์::l::Please Enter Email"));
		}
		$chke=tmq("select * from member where email='$email'");
		if (tmq_num_rows($chke)!=0) {
			die(getlang("ขออภัย อีเมล์ $email ถูกใช้ไปแล้ว::l::Sorry, email $email registered."));
		}
		$chke=tmq("select * from webpage_memregist where email='$email'");
		if (tmq_num_rows($chke)!=0) {
			die(getlang("ขออภัย อีเมล์ $email ถูกใช้ไปแล้ว::l::Sorry, email $email registered."));
		}
	}
		//
	$c=tmq("select *,floor(substr(UserAdminID,3)) as usebc from member where UserAdminID like 'mr%' order by usebc desc");
	$c=tmq_fetch_array($c);
	//printr($c);
	//$newbc=substr($c[UserAdminID],2);
	$newbc=floor($c[usebc]);
	$newbc=$newbc+1;
	//
	$c=tmq("select *,floor(substr(UserAdminID,3)) as usebc  from webpage_memregist where 1 order by usebc desc");
	$c=tmq_fetch_array($c);
	//printr($c);
	//$newbcr=substr($c[UserAdminID],2);
	$newbcr=floor($c[usebc]);
	$newbcr=floor($newbcr);
	$newbcr=$newbcr+1;
	//
	//echo "[$newbcr/$newbc]";
	if ($newbcr>$newbc) {
		$usebc=$newbcr;
	} else {
		$usebc=$newbc;
	}
	$now=time();
	tmq("insert into webpage_memregist set 
	UserAdminName='$UserAdminName',
	Password='$Password',
	prefi='$prefi',
	tel='$tel',
	email='$email',
	descr='$descr',
	dt='$now',
	UserAdminID='mr$usebc'	
	");
 ?><SCRIPT LANGUAGE="JavaScript">
 <!--
	alert("รับข้อมูลเรียบร้อย กรุณารอผู้ดูแลเว็บไซต์ยืนยัน");
	self.location="<?php  echo $dcrURL;?>"
 //-->
 </SCRIPT>
<?php 
foot();
?>