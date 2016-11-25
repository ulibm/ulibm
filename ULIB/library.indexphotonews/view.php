<?php 
	; 
        include ("../inc/config.inc.php");
        include ("./cfg.inc.php");
		if (barcodeval_get("webpage-indexphotonews_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("indexphotonews");
		include($dcrs."webbox/topmenu.php");

		if ($id!="" && $setnewcate!="" && library_gotpermission("webpage-indexphotonews")==true) {
			tmq("update webpage_indexphotonews set cate='$setnewcate' where id='$id' ");
		}
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
		<TD align=right>
		<?php 

		$s=tmq("select * from webpage_indexphotonews where id='$id' ");
		$s=tmq_fetch_array($s);

		//echo "<A HREF='index.php?cate=$s[cate]' class=smaller>";
		//echo getlang("ในหัวข้อ ::l::In group ")."".$catenamedb[$s[cate]];
		//echo "</A>";
		?>
		<TABLE width=100% align=center border=0 cellpadding=4 cellspacing=0>
		<TR>
			<TD align=right style="padding-right:10">ข่าว: <FONT style="font-size:24"><?php  echo stripslashes(strip_tags($s[title]))?></FONT><BR>
			<?php 
		echo "<FONT class=smaller>&nbsp;&nbsp;".getlang("โดย::l::By");
		echo (html_library_name($s[memid]));
		echo"</FONT><FONT class=smaller2><BR>&nbsp;&nbsp;".getlang("เมื่อ::l::since");
		echo ymd_datestr($s[dt]) . " (" .ymd_ago($s[dt]).")</FONT>";
	?></TD>
		</TR>
		</TABLE>
		<TABLE width=100% class=table_border>

			<TR>
				<TD class=table_td  colspan=2 style="padding: 20px; background-color: #ffffff"><?php  echo stripslashes(stripslashes($s[text]))?><HR noshade>
				<CENTER><?php 
$img=fft_upload_get("webpage_indexphotonews","coverimg",$s[id]);

if ($img[status]=="ok") {
	echo "<img src='$img[url]' vspace=10 style='max-width: 750px;'><BR>";
}
				?></CENTER>
<?php 

$img=fft_upload_get("webpage_indexphotonews","attatchfile",$s[id]);

if ($img[status]=="ok") {
	echo "<BR><A class=smaller HREF='$img[url]' target=_blank><IMG SRC='../neoimg/menuicon/file16.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT='' align=absmiddle>".getlang("ดาวน์โหลดไฟล์แนบ::l::Download Attatch file")."</A>";
}

?>

				</TD>
			</TR>
			<?php 
			if (library_gotpermission("webpage-indexphotonews") && $s[answer]<>'') {
			?><TR>
				<TD class=table_head><?php  echo getlang("รายละเอียดผู้มารับ::l::Owner detail");?></TD>
				<TD class=table_td style="padding: 20px; background-color: #C6FBCF"><?php  echo stripslashes(($s[answer]))?></TD>
			</TR><?php 
			}
			?>
			</TABLE>
		<?php 
			?>
		</TD>

</TR>
</TABLE>
<?php 
				foot();
?>