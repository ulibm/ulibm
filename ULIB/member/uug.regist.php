<?php 
    ;
	include ("../inc/config.inc.php");

if ($_ISULIBMASTER=="yes") {
if ($issave=="yes") {
	tmq("insert into ulib_clientlogins set name='$name', email='$email', tel='$tel' ,address='$address',isallowed='no' ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("<?php  echo getlang("บันทึกข้อมูลเรียบร้อยแล้ว ทีมงานผู้พัฒนาจะติดต่อแจ้งรหัสผ่านกลับไปทางอีเมล์ในภายหลัง\\n กรุณาคลิก OK เพื่อกลับหน้าหลัก::l::Information saved, Developer team will send you password information via your email \\n click OK to return to homepage");?>");
		top.location="<?php  echo $dcrURL?>";
	//-->
	</SCRIPT><?php 
	die;
}
	head();
	mn_web("webpage");
	pagesection(getlang("สมัครสมาชิก UUG::l::UUG Registration"));
	?><form method="post" action="uug.regist.php">
	<input type="hidden" name="issave" value="yes">
		<table align=center width="<?php echo $_TBWIDTH?>">
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("ชื่อหน่วยงาน::l::Organization name");?></td>
		<td class=table_td><input type="text" name="name" size=40></td>
	</tr>
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("อีเมล์::l::Email");?></td>
		<td class=table_td><input type="text" name="email" size=25> *</td>
	</tr>
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("เบอร์โทรศัพท์::l::Tel.");?></td>
		<td class=table_td><input type="text" name="tel" size=25></td>
	</tr>
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("ที่อยู่::l::Address");?></td>
		<td class=table_td><textarea name="address" rows="4" cols="80"></textarea><br>
		<input type="submit" value=" ส่งข้อมูล "><br>
		<?php  echo getlang("หลังจากได้รับข้อมูล ทางทีมผู้พัฒนาจะทำการตรวจสอบและส่งรหัสล็อกอินและรหัสผ่านไปให้ทางอีเมล์ในภายหลัง::l::After recieve your request, developer team will send you an email about login infor mation");?></td>
	</tr>
	</table>
	</form><br><br><?php 
	foot();
} else {
	gen404();
}





?>