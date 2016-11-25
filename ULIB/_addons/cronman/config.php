<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
include("func.php");

$now=time();
?>
                <div align = "center">
<?php 
if ($issave=="yes") {
	$phppath=str_replace("\\","/",$phppath);
	$phppath=str_replace("//","/",$phppath);

	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\","\\\\",$phppath);
	
	$cronlogpath=str_replace("\\","/",$cronlogpath);
	$cronlogpath=str_replace("//","/",$cronlogpath);
	$cronlogcmd=str_replace("\\","/",$cronlogcmd);
	$cronlogcmd=str_replace("//","/",$cronlogcmd);

	barcodeval_set("addons-cronman-cronlogpath",addslashes($cronlogpath));
	barcodeval_set("addons-cronman-phppath",addslashes($phppath));
	barcodeval_set("addons-cronman-cronlogcmd",addslashes($cronlogcmd));
	barcodeval_set("addons-cronman-cronlogfilecmd",addslashes($cronlogfilecmd));
}
?><form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=30>
<tr valign = "top">
  <td width=50%><?php  echo getlang("PHP Path");?></td>
  <td width=50%><?php  form_quickedit("phppath",barcodeval_get("addons-cronman-phppath"),"text"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("path for log files");?></td>
  <td width=50%><?php  form_quickedit("cronlogpath",barcodeval_get("addons-cronman-cronlogpath"),"text"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("Command to get log");?></td>
  <td width=50%><?php  form_quickedit("cronlogcmd",barcodeval_get("addons-cronman-cronlogcmd"),"text"); ?></td>
 </tr>
    
<tr valign = "top">
  <td width=50%><?php  echo getlang("Command to get log file");?></td>
  <td width=50%><?php  form_quickedit("cronlogfilecmd",barcodeval_get("addons-cronman-cronlogfilecmd"),"text"); ?> %file for file ID</td>
 </tr>
    
  
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <a href="index.php" class=a_btn>Back</a></td>
</tr>
</table></form>
<?php 


				foot();
?>