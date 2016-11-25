<?php 
    ;
        // ตรวจสอบว่าเป็น Root Admin หรือไม่ 
            //เขียนข้อมูลลงฐานข้อมูล 
            include ("../inc/config.inc.php");
			html_start();
			loginchk_lib();
            echo $Sstr;
						if ($mid=="") {
							 die("mid not found");
						}
	?><!-- <?php 
tmq("ALTER TABLE  `member` ADD  `FP` LONGTEXT NOT NULL ;");
?> --><?php 
		if ($isaddcreditfee=="yes") {
				t("select","credit");
				t("from","member");
				t("where","UserAdminID","=","$mid");
				$old=t("e");
				$old=tfa($old);
				$new=floor($credit-$old[credit]);
				if ($new>0) {

					$feeyea=date("Y"); //XXX
					$feemon=date("m");
					$feedat=date("d");
					$now=time();
					t("insert","fine");
					t("set","memberId","=","$mid");
					t("set","topic","=","FEE: Add credit: $new credit (from $old[credit] to $credit).");
					t("set","fine","=","$new");
					t("set","dt","=","$now");
					t("set","lib","=","$useradminid");
					t("e");
				}
			}
			
			///

if ($deloldphoto=="yes") {
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		$target="$dcrs"."pic/$pref$mid$suff";
		echo ($target);
		unlink($target);
}


$newname=$_FILES['updatephoto']['name'];
$phoext=explode(".",$newname);
$phoext=$phoext[count($phoext)-1];
//echo "[$phoext]";
//printr($_POST);
//printr($_FILES);die;
if ($phoext!="") {
  if ($phoext!="jpg" && $phoext!="jpeg") {
  	 html_dialog("","อัพโหลดได้เฉพาะไฟล์ JPG เท่านั้น::l::Only JPG file");
  }
  
  if (strlen($_FILES['updatephoto']['tmp_name'])!=0) { 
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		$target="$dcrs/pic/$pref$mid$suff";
		//echo "[$target]";
     copy($_FILES['updatephoto']['tmp_name'], $target); 
		 fso_image_fixsize($target,$phoext,200);
  } else { 
     echo "Possible file upload attack. Filename: " . $_FILES['updatephoto']['name']; 
     echo "ท่านไม่ได้เลือกไฟล์";
  	   die;
  } 
}


			///
form_quickedit_memval();

$now=time();
t("update","member");
t("set","Password","=","$Password");
t("set","UserAdminName","=","$UserAdminName");
t("set","email","=","$email");
t("set","descr","=","$descr");
t("set","type","=","$type");
t("set","statusactive","=","$statusactive");
t("set","tel","=","$tel");
t("set","address","=","$address");
t("set","address2","=","$address2");
t("set","prefi","=","$prefi");
t("set","dat","=","$dat");
t("set","mon","=","$mon");
t("set","yea","=","$yea");
t("set","major","=","$major");
t("set","credit","=","$credit");
t("set","FP","=","$FP");
t("set","FP","=","$FP");
t("set","lastmoddt","=","$now");
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
t("where","UserAdminID","=","$mid");
$sql=t("g");
            if (tmq( $sql))
                {
                echo "<font face ='ms sans serif'  size ='3'>";
                echo "<b>Update Successfully</b>";
                echo "</font>";
	redir($dcrURL."library.mst/_print.temp.php?memberbarcode=$mid");

                }
            else
                {
                echo "<font face ='ms sans serif'  size ='3'>";
                echo "<b>Error </b> <br>Please Back  to check data.";
                echo "</font>" . tmq_error();
                echo "<form><font face='ms sans serif' size=-2><input type=button value=' < Back' onclick=history.back()></form>";
                }
            //} 
            echo $Estr;
?>