<?php 
;
include("inc/config.inc.php");
include("./index.inc.php");
head();
mn_web("contact");
pagesection(" คำถาม ข้อเสนอแนะ::l::Contact Librarian");
//html_dialog("",getlang("การส่งข้อความผ่านระบบติดต่อบรรณารักษ์เป็นการสื่อสารทางเดียว และมีเฉพาะบรรณารักษ์จะสามารถอ่านข้อความได้ หากต้องการการโต้ตอบ กรุณาโพสท์ข้อความทางเว็บบอร์ดแทน::l::Sending message with contact form is a one-way communication, if need response please use webboard"));
?><table width="<?php echo $_TBWIDTH;?>" align=center><tr><td><?php
quickeditwebtext("homepagecontactform");
?></td></tr></table><BR>
<div align = "center">
<table width = "<?php  echo $_TBWIDTH;?>" border = "0" cellspacing = "0" cellpadding = "0">
<tr valign = "top">
<td>

<form name = "form1" method = "post" action = "addcontact.php" onsubmit = "return chk(this)">
<table width = "780" border = "0" cellspacing = "1" cellpadding = "4" align = "center">
<tr bgcolor = "#e3e3e3">
<td width = "27%" valign = "top">
<font face = "MS Sans Serif" size = "2"><?php  echo getlang("ชื่อผู้ติดต่อ::l::Your name"); ?></font></td>
<td width = "73%">
<font face = "MS Sans Serif" size = "2"><input type = "text" name = "name" size = "30" class = "unnamed1"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
<td width = "27%" valign = "top">
<font face = "MS Sans Serif" size = "2"><?php  echo getlang("ข้อความของคุณ::l::Your message"); ?></font></td>
<td width = "73%">
<font face = "MS Sans Serif" size = "2">
<TEXTAREA NAME = "body" ROWS = "5" COLS = "70" class = "unnamed1"></TEXTAREA> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
<td width = "27%" valign = "top">
<font face = "MS Sans Serif" size = "2"><?php  echo getlang("อีเมล์ผู้ติดต่อ::l::Your email"); ?></font></td>
<td width = "73%">
<font face = "MS Sans Serif" size = "2"><input type = "text" name = "email" size = "30" value = "" class = "unnamed1"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
<td width = "27%" valign = "top"></td>
<td width = "73%"><?php 
	captcha_s();
?></td>
</tr>
<tr bgcolor = "#e3e3e3">
<td width = "27%" valign = "top">
<font face = "MS Sans Serif" size = "2"></font></td>
<td width = "73%">
<font face = "MS Sans Serif" size = "2"><input type = "submit" name = "Submit2" value = "<?php  echo getlang("ส่งข้อมูล::l::Send"); ?>" class = "unnamed2"> <input type = "reset" name = "Reset" value = "<?php  echo getlang("ลบข้อความ::l::Clear"); ?>" class = "unnamed2"><input type = "hidden" name = "sid" value = "<?php  echo $sid;?>"> <A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A> </font></td>
</tr>
</table>
<script language=JavaScript1.2>
function chk(wh){
pass=true;
//alert(wh.MAUTHOR.value);
//alert(wh.MTITLE.value);
//alert(wh.MCALLNUM.value);
//alert(wh.MSUBJECT.value);
//alert(wh.MDESCRIPTION.value);
//alert(wh.MRETYPE.value);
//alert(wh.MFACULTY.value=="");
if (wh.name.value==""||wh.body.value==""||wh.email.value=="") {
pass=false;
}
if (pass==false) {
alert("<?php  echo getlang("กรุณาใส่ข้อความให้ครบด้วยครับ::l::Please complete the form"); ?>");
return false;
}
return true;
}
</script>
</form>
<?php
quickeditwebtext("homepagecontactform-foot");

?>
</td>
</tr>
</table>

</div><?php foot();?>