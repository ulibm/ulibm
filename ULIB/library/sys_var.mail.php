<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_varmail";
        mn_lib();
				//include("sys_var.inc.php");

if ($issave=="yes") {
	tmq("delete from barcode_valmem;");
	barcodeval_set("mailsetting-isenable",addslashes($isenable));			
	barcodeval_set("mailsetting-ReturnPath",addslashes($ReturnPath));			
	barcodeval_set("mailsetting-Organization",addslashes($Organization));			
	barcodeval_set("mailsetting-from",addslashes($from));			
	barcodeval_set("mailsetting-attatchline",addslashes($attatchline));			
	barcodeval_set("mailsetting-mailmodefunction",addslashes($mailmodefunction));			
	barcodeval_set("mailsetting-mailsmtp",addslashes($mailsmtp));			
	barcodeval_set("mailsetting-mailsmtpu",addslashes($mailsmtpu));			
	barcodeval_set("mailsetting-mailsmtpp",addslashes($mailsmtpp));			
	barcodeval_set("mailsetting-mailsmtpport",addslashes($mailsmtpport));			
	barcodeval_set("mailsetting-sendmail_path",addslashes($sendmail_path));			
	barcodeval_set("mailsetting-sendmail_autocc",addslashes($sendmail_autocc));			
	barcodeval_set("mailsetting-mailsystem",addslashes($mailsystem));			
	barcodeval_set("mailsetting-centralurl",addslashes($centralurl));			
}

?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-Mail::l::System variables-Mail"));

?><table border = 0 cellpadding = 0 width = 900 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 
  <tr valign = "top">
	<td class=table_head width=200> <?php  echo getlang("เปิดใช้ระบบเมล์ ::l::Enable Mail Module");?></td>
  <td  align=center class=table_td><?php  form_quickedit("isenable",barcodeval_get("mailsetting-isenable"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Return-Path::l::Return-Path");?> (Reply-to)</td>
  <td  align=center class=table_td><?php  form_quickedit("ReturnPath",barcodeval_get("mailsetting-ReturnPath"),"text"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Organization::l::Organization");?></td>
  <td  align=center class=table_td><?php  form_quickedit("Organization",barcodeval_get("mailsetting-Organization"),"text"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Organization Email::l::Organization Email");?> (From-Email)</td>
  <td  align=center class=table_td><?php  form_quickedit("from",barcodeval_get("mailsetting-from"),"text"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("Attatch line::l::Attatch line");?></td>
  <td  align=center class=table_td><?php  form_quickedit("attatchline",barcodeval_get("mailsetting-attatchline"),"longtext"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("CC หาอีเมล์นี้อัตโนมัติทุกเมล์::l::CC to this mail every mail");?></td>
  <td  align=center class=table_td><?php  form_quickedit("sendmail_autocc",barcodeval_get("mailsetting-sendmail_autocc"),"text"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("รูปแบบระบบเมล์ ::l::Mail System");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mailsystem",barcodeval_get("mailsetting-mailsystem"),"list:local,central"); ?><br>
  <?php  echo getlang("สำหรับแบบ Central <b>จะต้อง</b>ลงทะเบียนโปรแกรม ULibM ก่อน::l::For type &quot;Central&quot; for <b>registered</b> ULibM only"); ?></td>
 </tr>

<tr valign = "top">
	<td class=table_td colspan=2> 
	<table width=900>
	<tr>
		<td colspan=2 class=table_head><?php  echo getlang("การตั้งค่าสำหรับระบบเมล์แบบ Local::l::Settings for Mail System &quot;Local&quot;");?></td>
	</tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ฟังก์ชันการส่ง ::l::Function for mail");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mailmodefunction",barcodeval_get("mailsetting-mailmodefunction"),"list:mail,smtp"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head width=360> <?php  echo getlang("Mail SMTP (เซิร์ฟเวอร์วินโดวส์)::l::Mail SMTP (Windows Sv.)");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mailsmtp",barcodeval_get("mailsetting-mailsmtp"),"text"); ?><br>
  Port <?php  form_quickedit("mailsmtpport",barcodeval_get("mailsetting-mailsmtpport"),"number"); ?> <br>
  User <?php  form_quickedit("mailsmtpu",barcodeval_get("mailsetting-mailsmtpu"),"text"); ?> <br>
  Password <?php  form_quickedit("mailsmtpp",barcodeval_get("mailsetting-mailsmtpp"),"text"); ?>
  <BR>
  <?php  echo getlang("ปล่อยว่างเพื่อใช้ค่าเริ่มต้นของเซิร์ฟเวอร์::l::Left blank to use server's default.");?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("Sendmail Path (เซิร์ฟเวอร์ Linux)::l::Sendmail Path (Linux Sv.)");?></td>
  <td  align=center class=table_td><?php  form_quickedit("sendmail_path",barcodeval_get("mailsetting-sendmail_path"),"text"); ?><BR>
  <?php  echo getlang("ปล่อยว่างเพื่อใช้ค่าเริ่มต้นของเซิร์ฟเวอร์::l::Left blank to use server's default.");?></td>
 </tr>
	</table>
	</td>
 </tr>

<tr valign = "top">
	<td class=table_td colspan=2> 
	<table width=900>
	<tr>
		<td colspan=2 class=table_head><?php  echo getlang("การตั้งค่าสำหรับระบบเมล์แบบ Central::l::Settings for Mail System &quot;Central&quot;");?></td>
	</tr>
	
<tr valign = "top">
	<td class=table_head width=360> <?php  echo getlang("Mail Server URL");?></td>
  <td  align=center class=table_td><?php  form_quickedit("centralurl",barcodeval_get("mailsetting-centralurl"),"text"); ?></td>
 </tr>
	</table>
	</td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>