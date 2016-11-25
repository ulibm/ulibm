<center>
<div style="background-color: #c7c7c7; xwidth: 620px;
margin-top: 10px;
     -moz-border-radius: 20px;
    -webkit-border-radius: 20px;
    -khtml-border-radius: 20px;
    border-radius: 20px; max-width: 500px;
">
<form   data-ajax="false" action ="/<?php echo $dcr;?>/mobile/login.php" method = post  style = "MARGIN: 0px">

<table width = "100%" border = "0" cellspacing = "1" cellpadding = "3" bgcolor=e2e2e2 class=table_border>
			<tr valign=top>
				<td >	<b> <?php  echo trim(getlang("รหัสสมาชิก::l::Member barcode")); ?> : </b>
<?php  if ($_memid!="") {
	$tmpdsp=get_member_name($_memid);
	echo "<B>".trim(getlang("คุณอยู่ในสถานะล็อกอินอยู่แล้ว::l::ALREADY LOGED IN")).":</B> $tmpdsp<BR>
	<FONT class=smaller2>".trim(getlang("หากคุณไม่ใช่ $tmpdsp กรุณาล็อกอินด้วยข้อมูลของคุณ::l::If you are not $tmpdsp Please login with your information"))."</FONT>";
}?>	
					<input ID = "FC" type = "text" name = "useradminidx" size = "30" class = "unnamed1asd" autocomplete=OFF
					value="<?php echo  $_COOKIE["lastmemberloginid"];?>" tabindex=1
					>
					<?php 
if (barcodeval_get("webpage-o-canmemberloginbyemail")=="yes") {
	echo trim("".getlang("คุณสามารถใช้อีเมล์ของคุณเป็นรหัสสมาชิกได้::l::You can use your email address as loginid"));
}
?>
<br><b><?php  echo trim(getlang("รหัสผ่าน::l::Password")); ?>  : </b>
				<input type = "password" name = "passwordadminx" size = "30" class = "unnamed1asd" tabindex=2></td>
			</tr>
			<tr align = "left">
				<td>
					<input type = submit value = "<?php  echo trim(getlang("เข้าสู่ระบบ::l::Login")); ?>" name = "submit" class = "frmbtn" tabindex=3> 
					
					</td>
			</tr>					


		</table>
</form>
</div></center>
