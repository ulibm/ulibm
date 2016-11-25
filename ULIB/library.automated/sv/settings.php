<?php 
	; 
		
        include ("../../inc/config.inc.php");
		head();
		$_REQPERM="mainmenu";
        mn_lib();
				//include("sys_var.inc.php");

if ($issave=="yes") {
	$phppath=str_replace("\\","/",$phppath);
	$phppath=str_replace("//","/",$phppath);
	$phppath=str_replace("\\","\\\\",$phppath);
	barcodeval_set("automated_sv_setting-phppath",addslashes($phppath));			

	////////////////
	//$list=fso_listfile("$dcrs"."library.automated/sv/runner.bat");
	//printr($list);
	//settings
	$ports=explode(",",$portsopened);
	$ports=arr_filter_remnull($ports);
	$ctall="
@echo ULibM automated Server (Windows)
@echo ======================================
";
$phppath=str_replace(" ","\\ ",$phppath);
$dcrsuse=str_replace(" ","\\ ",$dcrs);
	$ctallL="echo \"ULibM automated Server (Linux)\"
echo \"======================================\"
";
		$ct="<"."?php
		include('$dcrs"."inc/config.inc.php');
		include('$dcrs"."library.automated/sv/run.php');
		?".">";
		fso_file_write("$dcrs"."library.automated/sv/runner.php","w+",$ct);
		$ctall.="
@echo starting 
 \"".stripslashes(stripslashes($phppath))."\" -q \"$dcrs"."library.automated/sv/runner.php\"
";
		$ctallL.="echo \"starting \"
".(($phppath))." -q $dcrsuse"."library.automated/sv/runner.php
";


	$ctall.="
@echo Inted
@pause
";
	$ctallL.="echo \"Inted\"";
	fso_file_write("$dcrs"."library.automated/sv/runner.bat","w+",$ctall);
	fso_file_write("$dcrs"."library.automated/sv/runner.sh","w+",$ctallL);
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ::l::System variables"));

?><table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("PHP-Path");?></td>
  <td  align=center class=table_td><?php  form_quickedit("phppath",(barcodeval_get("automated_sv_setting-phppath")),"text"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>