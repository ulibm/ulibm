<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_varoai";
        mn_lib();
				include("sys_var.inc.php");
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-OAI::l::System variables-OAI"));

?><form method=post action="<?php  echo $PHP_SELF?>">

<table border = 0 cellpadding = 0 width = 900 align = center cellspacing=30>
<input type=hidden name="issave" value="yes">
<?php 
local_mn("oaiconfig_isenable","oaiconfig","isenable","list:no,yes");
local_mn("oaiconfig_repositoryName","oaiconfig","repositoryName","text");
local_mn("oaiconfig_connectiondbport","oaiconfig","connectiondbport","number");
local_mn("oaiconfig_DATASOURCE","oaiconfig","DATASOURCE","text");
local_mn("oaiconfig_repositoryIdentifier","oaiconfig","repositoryIdentifier","text");
local_mn("oaiconfig_charset","oaiconfig","charset","text");

?>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr>
	<tr valign = "top">
	  <td colspan=2 align=center>Repository URL : <a href="<?php  echo $dcrURL;?>oai/" target=_blank><?php  echo $dcrURL;?>oai/</a></td>
</tr>
</table></form>
<?php 
				foot();
?>