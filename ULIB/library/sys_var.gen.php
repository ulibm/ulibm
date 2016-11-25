<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_vargen";
        mn_lib();
				include("sys_var.inc.php");
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-ทั่วไป::l::System variables-General"));

?>
<table border = 0 cellpadding = 0 width = 900 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<?php 
local_mn("dayalertlibbackup","_SETTING","day_to_alert_librarian_to_backup","number");
//local_mn("dayalertliblughtbackup","_SETTING","day_to_alert_librarian_to_lightbackup","number");
local_mn("defaultlanguage","_SETTING","default_lang","list:th,en");
local_mn("issavesearchword","_SETTING","savesearchword","yesno");
local_mn("islibcanusecookielogin","_SETTING","islibcanusecookielogin","yesno");
local_mn("islibcanchangeownautologin","_SETTING","islibchangeautologin","yesno");
local_mn("islibcanchangeownpassword","_SETTING","islibcanchangeownpassword","yesno");
local_mn("isconnecttoulibuc","_SETTING","connecttoulibuc","yesno");
local_mn("uselibrarianmsgboard","_SETTING","uselibrarianmsgboard","yesno");
local_mn("faculty_word","_SETTING","faculty_word","text");
local_mn("room_word","_SETTING","room_word","text");
local_mn("displayyazatbookman","_SETTING","displayyazatbookman","yesno");
local_mn("ulibmasterurl","SYSCONFIG","ulibmasterurl","text");
local_mn("bibstreamurlsf","SYSCONFIG","ulibbibstreamurl","text");
local_mn("liballowlogin_iprange","_SETTING","liballowlogin_iprange","longtext");
local_mn("systemreaddslashes","_SETTING","systemreaddslashes","yesno");
local_mn("LIST_YEAR_START","FORM","LIST_YEAR_START","number");
local_mn("LIST_YEAR_END","FORM","LIST_YEAR_END","number");

?>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>