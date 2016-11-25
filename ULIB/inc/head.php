<?php 
function head() {
	global $head_evelcall;
	global $html_start_title;
	global $dcr;
	global $_TBWIDTH;
	global $dcrURL;
	global $_HTMLTEMPLATE;
	if ($head_evelcall=="yes") {
		return;
	}
	$head_evelcall="yes";
	html_start(); 
	echo barcodeval_get("webpage-o-mannualhtmlbeginbody");
	if (strtolower(getval("_SETTING", "web_hideheader"))=="yes") { 
	  echo "<!-- suppress header bar by setting -->";
	} else {
?>
<TABLE WIDTH="<?php  echo $_TBWIDTH;?>" height=78 BORDER=0 CELLPADDING=0 CELLSPACING=0 align=center
background="/<?php  echo $dcr;?>/_tmp/headbar/<?php  echo $_HTMLTEMPLATE;?>.jpg" style="background-repeat:no-repeat;" ID="HEAD_HEAD">
 <TR valign=top>
		<TD width=261 style="padding-left: 25;padding-top:4" ID=HEAD_LOGO_TD>
		<A name="topofpage"></A>
		<a href="<?php  echo $dcrURL?>" target=_top><img src="<?php  
	if (strtolower(barcodeval_get("webpage-o-isshowweblogodecistop"))=="no") {
		echo  $dcrURL."neoimg/spacer.gif";
	} else {
		echo  $dcrURL."_tmp/logo/_weblogo.png";
	}
	?>" border=0 width=261 height=66 ID="HEAD_LOGO"></a>
		</TD>

		<TD  align=right valign=top style="padding-right: 12px; padding-top: 19px; width: 100%;" ID=HEAD_MAINTD>
		<?php  echo barcodeval_get("webpage-o-mannualhtmlinsideheader");?>

		<span style="font-size: 24px;" ID="HEAD_TEXT1"><?php 
    echo stripslashes(getlang(getval("global", "HEAD")));
?><BR></span><img src="<?php echo $dcrURL?>neoimg/spacer.gif" width=1 height=18><span style="font-size: 14px;padding-right: 12px; padding-top: 19px;"  ID="HEAD_TEXT2"><?php 
    echo stripslashes(getlang(getval("global", "HEAD 2")));
?></span>

		</TD>
		<TD WIDTH=33 ID=HEAD_LANGTD valign=middle align=right>
			<A HREF="<?php  echo $dcrURL?>/lang_control.php?lang_control_set=th" target=langchanger  rel="nofollow" ><IMG SRC="/<?php  echo $dcr;?>/neoimg/th-t.gif" WIDTH=20 HEIGHT=13 ALT="เปลี่ยนเป็นภาษาไทย" border=0></A><BR>

	<IMG SRC="/<?php  echo $dcr;?>/neoimg/spacer.gif" WIDTH=33 HEIGHT=5 border=0><BR>

			<A HREF="<?php  echo $dcrURL?>/lang_control.php?lang_control_set=en" target=langchanger  rel="nofollow" ><IMG SRC="/<?php  echo $dcr;?>/neoimg/en-t.gif" WIDTH=20 HEIGHT=13 ALT="Change to English" border=0></A>	

		</TD>

	</TR><iframe width=100 height=100 style="display:none" name=langchanger></iframe>
</TABLE>
<!-- End head bar -->
<?php 
}
	$htmlc=barcodeval_get("webpage-o-mannualhtmlheader");
	$htmlc=trim($htmlc);
	$htmlc=stripslashes($htmlc);
	$htmlc=stripslashes($htmlc);
	if ($htmlc!="") {
		 //echo "<center><br />$htmlc</center>";
		echo "<span class=sidebarstriptagp style=\"\">".stripslashes($htmlc)."</span>";
	}
}
?>