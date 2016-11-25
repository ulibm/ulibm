<TABLE width=100% align=center border=0>
<FORM METHOD=GET ACTION="advsearching.php" target=_top>
<TR>
	<TD align=center style="padding-bottom: 13px;padding-top: 10px;"><B><?php  echo getlang("คำค้น::l::Search"); ?>:</B>
	<INPUT TYPE="hidden" name='bool[]' value='[[AND]]'>
	<INPUT TYPE="text" NAME="kw[]" ID="INTERNALTEXTBOXKWSEARCH" style="width: 220px; border-width: 2px; border-style: inset; border-color: #D7D7D7;"
	onkeyup="internaltextboxsuggestion(this)" 
	onkeydown="quicksearchcurrentvalue=this.value; return  internaltextboxsuggestionarrow(event)"
	AUTOCOMPLETE=OFF
	>
	<INPUT TYPE="hidden" NAME="searchopt[]" value='kw'>
<INPUT TYPE="image" SRC="./neoimg/ulibsearch.png" align=absmiddle style="border-width: 0px; width: 32; height: 32; background-image:none!important;">
<?php  $RecentSearchesval=trim(sessionval_get("RecentSearches"));
//echo "[$RecentSearchesval]";
$RecentSearches=explodenewline($RecentSearchesval);
if ($RecentSearchesval!="" && count($RecentSearches)!=0 && ($_QUICKSEARCHonlymember == "yes" && $_memid !="")) {
	echo "<BR><FONT COLOR=#363E70 class=smaller2 style='cursor: hand; cursor: pointer;' onclick=\"getobj('recentsearchdiv').style.display='inline'\">".getlang("ประวัติการสืบค้น::l::Recent Searches")." </FONT><div style='display:none' ID='recentsearchdiv'>: ";
	$rccount=0;
	while (list($RecentSearchesk,$RecentSearchesv)=each($RecentSearches)) {
		$RecentSearchesv=explode('[spliter]',$RecentSearchesv);
		if ($RecentSearchesv[0]=="") {
			continue;
		}
		$rccount++;
		if ($rccount>20) {
			break;
		}
		echo "<nobr><A HREF='$RecentSearchesv[1]' class=smaller>$RecentSearchesv[0]</A> <FONT class=smaller2>(".number_format($RecentSearchesv[2]).")</FONT>";
		echo " ,<WBR></nobr><WBR>";
	}
	echo "</div>";
}
?></TD>
</TR>
</FORM>
</TABLE><?php 
include("$dcrs/webpage.inc.quicksearch.globalinc.php");
?>