<?php 
include("../inc/config.inc.php");
html_start();// พ
$s=tmq("select * from member where UserAdminID='$_memid' ");
if (tnr($s)!=1) {
	html_dialog("","$_memid not found");
	die;
}
$s=tfa($s);
$m=tmq("select * from email_log where toemail='$s[email]' and id='$read' ");
if (tnr($m)!=1) {
	html_dialog("","message not found");
	die;
}
$m=tfa($m);
?><table align=center class=table_border cellpadding=0 cellspacing=0 border=0>
<tr>
	<td class=table_head><?php 
	echo stripslashes($m[subj]);
?></td>
</tr>
<tr>
	<td class=table_td align=left><?php 
	echo str_preformat(stripslashes($m[body]));
?></td>
</tr>
</table>