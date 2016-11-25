<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
$now=time();
pagesection(getlang("General Email Form"));
//int
if ($submitemail=="yes") {
	$res=umail_mail($dat_email,$dat_topic,$dat_body);
	//echo "res=[$res]";
	if ($res=="success") {
		html_dialog("Email Sent","Successfully sent &quot;$dat_topic&quot;to $dat_email ");
	} else {
		html_dialog("Error","Error Occured when sending  &quot;$dat_topic&quot; to $dat_email <br>$res");
	}
}
?><center>ในระบบ ULibM มีตัวเลือกสำหรับการส่งอีเมล์<br>
โมดูลนี้ช่วยให้สามารถส่งอีเมล์โดยการตั้งค่าพื้นฐานของระบบ
</center>
<form method="post" action="index.php">
	<table width=800 align=center class=table_border>
<tr>
	<td class=table_head width=300 >Email Subject</td>
	<td class=table_td><input type="text" name="dat_topic" style="width: 300px;" value="<?php  echo $dat_topic?>"></td>
</tr>
<tr>
	<td class=table_head width=300 >Recipient Email</td>
	<td class=table_td><input type="text" name="dat_email" style="width: 200px;" placeholder="name@domain.com" value="<?php  echo $dat_email?>"></td>
</tr>
<tr>
	<td class=table_head >Body</td>
	<td class=table_td><textarea name="dat_body" rows="5"  style="width: 300px;"><?php  echo $dat_body?></textarea></td>
</tr>
<tr>
	<td class=table_td colspan=2 align=center><input type="submit" value=" Send "></td>
</tr>
</table>
<input type="hidden" name="submitemail" value="yes">
</form>
<?php 
foot();
?>