<?php 
function res_brief_dsp($MID,$bib=true,$ishtml=true,$isdspnow=true) {
	//$title=marc_gettitle($MID);
	$title1=marc_melt($MID,"yes");
	//$title=substr($title1[tag245_a],2);
	$title=$title1[tag245_a];
	$title=trim($title," %./^");
	//printr($title1);
	$auth="".marc_getauth($MID);
	$calln="".marc_getcalln($MID);

	$result="";

	if (trim("$title$auth$calln")=="") {			 
		$tmp= "<I style='color: darkred; font-weight: bold;'>".getlang("ไม่พบทรัพยากร::l::Bib not found")."</I> ";
	} else {
		$tmp= "<B class=smaller>$title</B>";
		if (trim($auth)!="") {
			$tmp.=" /$auth";
		}
		if (trim($calln)!="") {
			$tmp.=" /$calln";
		}
	}
	//echo "[$title$auth$calln]";
	if ($ishtml!=true) {
		$tmp= strip_tags($tmp);
		$result= $tmp;
		if ($bib==true) {
			 $result.=html_label('b',$MID,"no",false);
		}
	} else {
		$result= "<TABLE border=0 style=\"border: 1px solid #5E778C\" cellspacing=0 cellpadding=3>
		<TR valign=top>
			<TD style='vertical-align: top;'>" .
		res_cov_dsp($MID)
		."</TD>
			<TD class=smaller style='vertical-align: top;'>$tmp ";
		if ($bib==true) {
			 $result.= html_label('b',$MID,"no",false);
		}
		$result.= "</TD>
		</TR>
		</TABLE>";
	}
	if ($isdspnow==true) {
		echo $result;
	} else {
		return $result;
	}
}
?>