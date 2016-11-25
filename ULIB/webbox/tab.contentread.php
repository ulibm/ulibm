<?php 
$id=$readid;
$contentread=tmq("select * from webbox_topmenu_content where refid='$id' ");
$contentread=tmq_fetch_array($contentread);
?>
<TABLE width="100%" align=center cellpadding=0 cellspacing=0 border=0  ID=WEBPAGE_BODY>
<TR valign=top>
	<TD>
	<?php 
if (trim($contentread[title])!="") {
pagesection($contentread[title],"article");
}
	member_log($_memid,"menu-contentread",$contentread[title]);
if (loginchk_lib("check")) {
		?><TABLE width=100%><TR><TD align=right><?php html_xpbtn(getlang("แก้ไข::l::Edit")." ,".$dcrURL."library.webbox.cascademenu/h_menu_content.php?id=$id,green,_blank");?></TD></TR></TABLE><?php 
}
		?><TABLE width=100% cellpadding=3 cellspacing=0 border=0>
		<TR>
			<TD><?php 
		echo str_webpagereplacer(stripslashes(stripslashes( $contentread[body])));
		//printr($contentread);
			if (strtolower($contentread[globalslideshow])=="yes") {
				html_ugallery("webbox_topmenucontents-$id",650);
			}?></TD>
		</TR>
		</TABLE>

</TD>
</TR>
</TABLE>

<?php ?>