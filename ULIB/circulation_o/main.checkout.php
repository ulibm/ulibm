<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("main.inc.head.php");
?><BR>
<?php 
localheaddisplay("ให้ยืมวัสดุสารสนเทศ::l::Checkout items","darkblue");
$memberbarcode=trim($memberbarcode);

if ($memberbarcode=="") {
	localloadmember("none");
	include("main.checkout.1stform.php");
} else {
	//checkuser
	 $s=tmq("select * from member where UserAdminID='$memberbarcode' ");
	 if (tmq_num_rows($s)!=1) {
		 $s=tmq("select * from member where UserID01='$memberbarcode' ");
		 if (tmq_num_rows($s)==1) {
			 $s=tmq_fetch_array($s);
			 $memberbarcode=$s[UserAdminID];
			localloadmember($memberbarcode);
			include("main.checkout.2ndform.php");
			die;
		 }
		//localseterror("membernotfound",$memberbarcode);
		localloadmember($memberbarcode);
		include("main.checkout.1stform.php");		
		die;
	}
	localloadmember($memberbarcode);
	include("main.checkout.2ndform.php");
}
?>