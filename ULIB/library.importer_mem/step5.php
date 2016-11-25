<?php 
	; 
		
		set_time_limit(0);		

        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_mem";
        mn_lib();
			pagesection(getlang("นำเข้าข้อมูลสมาชิก::l::Import Member Records"));
//printr($_POST);
?><BR><CENTER><B><?php  echo getlang("เริ่มทำการนำเข้าข้อมูลสมาชิก::l::Start import"); ?> ...</B></CENTER>
<BR>
<CENTER><?php 
$mem_type=barcodeval_get("importer_mem-mem_type");
$to_room=barcodeval_get("importer_mem-to_room");
$libsite=barcodeval_get("importer_mem-libsite");

	$mema=explode(",","barcode,name,prefix,address,password,email,tel");
	@reset($mema);
	while (list($k,$v)=each($mema)) {
		for ($subi=1;$subi<=5; $subi++) {
			$thisvtmp=$_POST["$v"."$subi"];
			barcodeval_set("importmemory-member-".trim($v," ][")."$subi",$thisvtmp);
		}
	}
	//die;
$s=tmq("select * from importer_mem_tmp ");
$Stime=time();
$i=0;
$e=0;
while ($r=tmq_fetch_array($s)) {
	//printr($r);die;
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
	if (tmq_num_rows($schk)!=0 || trim($barcode)=="" || trim($name)=="") {
		echo "<FONT COLOR=#737373>ทำการข้ามรายการ [$barcode-$name], บาร์โค้ดซ้ำหรือเป็นค่าว่าง หรือ ชื่อสมาชิกเป็นค่าว่าง</FONT><BR>";
		$e++;
	} else {
		$i++;
		$sql="insert into member set
		UserAdminID='$barcode',
		UserAdminName='$name',
		prefi ='$prefix',
		address='$address',
		password='$password',
		email='$email',
		tel='$tel',
		type='$mem_type',
		room='$to_room',
		libsite='$libsite'
		";
		$scust=tmq("select * from member_customfield where lower(isshow)='yes' or fid='FP' order by fid ");
		while ($rcust=tfa($scust)) {
			$tmpcust="";
				$tmpcust.=$r[$cust[$rcust[fid]]];

			//echo "[$tmpcust]";
			if (trim($tmpcust)!="") {
				$sql.=", $rcust[fid]='".addslashes($tmpcust)."'";
			}
			//printr($_POST);
		}
			//die($sql);
		$sql=rtrim($sql,",");
		tmq($sql);
	}
}
$Etime=time();

?></CENTER>
<BR><CENTER>
<B><?php  echo getlang("ผลการนำเข้า::l::Import result"); ?></B><BR><?php  echo getlang("นำเข้าสำเร็จ::l::Success"); ?> 
<?php  echo number_format($i);?> <?php  echo getlang("รายการ โดยใช้เวลา::l::records in"); ?>  <?php  echo number_format(($Etime-$Stime));?> <?php  echo getlang("วินาที::l::seconds"); ?> (<?php  echo getlang("ผิดพลาด::l::Error"); ?>  <?php  echo number_format($e);?> <?php  echo getlang("ครั้ง::l::times"); ?>)<BR>
<BR><BR>
*<?php  echo getlang("หากมีการผิดพลาด ข้อความรายละเอียดความผิดพลาดจะแสดงด้านบน::l::If any error occored, error detail wil shown above."); ?></CENTER>

<BR>
<BR><BR>
<?php  foot();
?>