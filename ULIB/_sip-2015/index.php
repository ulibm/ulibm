<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sip";
        mn_lib();
				//include("sys_var.inc.php");

if ($issave=="yes") {
	barcodeval_set("sipsetting-hostIP",addslashes($hostIP));			
	barcodeval_set("sipsetting-logininid",addslashes($logininid));			
	barcodeval_set("sipsetting-passwordid",addslashes($passwordid));			
	barcodeval_set("sipsetting-portsopened",addslashes($portsopened));			
	barcodeval_set("sipsetting-limiter",addslashes($limiter));
	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\\\","\\",$phppath);
	$phppath=str_replace("\\","\\\\",$phppath);
	barcodeval_set("sipsetting-phppath",addslashes($phppath));			
	barcodeval_set("sipsetting-institutionID",addslashes($institutionID));			
	barcodeval_set("sipsetting-LibraryName",addslashes($LibraryName));			
	barcodeval_set("sipsetting-skippwd",addslashes($skippwd));

	////////////////
	$list=fso_listfile("$dcrs"."_sip");
	//printr($list);
	while (list($k,$v)=each($list)) {
		$chk=substr($v,0,11);
		if ($chk=="_serverport") {
			//echo $v;
			@unlink($dcrs."_sip/$v");
		}
	}
	//settings
	$ports=explode(",",$portsopened);
	$ports=arr_filter_remnull($ports);
	$phppathWin="\"".str_replace(" "," ",$phppath)."\"";
	//echo "[$phppathWin]";
	$ctall="
@echo ULibM SIP Server (Windows)
@echo Sock Server for port $v initializing..
@echo ======================================
";
	$ctallL="
echo \"ULibM SIP Server (Linux)\"
echo \"Sock Server for port $v initializing..\"
echo \"======================================\"
#killall php
".stripslashes($phppathWin)." \"ULibM SIP Server \" -q $dcrs"."_sip/killotherpid.php
sleep 3\n
echo my pid is $$

";
	while (list($k,$v)=each($ports)) {
		$ct="<"."?php \$SETPORT=$v;
		include('$dcrs"."_sip/sockserver.php');
		?".">";
		fso_file_write("$dcrs"."_sip/_serverport-$v.php","w+",$ct);
		$ctall.="
@echo starting port $v
@start \"ULibM SIP Server \" ".(stripslashes($phppathWin))." -q \"$dcrs"."_sip/_serverport-$v.php\"
";
		$ctallL.="
echo \"starting port $v\"
".(stripslashes($phppath))." -q $dcrs"."_sip/_serverport-$v.php&
";

	}
	$ctall.="
@echo Socket initialized
@pause
";
	$ctallL.="
echo \"Socket initialized\"

";
	fso_file_write("$dcrs"."/_sip/sipServerInitializer.bat","w+",$ctall);
	fso_file_write("$dcrs"."/_sip/sipServerInitializer.sh","w+",$ctallL);
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-SIP::l::System variables-SIP"));

?><table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("HOST IP-address");?></td>
  <td  align=center class=table_td><?php  form_quickedit("hostIP",barcodeval_get("sipsetting-hostIP"),"text"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("SIP Login");?></td>
  <td  align=center class=table_td><?php  form_quickedit("logininid",barcodeval_get("sipsetting-logininid"),"text"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("SIP Password");?></td>
  <td  align=center class=table_td><?php  form_quickedit("passwordid",barcodeval_get("sipsetting-passwordid"),"text"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("SIP Open ports, (Use commas (,))");?></td>
  <td  align=center class=table_td><?php  form_quickedit("portsopened",barcodeval_get("sipsetting-portsopened"),"longtext"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Subfield limiter");?></td>
  <td  align=center class=table_td><?php  form_quickedit("limiter",barcodeval_get("sipsetting-limiter"),"text"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("PHP-Path");?></td>
  <td  align=center class=table_td><?php  form_quickedit("phppath",addslashes(barcodeval_get("sipsetting-phppath")),"text"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("institution ID");?></td>
  <td  align=center class=table_td><?php  form_quickedit("institutionID",barcodeval_get("sipsetting-institutionID"),"text"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Library Name");?></td>
  <td  align=center class=table_td><?php  form_quickedit("LibraryName",barcodeval_get("sipsetting-LibraryName"),"text"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Skip Password");?></td>
  <td  align=center class=table_td><?php  form_quickedit("skippwd",barcodeval_get("sipsetting-skippwd"),"yesno"); ?></td>
 </tr>







	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '>
	   </td>
</tr>
</table></form>
<?php 
				foot();
?>