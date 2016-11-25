<?php 
function form_member_login($icon="yes") {
	global $dcr;
	global $backto;
	global $_memid;
	global $dcrURL;
	global $_COOKIE;
	global $_TBWIDTH;
	//printr($_COOKIE);
	//global $_POST;
	//printr($_POST);

$htmlc=barcodeval_get("webpage-o-memberloginformhtml");
$htmlc=trim($htmlc);
$htmlc=stripslashes($htmlc);
$htmlc=str_webpagereplacer($htmlc);
if ($htmlc!="") {
	 echo "<center><br />$htmlc</center>";
}

?><table width = "<?php  echo $_TBWIDTH;?>" align=center border = 0 cellspacing = "0" cellpadding = "0" align = "center"  >

<TR valign=top>
<?php  if ($icon=="yes") {?>
	<TD align=right valign=top style="padding-right: 20; padding-left:20"><img src="<?php  echo $dcrURL?>neoimg/lock.png" width=150></TD>
<?php  }?>
	<TD width=700 align=left>


<table width = "600" border = "0" cellspacing = "1" cellpadding = "3" bgcolor=e2e2e2 class=table_border>
<form action ="/<?php echo $dcr;?>/member/login.php" method = post name = a style = "MARGIN: 0px"><INPUT TYPE="hidden" NAME="backto" value="<?php echo $backto;?>">
			<tr valign=top>
				<td align = "right" width = "200">
					<b><font face = "Verdana, Arial, Helvetica, 
sans-serif" size = "2"> <?php  echo getlang("รหัสสมาชิก::l::Member barcode"); ?> : </font></b></td>
				<td >
<?php  if ($_memid!="") {
	$tmpdsp=get_member_name($_memid);
	echo "<B>".getlang("คุณอยู่ในสถานะล็อกอินอยู่แล้ว::l::ALREADY LOGED IN").":</B> $tmpdsp<BR>
	<FONT class=smaller2>".getlang("หากคุณไม่ใช่ $tmpdsp กรุณาล็อกอินด้วยข้อมูลของคุณ::l::If you are not $tmpdsp Please login with your information")."</FONT><BR>";
}?>	
					<input ID = "FC" type = "text" name = "useradminidx" size = "30" class = "unnamed1asd" autocomplete=OFF
					value="<?php echo  $_COOKIE["lastmemberloginid"];?>" tabindex=1
					>
					<label class=smaller2 ><INPUT style="border-width:0" TYPE="checkbox" value='yes' NAME="rememberusername" 
					<?php  if ($_COOKIE["lastmemberloginid"]!="") {
						echo "  checked " ;
					}?>> <?php  echo getlang("จำ::l::remember");?></label>
					<?php 
if (barcodeval_get("webpage-o-canmemberloginbyemail")=="yes") {
	echo "<FONT class=smaller2><BR>".getlang("คุณสามารถใช้อีเมล์ของคุณเป็นรหัสสมาชิกได้::l::You can use your email address as loginid")."</FONT>";
}
?>
					</td>
			</tr>
			<tr>
<SCRIPT LANGUAGE = "JavaScript">
<!--
getobj('FC').focus()
//-->
</SCRIPT>
				<td align = "right" >
					<b><font face = "Verdana, Arial, Helvetica, 
sans-serif" size = "2"><?php  echo getlang("รหัสผ่าน::l::Password"); ?>  : </font></b></td>
				<td >
				<input type = "password" name = "passwordadminx" size = "30" class = "unnamed1asd" tabindex=2></td>
			</tr>
			<tr align = "left">
				<TD></TD>
				<td>
					<b><input type = submit value = "<?php  echo getlang("เข้าสู่ระบบ::l::Login"); ?>" name = "submit" class = "frmbtn" tabindex=3> 
					<input type = reset value = "<?php  echo getlang("ลบข้อมูล::l::Reset"); ?>"  name = "submit2" class = "frmbtn"> 
					<a href="<?php echo $dcrURL?>" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></a>
					<?php  if (strtolower(barcodeval_get("webpage-o-mem_forgotpwdoption"))=="yes" && strtolower(barcodeval_get("mailsetting-isenable"))=="yes")?>
					<a href="<?php echo $dcrURL?>member/forgotpassword.php" class="a_btn smaller2"><?php  echo getlang("ลืมรหัสผ่าน::l::Forgot password"); ?></a>
					</td>
			</tr>					
<?php 
if (barcodeval_get("memregist-isactive")=="yes") {	
?>			<tr align = "center">
				<TD colspan=2 class=table_td align=right><BR><TABLE align=right>
				<TR>
					<TD><?php 
	$gstr.="::<B>".getlang("สมัครสมาชิกออนไลน์::l::Online Registration")."</B>,$dcrURL/memregist.form.php,green,_self";
	$gstr.="::".getlang("สมาชิกใหม่::l::Accepted Registrant").",$dcrURL/memregist.granted.php,orange,_self";
	$gstr.="::".getlang("ผู้ถูกปฏิเสธการสมัคร::l::Denied records").",$dcrURL/memregist.denied.php,orange,_self";
	html_guidebtn($gstr);
	
?></TD>
				</TR>
				</TABLE>
	<?php 
if ( getval("_SETTING","useulibmconnect") == "yes" && barcodeval_get("activateulib-refcode")!="") {
	?><iframe src="<?php  echo getval("_SETTING","useulibmconnect_url");?>?REFCODE=<?php  echo barcodeval_get("activateulib-refcode")?>&REFURL=<?php  echo urlencode($dcrURL);?>" width=600 height=300></iframe><?php 
}	
?>
					</td>
			</tr>
<?php }?>
</form>		</table>

</TD>
</TR>
</TABLE>
<?php 

}
?>