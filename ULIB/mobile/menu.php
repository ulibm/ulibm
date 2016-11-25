
<ul data-role="listview">
<?php 
// พ
$mn=tmq("select * from webmobile_menu where isshow='yes' order by ordr");
while ($mnr=tmq_fetch_array($mn)) {
	$alt=trim(stripslashes($mnr[descr]));
	$htmlli="";
	if ($mnr[type]=="sepper") {
		$sepperbgcol=barcodeval_get("WEBMOBILE-MENU-SEPPERCOLOR-$mnr[id]");
		if ($sepperbgcol=="") {
			$sepperbgcol="a";
		}
		$htmlli=" data-role=\"list-divider\" data-theme=\"$sepperbgcol\"";
		//$htmlli=" class=headerbar style='width:200'";
		$link="";
	}/*
	if ($mnr[type]=="webboard") {
		$link="<A HREF='./web/viewforum.php?ID=$mnr[id]' >";
	}
	if ($mnr[type]=="picalbum") {
		$link="<A HREF='./web/viewforum.php?ID=$mnr[id]&picalbum=yes' >";
	}*/
	if ($mnr[type]=="url") {
		$inf=tmq("select * from webmobile_menu_url  where refid='$mnr[id]' ");
		$inf=tmq_fetch_array($inf);
		$link="<A HREF='$inf[url]'  target='$inf[target]' data-ajax=\"false\">";
	}
	if ($mnr[type]=="content") {
		$link="<A HREF='#content$mnr[id]' >";
	}
	if ($mnr[type]=="memberloginform") {
		$link="<A HREF='#memberloginform' >";
	}
	if ($mnr[type]=="searchform") {
		$link="<A HREF='#searchform' >";
	}
	/*
	if ($mnr[type]=="wiki") {
		$inf=tmq("select * from webmobile_menu_wiki  where refid='$mnr[id]' ");
		$inf=tmq_fetch_array($inf);
		$link="<A HREF='$dcrURL"."webpage.wiki.php?title=".urlencode($inf[text])."' >";
	}*/
	?><li <?php echo $htmlli?> ><?php echo $link;?> <?php  echo trim(getlang($mnr[name]));?> </A></li>
	<?php 

}

?>
			</ul>
<?php 

?>