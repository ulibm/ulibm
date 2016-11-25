<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
if (strtolower(trim(getval("_SETTING","memberbarcodehasspecialsign")))!="yes") {
	 $memberbarcode=str_replace("จ","0",$memberbarcode);
	 $memberbarcode=str_replace("ๅ","1",$memberbarcode);
	 $memberbarcode=str_replace("/","2",$memberbarcode);
	 $memberbarcode=str_replace("-","3",$memberbarcode);
	 $memberbarcode=str_replace("ภ","4",$memberbarcode);
	 $memberbarcode=str_replace("ถ","5",$memberbarcode);
	 $memberbarcode=str_replace("ุ","6",$memberbarcode);
	 $memberbarcode=str_replace("ึ","7",$memberbarcode);
	 $memberbarcode=str_replace("ค","8",$memberbarcode);
	 $memberbarcode=str_replace("ต","9",$memberbarcode);
}    
	 include("inc.php");
	 include("main.inc.head.php");
?><BR>
<?php 
localheaddisplay("ให้ยืมวัสดุสารสนเทศ::l::Checkout items","darkblue");
$memberbarcode=trim($memberbarcode);

   if (substr($memberbarcode,0,5)=="ecard") {
      $ecardid=substr($memberbarcode,5);
      $ecard=tmq("select * from ulibecard where id='$ecardid' ",false);
      if (tnr($ecard)!=0) {
         $ecard=tfa($ecard);
         $memberbarcode=$ecard[memid];
      }
      //die;///
   }
   
if ($memberbarcode=="") {
	localloadmember("none");
	include("main.checkout.1stform.php");
} else {
	//checkuser
	$firsttime="yes";
	if ($mediabarcode!="") {
      $firsttime="no";
	}
	 $s=tmq("select * from member where UserAdminID='$memberbarcode' ");
	 if (tmq_num_rows($s)!=1) {
		 $s=tmq("select * from member where UserID01='$memberbarcode' ");
		 if (tmq_num_rows($s)==1) {
			 $s=tmq_fetch_array($s);
			 $memberbarcode=$s[UserAdminID];
			localloadmember($memberbarcode,"no","$firsttime");
			include("main.checkout.2ndform.php");
			die;
		 }
		//localseterror("membernotfound",$memberbarcode);
		localloadmember($memberbarcode);
		include("main.checkout.1stform.php");		
		die;
	}
	localloadmember($memberbarcode,"no","$firsttime");
	include("main.checkout.2ndform.php");
}
?>
