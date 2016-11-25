<?php 
;
include("../inc/config.inc.php");
html_start();
$_REQPERM="checkoutrule";
$tmp=mn_lib();

	$s="select * from media_type where 1";
	if ($setforallresource=="yes") {
	
	} else {
		$s.=" and code='$MDTYPE'  ";
	}
    $s=tmq("$s");
	while ($r=tfa($s)) {
		$MDTYPE=$r[code];
    // คำสั่งบันทึกลงฐานข้อมูล

   $sql56 = "select * from member_type";

   $result56 = tmq($sql56);

     $Num56 = tmq_num_rows($result56);

while($row56 = tmq_fetch_array($result56)){

	$hdescr = $row56[descr];

	$hid = $row56[type];

	$arr = get_defined_vars();

	//echo $arr["CHECKOUT_$hid"];

	$r_check = $arr["CHECKOUT_$hid"];

	$r_day = $arr["DAY_$hid"];

	$r_fine = $arr["FINE_$hid"];

	$r_fee = $arr["FEE_$hid"];
	$r_renew = $arr["RENEW_$hid"];
	$sql ="insert into checkout_rule (media_type,member_type,cancheckout,day,fine,fee,renew,libsite)";

	$sql.=" values ('$MDTYPE','$hid','$r_check','$r_day','$r_fine','$r_fee','$r_renew','$managing')";

	//     echo $sql;

	$sqldel = "delete from checkout_rule where media_type='$MDTYPE' and member_type='$hid'  and libsite='$managing' " ;

	if(tmq($sqldel)) {

		echo "ลบรายการเก่าเรียบร้อย";

	} else {

		echo "ไม่สามารถลบรายการเก่าได้";

		die($sqldel);

	}

	if(tmq($sql,false)) {

		echo "<div align=center><br><b>ทำการเพิ่มข้อมูลเรียบร้อยแล้ว</b><br></div>";

	} else {

		echo"<font face ='ms sans serif'  size ='3'>";

		echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";

		echo "</font>";

	}

} //วนรอบประเภทสมาชิก

	}
redir("media_type.php?managing=$managing",1);
?>