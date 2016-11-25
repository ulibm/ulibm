<?php 
	; 
		set_time_limit(0);		

        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_memupdate";
        mn_lib();
			pagesection(getlang("อัพเดทข้อมูลสมาชิก::l::Update Member Records"));
//printr($_POST);
?><BR><CENTER><B><?php  echo getlang("เริ่มทำการอัพเดทข้อมูลสมาชิก::l::Start Update"); ?> ...</B></CENTER>
<BR>
<CENTER><?php 

	$mema=explode(",","barcode,name,prefix,address,password,email,tel");
	@reset($mema);
	while (list($k,$v)=each($mema)) {
		for ($subi=1;$subi<=5; $subi++) {
			$thisvtmp=$_POST["$v"."$subi"];
			barcodeval_set("importupdatememory-member-".trim($v," ][")."$subi",$thisvtmp);
		}
	}
	$s=tmq("select * from member_customfield where lower(isshow)='yes' or fid='FP' order by fid ");
   while ($r=tfa($s)) {
      $v=$r[fid];
		$thisvtmp=$_POST["cust"]["$v"];
		//echo "set[importupdatememory-member-$v]=$thisvtmp;";
		barcodeval_set("importupdatememory-member-$v",$thisvtmp);
   }
	//die;
$s=tmq("select * from importer_memupdate_tmp ");
$Stime=time();
$i=0;
$e=0;
$now=time();
while ($r=tmq_fetch_array($s)) {
	//printr($r);die;
	$updatesome=false;
	$r[SPACE]=" ";

	$barcode="$r[$barcode1]$r[$barcode2]$r[$barcode3]$r[$barcode4]$r[$barcode5]";
	$name="$r[$name1]$r[$name2]$r[$name3]$r[$name4]$r[$name5]";
	$prefix="$r[$prefix1]$r[$prefix2]$r[$prefix3]$r[$prefix4]$r[$prefix5]";
	$address="$r[$address1]$r[$address2]$r[$address3]$r[$address4]$r[$address5]";
	$password="$r[$password1]$r[$password2]$r[$password3]$r[$password4]$r[$password5]";
	$email="$r[$email1]$r[$email2]$r[$email3]$r[$email4]$r[$email5]";
	$tel="$r[$tel1]$r[$tel2]$r[$tel3]$r[$tel4]$r[$tel5]";
	$schk=tmq("select UserAdminID from member where UserAdminID='$barcode' ");
	//echo "[$r[$name2]$name]";
	if (tmq_num_rows($schk)==0 || trim($barcode)=="") {
		echo "<FONT COLOR=#737373>ทำการข้ามรายการ [$barcode], บาร์โค้ดเป็นค่าว่างง หรือ ไม่พบสมาชิก</FONT><BR>";
		$e++;
	} else {
		$sql="update member set
		lastmoddt='$now',
		";
		if ($prefix!="") {
		 $sql.="prefi ='$prefix',"; $updatesome=true;
		}
		if ($name!="") {
		 $sql.="UserAdminName='$name',"; $updatesome=true;
		}
		if ($address!="") {
		 $sql.="address='$address',"; $updatesome=true;
		}
		if ($password!="") {
		 $sql.="password='$password',"; $updatesome=true;
		}
		if ($email!="") {
		 $sql.="email='$email',"; $updatesome=true;
		}
		if ($tel!="") {
		 $sql.="tel='$tel',"; $updatesome=true;
		}
		if ($tel!="") {
		 $sql.="tel='$tel',"; $updatesome=true;
		}
		$scust=tmq("select * from member_customfield where lower(isshow)='yes' or fid='FP' order by fid ");
		$sqlcust="";
		while ($rcust=tfa($scust)) {
			$tmpcust="";
				$tmpcust.=$r[$cust[$rcust[fid]]];

			//echo "[$tmpcust]";
			if (trim($tmpcust)!="") {
				$sqlcust.=", $rcust[fid]='".addslashes($tmpcust)."'"; $updatesome=true;
			}
			//printr($_POST);
		}
		$sqlcust=ltrim($sqlcust," ,");
		$sql=$sql." ".$sqlcust ;
			//die($sql);
		$sql=trim($sql,", ");
		$sql.=" where UserAdminID='$barcode' ";
		if ($updatesome==true) {
	     	$i++;
   		//echo $sql;die;
   		tmq($sql);
		}
	}
}
$Etime=time();

?></CENTER>
<BR><CENTER>
<B><?php  echo getlang("ผลการอัพเดท::l::Update result"); ?></B><BR><?php  echo getlang("สำเร็จ::l::Success"); ?> 
<?php  echo number_format($i);?> <?php  echo getlang("รายการ โดยใช้เวลา::l::records in"); ?>  <?php  echo number_format(($Etime-$Stime));?> <?php  echo getlang("วินาที::l::seconds"); ?> (<?php  echo getlang("ผิดพลาด::l::Error"); ?>  <?php  echo number_format($e);?> <?php  echo getlang("ครั้ง::l::times"); ?>)<BR>
<BR><BR>
*<?php  echo getlang("หากมีการผิดพลาด ข้อความรายละเอียดความผิดพลาดจะแสดงด้านบน::l::If any error occored, error detail wil shown above."); ?></CENTER>

<BR>
<BR><BR>
<?php  foot();
?>