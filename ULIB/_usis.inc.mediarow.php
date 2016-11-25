<?php 
function usis_inc_media($row) {
	global $i;
	global $searchdb;
	global $startrow;	
	global $dcrURL;	
	global $searchworddb;

	$mPri=$row[mid];
	$mName=marc_gettitle($mPri);
	$mAuth=marc_getauth($mPri);
	//printr($searchdb);

		$searchdb_kw=explode(' ',$searchdb[kw]);
		foreach ($searchdb_kw as $x) {
			$mAuth=str_replace($x,"<U>$x</U>",$mAuth);
			$mName=str_replace($x,"<U>$x</U>",$mName);
		}
		$searchdb_au=explode(' ',$searchdb[au]);
		foreach ($searchdb_au as $x) {
			$mAuth=str_replace($x,"<U>$x</U>",$mAuth);
		}

	$mcalln=marc_getcalln($mPri,"<BR>");
	$mcalln=str_replace2("<BR>","",$mcalln,"1");

$ittt=($startrow) + $i;
if ($i % 2 == 0) { 
		echo "<tr bgcolor=#e9e9e9> "; 
	} else { 
		echo "<tr bgcolor=#d9d9d9> "; 
	}
	echo "<td align=center colspan=1><font
face='MS Sans Serif' size=2>$ittt</font></td>";
	$tmp=date("YmdHis");
	$tmp2=time();
	$tmp2="000" . $tmp;

	echo "<td valign=top><FONT COLOR=#660000>
$mcalln</FONT></td>
<TD colspan=1 > 
<font >";
$mAuth=trim($mAuth);
if ($mAuth!="") {
	echo "<A HREF=\"searching.php?MAUTHOR=".urlencode(strip_tags($mAuth))."&makeref=yes\" target=_blank>$mAuth</A>  /";
}
echo " $mName";
	echo "</td><td><nobr>";
	echo "<a href='$dcrURL/dublin.php?&f=dublin&ID=$mPri' target=_blank > ".getlang("บรรณานุกรม::l::Full detail")."</a>";
$tags=tmq("select * from media where id='$row[mid]' ");
$tags=tmq_fetch_array($tags);
	$tmp=marc_getsubfields($tags[tag856]);
	$urlprefix="";
//printr($tmp);
	if (count($tmp)<2 || trim($tmp[u])=='') {
		$tmp=marc_getsubfields($tags[ulibtag856]);
		$urlprefix="dublin.linkout.php?url=";
		$tmp[u]=urlencode($tmp[u]);
	}
	//printr($tmp);
//echo $row[tag856];
	if ($tmp[u]!=""){
		echo "/<A HREF='$urlprefix$tmp[u]' target=_blank title=\"$tmp[z]\"><IMG SRC='neoimg/ebook.gif' WIDTH=19 HEIGHT=17 BORDER=0 ALT='Fulltext' align=absmiddle></A>";
	}
	echo "<FONT  COLOR=#660000>$smtype</FONT>";
	echo " ";

	echo "</td></tr>";
	$i++;
	$s=$i - 1;
}
?>