<?php 
if (strtolower(barcodeval_get("webpage-o-webpage_isshowwebjump"))=="yes") {
?><BR><TABLE width=100% align=center cellpadding=0 cellspacing=0 border=0 >
<FORM METHOD=POST ACTION="">
<SCRIPT LANGUAGE="JavaScript">
<!--
	function webjump(wh) {
		wha=wh.split('|');
		targ=wha[1];
		url=wha[0];
		//eval(targ+".location='"+url+"'");
		window.open(url,targ);
	}
//-->
</SCRIPT>
	<TR>
	<TD  align=center class=smaller><?php 
	echo getlang("ไปยังหัวข้อบทความ::l::Jump to article menu");
?> &nbsp; <SELECT NAME="jumpmenu"  style="font-size: 12px;" onchange="webjump(this.value)">
		<OPTION VALUE="" SELECTED >-</OPTION>
<?php 

$mn=tmq("select * from webpage_menu where isshow='yes' order by ordr");
while ($mnr=tmq_fetch_array($mn)) {
	$htmlli="";
	if ($mnr[type]=="content") {
		$link="$dcrURL"."/webpage.contentread.php?id=$mnr[id]";
		$target="_self";
	}
	if ($mnr[type]=="webboard") {
		$link="$dcrURL"."/web/viewforum.php?ID=$mnr[id]";
		$target="_self";
	}
	if ($mnr[type]=="picalbum") {
		$link="$dcrURL"."/web/viewforum.php?ID=$mnr[id]&picalbum=yes";
		$target="_self";
	}
	if ($mnr[type]=="url") {
		$inf=tmq("select * from webpage_menu_url  where refid='$mnr[id]' ");
		$inf=tmq_fetch_array($inf);
		$link="$inf[url]";
		$target="_blank";
	}
	if ($mnr[type]=="wiki") {
		$inf=tmq("select * from webpage_menu_wiki  where refid='$mnr[id]' ");
		$inf=tmq_fetch_array($inf);
		$link="$dcrURL"."webpage.wiki.php?title=".urlencode($inf[text])."";
		$target="_top";
	}
	if ($mnr[type]=="sepper") {
		$sepperbgcol=barcodeval_get("WEB-MENU-SEPPERCOLOR-$mnr[id]");
		if ($sepperbgcol=="") {
			$sepperbgcol="#000000";
		}
		$htmlli=" style='background-color:$sepperbgcol; font-weight: bold; color: white'";
		//$htmlli=" class=headerbar style='width:200'";
		$link="";
		$target="";
	}
	
	?><OPTION VALUE="<?php echo $link;?>|<?php echo $target;?>"  <?php  echo $htmlli;?>><?php  echo mb_substr(getlang($mnr[name]),0,30);?></OPTION>
	<?php 
}
?>
	</SELECT></TD>
</TR>
</FORM>
</TABLE>
<?php 
}

?>