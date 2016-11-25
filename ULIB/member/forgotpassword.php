<?php 
    ;
            include("../inc/config.inc.php");
           head();
		   mn_web("memforgotpassword");
		   pagesection(getlang("ลืมรหัสผ่าน::l::Forgot password"));

			?><form method="post" action="forgotpassword.php">
				<table width=600 align=center class=table_border>
			<tr>
				<td  class=table_td><?php  echo getlang("กรุณากรอกรหัสบาร์โค้ดห้องสมุด <strong>หรือ</strong> ชื่อและนามสกุลเต็ม และกดปุ่ม ส่งรหัสผ่าน::l::Please enter your library's barcode <strong>or</strong> your first name and last name then click retrieve password"); ?></td>
			</tr>
			<tr>
				<td  class=table_td><input type="text" name="enteredinfo" value="<?php  echo $enteredinfo;?>"> <input type="submit" value="<?php  echo getlang("ส่งรหัสผ่าน::l::Retrieve password");?>"> <a href="<?php echo $dcrURL?>" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></a></td>
			</tr>
			</table>
			</form>
			<center><?php 

if ($sendemailnow=="yes") {
		$s=tmq("select * from member where (UserAdminID='$poorbrainmember' )  and email<>'' ");
	if (tnr($s)==1) {
		$s=tfa($s);
$body="
Login information for member

Your name : $s[UserAdminName]
Barcode : $s[UserAdminID]
Password : $s[Password]

Library's Homepage: $dcrURL

this email sent by password retrieval system, for more information please contact librarian

";
		echo umail_mail($s[email],"Retrieve Library's Password",$body);
		$dspemail=$s[email];
		$dspemail=explode("@",$dspemail);
		$dspemail=$dspemail[1];

		html_dialog("Password Sent",getlang("รหัสผ่านถูกส่งไปยังอีเมล์ของคุณแล้ว ($dspemail)::l::Password was sent to your email address. ($dspemail)"));
	} else {
		html_dialog("error","member not found");
	}
}

			$enteredinfo=trim($enteredinfo);
if ($enteredinfo!="") {
	$s=tmq("select * from member where (UserAdminID='$enteredinfo' or UserAdminName ='$enteredinfo')  and email<>'' ");
	if (tnr($s)==1) {
		$s=tfa($s);
		html_dialog("Found",getlang("พบข้อมูลของคุณ ::l::Found record for ")." $s[UserAdminName] ($s[UserAdminID])");
		echo getlang("");
		$dspemail=$s[email];
		$dspemail=explode("@",$dspemail);
		$dspemail=$dspemail[1];
		?><center><form method="post" action="forgotpassword.php">
			<input type="hidden" name="poorbrainmember" value="<?php  echo $s[UserAdminID]?>">
			<input type="hidden" name="sendemailnow" value="yes"><br>
			<input type="submit" value="<?php  echo getlang("ส่งรหัสผ่านทางอีเมล์ (@$dspemail) ::l::Retrieve password by email (@$dspemail)");?>">
		</form></center><?php 
	} else {
		html_dialog("Not found",getlang("ไม่พบข้อมูล <br> ไม่มีข้อมูลตามที่คุณกรอก หรือ บัญชีผู้ใช้ของคุณไม่ได้บันทึกอีเมล์สำหรับกู้คืนรหัสผ่านไว้ <br>หากต้องการความช่วยเหลือกรุณาติดต่อเจ้าหน้าที่::l::Not found <br> No data in database match your information or no email address for retrieve password in your record <br> if need help please contact librarian"));
	}
}
?></center>
<?php 
foot();
?>