<?php 
if ($_wlocal_specsub!="yes") {
	$s="select * from webpage_wiki_status where 1 ";
	if ($ismanager!=true) {
		$s.=" and code<>'draft' and code<>'incomplete' ";
	}
	$s=tmq($s);
	echo "<BR><BLOCKQUOTE>";
	while ($r=tmq_fetch_array($s)) {
		if ($_ISULIBMASTER=="yes" && $r[code]=="logedinonly") {
			$r[name]="UUG เท่านั้น::l::UUG Only";
			$r[descr]="บทความที่สงวนไว้สำหรับสมาชิก UUG เท่านั้น::l::This article is for UUG Members only";
		}
		echo "<A HREF='webpage.wiki.php?title=statuslist:$r[code]'><B>".getlang($r[name])."</B></A><BR>";
		echo "<FONT class=smaller>".getlang("$r[descr]")."</FONT>";

		echo "<BR>";
	}
	echo "</BLOCKQUOTE>";
} else {

	$tbname="webpage_wiki";

	$dsp[2][text]="ชื่อเรื่อง::l::Topics";
	$dsp[2][filter]="module:local_inc_wikirow";
	$dsp[2][field]="title";
	$dsp[2][width]="30%";

	$o[tablewidth]="100%";
//echo "$modulecheck2";

	fixform_tablelister($tbname," status like '%,$modulecheck2,%' and hasdata='yes'  ",$dsp,"no","no","no","title=$title",$c," dt desc ",$o);


}

?>