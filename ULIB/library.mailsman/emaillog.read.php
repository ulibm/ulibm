<?php 
include("../inc/config.inc.php");
html_start();// พ

$m=tmq("select * from email_log where  id='$read' ");
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