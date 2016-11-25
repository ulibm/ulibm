<?php 
	; 
		
    include ("inc/config.inc.php");
		head();
		mn_web("webpage");

$contentread=tmq("select * from webpage_menu_content where refid='$id' ");
$contentread=tmq_fetch_array($contentread);
?>
<TABLE width="<?php  echo $_TBWIDTH?>" align=center cellpadding=0 cellspacing=0 border=0  ID=WEBPAGE_BODY>
<TR valign=top>
	<TD width=200><?php  include("webpage.menu.php");?></TD>
	<TD>
	<?php 
pagesection($contentread[title],"article");
	member_log($_memid,"menu-contentread",$contentread[title]);
if (loginchk_lib("check")) {
		?><TABLE width=100%><TR><TD align=right><?php html_xpbtn(getlang("แก้ไข::l::Edit")." ,".$dcrURL."library.webmenu/h_menu_content.php?id=$id,green,_blank");?></TD></TR></TABLE><?php 
}
		?><TABLE width=100% cellpadding=3 cellspacing=0 border=0>
		<TR>
			<TD><?php 
		echo str_webpagereplacer(stripslashes(stripslashes( $contentread[body])));
			if (strtolower($contentread[globalslideshow])=="yes") {
				html_ugallery("webpage_menucontents-$id",800);
			}
include("./web/inc.webjump.php");

?></TD>
		</TR>
		</TABLE>

</TD>
</TR>
</TABLE>

<?php 
				foot();
?>