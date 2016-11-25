<?php  
  include("inc/config.inc.php");
	html_start();
	$ssql_searchedword= sessionval_get("searchstr2usis");	
	$ssql_searchedword=explode(' ',$ssql_searchedword);
$dspv=sessionval_get("searchdspv");
			include ("./search.inc.func.php");


?>
<TABLE cellpadding=0 cellspacing=5 border=0 width="100%">
<TR valign=top>
	<TD width=50%><div class="curlycontainer"><div class="innerdiv"><?php  
	
	$all="";
	$matchcount=0;
	foreach ($ssql_searchedword as $vi) {
		$v=trim($vi);
		$v=str_remspecialsign($v);
		if ($v=="") {
			continue;
		}
		$thisall="";
		$tmpw=usoundex_get($v);
		$thisword="<B>$vi</B> [$tmpw] ";
		$tmpl=strlen($tmpw);
/*		$v=tmq("select *,LENGTH(usoundex) from indexword where (usoundex like '%$tmpw%' and LENGTH(usoundex) >".floor($tmpl-50)." and LENGTH(usoundex) <".floor($tmpl+70)." and mid=-1)		or		(word1 like '%$vi%' and mid<>-1)		limit 15",true);*/
		$v=tmq("select *,LENGTH(usoundex) from indexword where LENGTH(usoundex)>3 and ( (usoundex like '%$tmpw%'  )
		or
		(word1 like '%$vi%' ) )
		limit 15",false);
		$c=0;
		while ($r=tmq_fetch_array($v)) {
			//printr($r);
			if ($vi==$r[word1]) {
				continue;
			}
			$c++;
			$dspw=local_gethiddenquery($dspv,"searchdb[kw]");
			$thisall.=" <A HREF=\"advsearching.php?$dspw&searchdb[kw]=[[AND]]%20$r[word1]\" style='font-size: 14px;' target=_top>$r[word1]</A> ,";
		}
		if ($c>0) {
			$thisall=$thisword . trim($thisall,",") . "<BR>";
			$matchcount++;
		}
		$all=$all.trim($thisall,",");
	}

	if ($matchcount!=0) {
		echo "<B>".getlang("คำที่มีเสียงใกล้เคียงกัน::l::pronounced similarly words")."</B><BR> ". $all;
	} else {
		echo "<FONT class=smaller color=666666>".getlang("ไม่มีคำที่มีเสียงใกล้เคียงกันในฐานข้อมูลคำ::l::No pronounced similarly words in words database.")."</FONT>";
	}	
?></div></div>
<FONT style="font-size: 10px;">...<?php echo getlang("ข้อมูลเพิ่มเติมเกี่ยวกับ::l::more information about "); ?> <B><A HREF="usoundex.php" style="font-size: 10px;" target=_blank>USOUNDEX</A></B></FONT>

</TD><?php  
	
//printr($searchdb[su]);
?>
</TR>
</TABLE>