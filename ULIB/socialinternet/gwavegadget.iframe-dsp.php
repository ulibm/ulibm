<?php 
	include ("../inc/config.inc.php");
$MID=$mid;
	$title=marc_gettitle($MID);
	$auth="".marc_getauth($MID);
	$calln="".marc_getcalln($MID);
html_start();
?><style>
BODY {
	background-color:#F0F2F7;
}
</style><?php 
	$result="";
?><A HREF="<?php  echo $dcrURL;?>" target=_blank><B style="color: #000066"><?php 
	$tmp=explode('::l::',stripslashes(getval("global", "HEAD")))	;
	$tmp=$tmp[1];

echo $tmp;?></B></A><BR>
<FONT class=smaller><?php 
	$tmp=explode('::l::',stripslashes(getval("global", "HEAD 2")))	;
	$tmp=$tmp[1];

echo $tmp;?></FONT><BR><?php 
	if (trim("$title$auth$calln")=="") {			 
		$tmp= "<I style='color:#FF6600'>Bib not found</I> ";
	} else {
		$tmp= "<B>$title</B>";
/////////////////////////
if (barcodeval_get("bibrating-o-enable")=="yes") {
	$ratedb=tmq("select * from webpage_bibrating_sum where bibid='$mid' ");
	if (tmq_num_rows($ratedb)!=0) {
		$ratedb=tmq_fetch_array($ratedb);
		$scoredsp=number_format($ratedb[votescore],1);
		$scoretxt=floor(($ratedb[votescore]*20)/5);
		$scorecounttxt=number_format($ratedb[votecount]);
		$scoretxt=floor($scoretxt*5);

		$tmp.="<BR><FONT class=smaller2>&nbsp;&nbsp;&nbsp;&nbsp;<img width='16' height=16 align=absmiddle src='$dcrURL"."neoimg/bibrating/s$scoretxt.png'> Rated:
		<B class=smaller2>$scoredsp</B>/$scorecounttxt</FONT>";
	}
}
/////////////////////////
$tmp.= "<BR>";
		if (trim($auth)!="") {
			$tmp.=" Author: $auth<BR>";
		}
		if (trim($calln)!="") {
			$tmp.=" Library CallNo.:$calln<BR>
			<I><A HREF='$dcrURL"."dublin.php?ID=$mid' target=_blank style='font-size: 10; text-decoration:italics'>View this bibliographic record (new window)</A></I>";
		}
	}
	//echo "[$title$auth$calln]";

		echo "<TABLE border=0 width=100% bgcolor=white>
		<TR valign=top>
			<TD>" .
		res_cov_dsp($MID);

		echo "</TD>
			<TD>$tmp ";

/////////////
echo "<BR>";
//////////////
	$webreview=tmq("select * from webpage_showcase where mid='$mid' ",false);
	$webreviewstr="";
	if (tmq_num_rows($webreview)!=0) {
		echo "<wbr><nobr>&nbsp;<IMG SRC='$dcrURL/neoimg/reviewicon.png' WIDTH='20' HEIGHT='20' BORDER='0' align=absmiddle><B><FONT COLOR='#000066' style='font-size: 11px;'> ".getlang("Got review!")."</FONT></B></nobr>";
	}
//////////////
		$itd=tmq("select * from media_mid where pid='$mid' ");
		$itdok=0;
		$itdcheckedout=0;
		while ($itdr=tmq_fetch_array($itd)) {
					$itdchk=tmq("select id from checkout where mediaId='$itdr[bcode]' and allow='yes' and returned='no' ");
					if (tmq_num_rows($itdchk)==0) {
							$itdok++;
					} else {
							$itdcheckedout++;
					}
		}
		if (($itdok+$itdcheckedout)==0) {
			 $itdstr="";
		} else {
			if (($itdok+$itdcheckedout)==1) {
				$itemword="item";
			} else {
				$itemword="items";
			}
			if ($itdok==1) {
				$itemokword="item";
			} else {
				$itemokword="items";
			}
			if ($itdcheckedout==1) {
				$itemcheckedoutword="item";
			} else {
				$itemcheckedoutword="items";
			}
			if ($itdok==0 && $itdcheckedout!=0) {
			 $itdstr="All items checked out ($itdcheckedout $itemword)"; 
			}
			if ($itdok!=0 && $itdcheckedout==0) {
			 $itdstr="All item ready ($itdok $itemword)"; 
			}
			if ($itdok!=0 && $itdcheckedout!=0) {
			 $itdstr="$itdok $itemokword ready and $itdcheckedout $itemcheckedoutword borrowed<!--  (มี ".($itdok+$itdcheckedout)." ไอเทม) -->"; 
			}
		}
		$itdstr=trim($itdstr);
		if ($itdstr!="") {
			 echo "<wbr><nobr>&nbsp;$leftspace<font style='font-size: 12px; color: #333333;'><img src='$dcrURL"."neoimg/Warning.gif' align=absmiddle border=0> $itdstr</font></nobr>";
		}
