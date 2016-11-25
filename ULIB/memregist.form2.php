<?php  
;
      include("inc/config.inc.php");
	   include("./index.inc.php");
	  head();
		mn_web('memregist');
		
		pagesection(getlang("รับสมัครสมาชิกออนไลน์::l::Online Registration"));
 ?><TABLE class=table_border align=center width=700 cellpadding=2><FORM METHOD=POST ACTION="memregist.form3.php" onsubmit="return chk(this)">
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		function chk(wh) {
			if (wh.UserAdminName.value=="") {
				alert('Please Enter name');
				return false
			}
			if (wh.Password.value=="") {
				alert('Please Enter Password');
				return false
			}
			if (wh.Password.value!=wh.Password2.value) {
				alert('Please Enter same password');
				return false
			}
			return true;
		}
	//-->
	</SCRIPT>
 <TR>
	<TD class=table_head colspan=2><?php  
	echo getlang("กรุณากรอกข้อมูล::l::Please fill all form");
	?></TD>
 </TR>
 <TR>
	<TD class=table_head2><?php echo getlang("คำนำหน้า::l::Prefix");	?></TD>
	<TD class=table_td><?php  
	form_quickedit("prefi","นาย","list:นาย,นาง,นางสาว,เด็กชาย,เด็กหญิง"); 
	?></TD>
 </TR>
 <TR>
	<TD class=table_head2><?php echo getlang("ชื่อ-นามสกุลจริง::l::Name-Last name");	?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="UserAdminName" ID=UserAdminName autocomplete=off> *</TD>
 </TR>
 <TR>
	<TD class=table_head2><?php echo getlang("รหัสผ่านที่ต้องการใช้::l::Desired Password");	?></TD>
	<TD class=table_td><INPUT TYPE="password" NAME="Password" ID="Password"> *</TD>
 </TR>
 <TR>
	<TD class=table_head2><?php echo getlang("รหัสผ่าน (อีกครั้ง)::l::re-type Password");	?></TD>
	<TD class=table_td><INPUT TYPE="password" NAME="Password2" ID="Password2"> *</TD>
 </TR>
 <TR>
	<TD class=table_head2><?php echo getlang("เบอร์โทรศัพท์::l::Tel.");	?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="tel" autocomplete=off></TD>
 </TR>

 <TR>
	<TD class=table_head2><?php echo getlang("E-mail");	?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="email" autocomplete=off> <?php  
	if (barcodeval_get("memregist-restrictemail")=="yes") {
		echo "*";
	}
	?></TD>
 </TR>
 <TR>
	<TD class=table_head2><?php echo getlang(barcodeval_get("memregist-extfieldname"));	?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="descr" autocomplete=off></TD>
 </TR>
 <TR>
	<TD class=table_head2><?php echo getlang("Confirmation code");	?></TD>
	<TD class=table_td><?php captcha_s();?></TD>
 </TR>

  <TR>
	<TD class=table_head2 colspan=2><B><A HREF="<?php echo $dcrURL?>" class=a_btn><?php  
	echo getlang("ยกเลิก::l::Cancel");
	?></A></B> <INPUT TYPE="submit" value=" Submit "></TD>
 </TR>
 </FORM>
 </TABLE>

<?php  
foot();
?>