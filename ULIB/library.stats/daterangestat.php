<?php 
include("../inc/config.inc.php");
html_start();
		$dts=form_pickdt_get("dts");
		$dte=form_pickdt_get("dte")+(60*60*24);
?><table border = 0 cellpadding = 0 width = 100% align = center cellspacing=2>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td colspan=2><b><?php  echo getlang("กรุณากำหนดช่วงเวลา::l::Please select date range.");?></b></td> </tr>
	<tr valign = "top">
	  <td colspan=2 align=center>
	  <?php  
	  if ($issave!="yes") {
		$dts=time()-(60*60*24*60);
		$dte=time();
	  }
	  echo getlang("เริ่มจาก::l::From");
	  form_pickdate("dts",$dts);
	  echo "<br>";
	  echo getlang("จนถึง::l::to");
	  form_pickdate("dte",$dte);
	  
	  ?><br>
	  <input type=submit value=' <?php  echo getlang("เริ่มดึงข้อมูล::l::Start generate"); ?> '></td>
</tr></form>
</table>
<?php 
function localdsp($txt,$num) {
	?><tr>
	<td width=300 align=right>&nbsp;<?php  echo getlang($txt);?> :</td><td> <?php  echo number_format(floor($num));?></td>
</tr><?php 
}
	if ($issave=="yes") {
		?><table>
<?php 

		//cir		
		$checkoutcounts=tmq("select count(id) as cc from stathist_checkout_member_libsite where  dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("การยืมทั้งหมด::l::All Checkout",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from checkout_log where  edt>$dts and edt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("การคืนทั้งหมด::l::All Checkin",$checkoutcounts);

		$checkoutcounts=tmq("select count(UserAdminID) as cc from member where  dtadd>$dts and dtadd<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("การสมัครสมาชิก::l::New member",$checkoutcounts);

		$checkoutcounts=tmq("select count(UserAdminID) as cc from member where  lastmoddt>$dts and lastmoddt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("อัพเดทข้อมูลสมาชิก::l::Update member",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from media_edittrace where edittype like 'add new bib%' and dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("เพิ่ม Bib ใหม่::l::New Bib",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from media_edittrace where edittype like 'add item bc%' and dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("เพิ่ม item ใหม่::l::New item",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from stathist_ms_member_ms where dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("ระบบประตูทางเข้า::l::Entrance",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from stathist_used_shelf_bib where dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("การใช้ในห้องสมุด::l::Use inside Lib.",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from stathist_librarian_login_ip where dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("เจ้าหน้าที่ห้องสมุดล็อกอิน::l::Librarian Login",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from stathist_viewbib_bib_type where dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("แสดงทรัพยากรทางหน้าเว็บ::l::Web view resources",$checkoutcounts);

		$checkoutcounts=tmq("select count(id) as cc from fine where dt>$dts and dt<=$dte ",false);
		$checkoutcounts=tfa($checkoutcounts);
		$checkoutcounts=$checkoutcounts[cc];
		localdsp("จำนวนครั้งการมีค่าปรับ::l::Fines records",$checkoutcounts);

?>
</table><?php 
	}
?>