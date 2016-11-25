<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_varcir";
        mn_lib();
				include("sys_var.inc.php");
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-การยืมคืน::l::System variables-Circulation"));

?>
<table border = 0 cellpadding = 0 width = 900 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<?php 
local_mn("daydifftorenew","config","daydiff-torenew","number");
local_mn("timetocirputtoshelf","config","timetocirputtoshelf","number");
local_mn("timeofdaytocirputtoshelf","config","timeofdaytocirputtoshelf","text");
local_mn("timetowarnlongholdrequest","config","timetowarnlongholdrequest","number");
local_mn("defaultresource_code","config","defaultresource_code","foreign:-localdb-,media_type,code,name,no");
//local_mn("timeoutatlibgate","config","timeout-at-libgate","number");
local_mn("libraryswitch_holdreturn","global","libraryswitch_hold-return","text");
local_mn("circulation_displaycover","_SETTING","circulation_displaycover","yesno");
local_mn("circulation_alertfine","_SETTING","circulation_alertfine","yesno");
local_mn("circulation_memprefix","_SETTING","circulation_memprefix","text");
local_mn("circulation_tempmemdays","_SETTING","circulation_tempmemdays","text");
local_mn("checkoutwalkbackmode","_SETTING","checkoutwalkbackmode","list:Back,Forth");
local_mn("holdrequestannouce","_SETTING","holdrequestannouce","longtext");
local_mn("hidesystemmemfaucet","config","hidesystemmemfaucet","yesno");
local_mn("circulation_renewdateusedt","_SETTING","circulation_renewdateusedt","list:Renew_date,Due_date");
local_mn("circulation_memberbarcodehasspecialsign","_SETTING","memberbarcodehasspecialsign","yesno");
?>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>