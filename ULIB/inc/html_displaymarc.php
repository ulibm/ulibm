<?php  //พ
function html_displaymarc($ID) {
	stathist_add("viewbib_bib_type",$ID,"marc");	

	global $_TBWIDTH;
   $sql = "select * from media where ID='$ID' ";
   $result = tmq($sql);
	$r = tmq_fetch_array($result);

	//marcdspmod s
if (strtolower(barcodeval_get("isenablemarcdspmod"))!="no") {
	$marcdspmods=tmq("select * from marcdspmod_main");
	while ($marcdspmodr=tfa($marcdspmods)) {
		marcdspmod_recalitemrule($marcdspmodr[id]);
		$marcdspmodchk=marcdspmod_getsql($marcdspmodr[id]);
		$marcdspmodchk=tmq($marcdspmodchk." and ID='$ID' ",false);
		if (tnr($marcdspmodchk)==1) {
			//echo "match";
			$r=marcdspmod_apply($r,$marcdspmodr[id]);
		}
	}
}
	//marcdspmod e


$retstr="";
$retstr.="<table bgcolor=white width='".$_TBWIDTH."' border=1 align=center cellpadding=1 
cellspacing=0 bordercolor=#dddddd>";

$isshowleader=getval("_SETTING","display_LEADERatupac");
if ($isshowleader=="yes") {
	$retstr.="<TR>
		<TD colspan=4><B>LEADER</B> $r[leader]</TD>
	</TR>"; 
}

                                        $sql82="select * from bkedit order by ordr";
                                        $result=tmq($sql82, $conn);
					echo tmq_error();
while ($rowd=tmq_fetch_array($result)) {
	$allR=explode("\n",$r[$rowd[fid]]);
	foreach ($allR as $value) {

						echo tmq_error();
						$x = str_replace("$","$",$rowd[val]);
						$str = $value;
						if (trim(dspmarc($str))!="") {
							$retstr.="<tr bgcolor=#f3f3f3 valign=top>
							<td nowidth =70><FONT SIZE=3>";
							$tmprowdfid=$rowd[fid];
							$tmprowdfid=str_replace("tag","",$tmprowdfid);
							$tmprowdfid=str_replace("ulib","",$tmprowdfid);
							$retstr.= $tmprowdfid;
							//$retstr.="&nbsp;</td>";
							$retstr.="&nbsp;";
							 if ($rowd[ishasindi]=="YES") {
								//$retstr.="<td width = 20 ><FONT SIZE=3>";
								if (trim(substr($str,0,1))=="") {
									$retstr.="&nbsp;";
								} else {
									$retstr.=substr($str,0,1);
								}
								//$retstr.="</td>
								//<td width = 20 ><FONT SIZE=3>";
								if (trim(substr($str,1,1))=="") {
									$retstr.="&nbsp;";
								} else {
									$retstr.=substr($str,1,1);
								}
								//$retstr.="</td>";
							} else { 
								$retstr.="&nbsp;&nbsp;";
								//$retstr.="<td width =40  align=center colspan=2><font face ='MS Sans Serif' size =2></font></td>";
							}
							$retstr.="&nbsp;";

							//$retstr.="<td width =100%><FONT SIZE=3>&nbsp;";
							 if ($rowd[ishasindi]=="YES") {
							$retstr.= substr($str,2);
							} else {
							$retstr.= $str;
							}
							//fix ie
							$retstr=str_replace('""',"",$retstr);
							$retstr.="</FONT></td></tr>";

						}
	} //loop for splited \n

}
$retstr.="</table>";
return $retstr;

}
?>