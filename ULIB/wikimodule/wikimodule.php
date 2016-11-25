<?php 
$modulecheck2=strtolower($modulecheck2);
if ($modulecheck2=="home") {

?><TABLE cellpadding=0 cellspacing=0 border=0 width=100%>
<TR valign=top>
	<TD style="padding-right: 6px;"><?php 
	$wh=tmq("select * from webpage_wiki where title='wiki:home' ");
	if (tnr($wh)==0) {
		tmq("insert into webpage_wiki set title='wiki:home' ");
		$wh=tmq("select * from webpage_wiki where title='wiki:home' ");
	}
	$wh=tfa($wh);//printr($wh);
	$parser2 = new WikiParser();
	$parser2->reference_wiki = $dcrURL."index.php?webboxload=yes&title=";
	$output = $parser2->parse("$wh[body]");
	echo $output;
?></TD>
	<TD width=220><?php 
	if (editperm_chk($titlekey)==true) {
		html_xpbtn(getlang("แก้ไขหน้าหลัก::l::Edit Home page")." ,index.php?webboxload=yes&title=wiki:home&editit=yes&skipwikimodule=yes,green");
	} else {
		echo getlang("คุณไม่มีสิทธิ์ลบหรือแก้ไขรายการนี้::l::Your login have no permission to modify this article;");
	}
	$link=tmq(" select * from  webpage_wiki where hasdata='yes' order by rand() limit 6 ");
	echo "<B class=smaller>".getlang("รายการสุ่ม::l::Random Articles")."</B><BR>";
	while ($linkr=tmq_fetch_array($link)) {
		$linkr[title]=stripslashes($linkr[title]);
		$linkr[title]=str_replace('_',' ',$linkr[title]);
		$linkrlink=str_replace(':','--namespace--',$linkr[title]);
		if (getval("_SETTING","wikiusemodrewrite")=="yes") {
			echo " <A HREF=\"$dcrURL"."wiki/".($linkrlink)."\" class=smaller2>&bull; $linkr[title]</A><BR>";
		} else {
			echo " <A HREF=\"index.php?webboxload=yes&title=".urlencode($linkr[title])."\" class=smaller2>&bull; $linkr[title]</A><BR>";
		}
	}
	$link=tmq(" select * from  webpage_wiki where hasdata='yes' order by dt desc limit 6 ");
	echo "<B class=smaller>".getlang("อัพเดทล่าสุด::l::Most recent")."</B><BR>";
	while ($linkr=tmq_fetch_array($link)) {
		$linkr[title]=stripslashes($linkr[title]);
		$linkr[title]=str_replace('_',' ',$linkr[title]);
		$linkrlink=str_replace(':','--namespace--',$linkr[title]);
		if (getval("_SETTING","wikiusemodrewrite")=="yes") {
			echo " <A HREF=\"$dcrURL"."wiki/".($linkrlink)."\" class=smaller2>&bull; $linkr[title]</A><BR>";
		} else {
			echo " <A HREF=\"index.php?webboxload=yes&title=".urlencode($linkr[title])."\" class=smaller2>&bull; $linkr[title]</A><BR>";
		}
	}

	?></TD>
</TR>
</TABLE>
<?php 
}
?>