///////////////////////
	$indexdb=tmq("select * from index_db where mid='$mid' ");
	$indexdb=tmq_fetch_array($indexdb);

	$shelvesdb=tmq_dump2("media_place","code","name,main");
	$libsitedb=tmq_dump("library_site","code","name");

	echo "<wbr><nobr><FONT COLOR='#646464' class=smaller2>";
	//mdtype
	$tmp=trim($indexdb[mdtype]);
	$tmp=trim($tmp,',');
	$tmp=explode(',',$tmp);

	$tmpstr1="";
	while (list($k,$v)=each($tmp)) {
		$tmpstr1.=getlang($mdtypedb[$v]).',';
	}
	$tmpstr1=trim($tmpstr1,',');
	//placelist
	$tmp=trim($indexdb[placelist]);
	$tmp=trim($tmp,',');
	$tmp=explode(',',$tmp);
	$tmpstr2="";
	//printr($shelvesdb);
	while (list($k,$v)=each($tmp)) {
		if ($v!="") {
			$tmpshlv=explode('::l::',$libsitedb[$shelvesdb[$v][1]])	;
			$libsitedb[$shelvesdb[$v][1]]=$tmpshlv[1];

			$tmpshlv=explode('::l::',$shelvesdb[$v][0])	;
			$shelvesdb[$v][0]=$tmpshlv[1];
			$tmpstr2.=getlang($shelvesdb[$v][0]).'('.getlang($libsitedb[$shelvesdb[$v][1]]).'),';
		}
	}
	$tmpstr2=trim($tmpstr2,',');


	if ($tmpstr1.$tmpstr2!="") {
		echo "$leftspace$tmpstr1";
		if ($tmpstr2!="") {
			echo " at $tmpstr2";
		}
	}
	echo "</FONT></nobr>";
//////////////
	$webreview=tmq("select * from webpage_bookcomment where bibid='$mid' and allowed='yes' ",false);
	$webreviewstr="";
	if (tmq_num_rows($webreview)!=0) {
		echo "<wbr><nobr>&nbsp;<IMG SRC='$dcrURL/neoimg/reviewicon.png' WIDTH='20' HEIGHT='20' BORDER='0' align=absmiddle><FONT COLOR='#000066' style='font-size: 11px;'> ".tmq_num_rows($webreview)." ".getlang("Commented on this bib.")."</FONT></nobr>";
	}
//////////////
$tags=tmq("select tag856,ulibtag856 from media where ID='$mid' ");
$tags=tmq_fetch_array($tags);
//printr($tags);
$counteconn=count(arr_filter_remnull(explodenewline(trim($tags[tag856]))))+count(arr_filter_remnull(explodenewline(trim($tags[ulibtag856]))));
if ($counteconn!=0) {
	echo "<wbr><nobr>&nbsp;<IMG SRC='$dcrURL/neoimg/ebook.gif' WIDTH='20' HEIGHT='20' BORDER='0' align=absmiddle><FONT COLOR='#000066' style='font-size: 11px;'> ".($counteconn)." electronic link";
	if ($counteconn>1) {
		echo "s";
	}
	echo"</FONT></nobr>";
}
			?>
			</TD>
		</TR>
<TR>
	<TD colspan=2>

<TABLE width=100% align=center border=0>
<FORM METHOD=GET ACTION="<?php echo $dcrURL?>advsearching.php" target=_blank>
<TR>
	<TD align=center style="padding-bottom: 13px;padding-top: 10px;"><B class=smaller>Search library:</B>
	<INPUT TYPE="hidden" name='bool[]' value='[[AND]]'>
	<INPUT TYPE="text" NAME="kw[]" ID="INTERNALTEXTBOXKWSEARCH" style="width: 220px; border-width: 2px; border-style: inset; border-color: #D7D7D7;"
	onkeyup="internaltextboxsuggestion(this)" 
	onkeydown="quicksearchcurrentvalue=this.value; return  internaltextboxsuggestionarrow(event)"
	AUTOCOMPLETE=OFF class=smaller
	>
	<INPUT TYPE="hidden" NAME="searchopt[]" value='kw'>
<INPUT TYPE="image" SRC="<?php echo $dcrURL?>/neoimg/ulibsearch.png" align=absmiddle style="border-width: 0px; width: 32; height: 32; background-image:none!important;">
</TD>
</TR>
</FORM>
</TABLE>
<?php 		
		echo "</TD>
		</TR>
		</TABLE>";

	?>