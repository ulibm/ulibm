<?php 
function html_displaymedia($ID) {
	stathist_add("viewbib_bib_type",$ID,"html");	

	global $dcrURL;
	global $r_2;
	global $r_3;
	global $r_4;
	global $r_5;
	global $r_6;
	global $r_7;
	global $r_8;
	global $r_9;
	global $r_10;
	global $r_11;
	global $r_12;
	global $r_13;
	global $r_14;
	global $r_15;
	global $r_16;
	global $r_17;
	global $r_18;
	global $r_19;
	global $r_20;
	global $r_21;
	global $r_22;
	global $r_23;
	global $r_24;
	global $r_25;
	global $r_26;
	global $r_27;
	global $r_28;
	global $r_29;
	global $r_30;
	global $r_31;
	global $r_32;
	global $r_33;
	global $r_34;
	global $r_35;
	global $_TBWIDTH;
	if (substr($_TBWIDTH,-1)=='%') {
		$_TBWIDTH=780;
	}

	$indi=tmq_dump("bkedit","fid","ishasindi");
	$systemhide=tmq_dump("bkedit","fid","systemhide");
	//$autogentxtbyindi=trim(getval("MARC","autogentxtbyindi"));
	$autogentxtbyindi[tag520][first]["blank"]="<B>Summary:</B> ";
	$autogentxtbyindi[tag520][first][0]="<B>Subject:</B> ";
	$autogentxtbyindi[tag520][first][1]="<B>Review:</B> ";
	$autogentxtbyindi[tag520][first][2]="<B>Scope and content:</B> ";
	$autogentxtbyindi[tag520][first][3]="<B>Abstract:</B> ";
	$autogentxtbyindi[tag246][second][2]="<B>Distinctive title:</B> ";
	$autogentxtbyindi[tag246][second][3]="<B>Other title:</B> ";
	$autogentxtbyindi[tag246][second][4]="<B>Cover title:</B> ";
	$autogentxtbyindi[tag246][second][5]="<B>Added title page title:</B> ";
	$autogentxtbyindi[tag246][second][6]="<B>Caption title:</B> ";
	$autogentxtbyindi[tag246][second][7]="<B>Running title:</B> ";
	$autogentxtbyindi[tag246][second][8]="<B>Spine title:</B> ";
	$autogentxtbyindi[tag505][first][0]="<B>Contents:</B> ";
	$autogentxtbyindi[tag505][first][1]="<B>Incomplete Contents:</B> ";
	$autogentxtbyindi[tag505][first][2]="<B>Partial Contents:</B> ";

//save for recent view
$historyviewbiblist=sessionval_get("historyviewbiblist");
$historyviewbiblist=unserialize($historyviewbiblist);
$historyviewbiblist[]=$ID;
$historyviewbiblist=array_unique($historyviewbiblist);
$historyviewbiblist=serialize($historyviewbiblist);
sessionval_set("historyviewbiblist",$historyviewbiblist);
//save for recent view e

$r=marc_melt($ID,"yes");

$authdb=tmq_dump2("authoritydb_rule","id","fid,workonmarctag,pullfromtag,checkmode");

/*
echo "<PRE>";
print_r($r);
echo "</PRE>";
*/
$coverstr="";
$cov=tmq("select * from media_ftitems where mid='$ID' and fttype='cover' order by text ");
if (tmq_num_rows($cov)!=0) {
	$coverstr.="<table width=150 border=1 align=center cellpadding=1 
cellspacing=1 class=table_border>
	<TR>
		<TD class=table_head>". getlang("ภาพปก::l::Cover")."</TD>
	</TR>
	<TR>
		<TD class=table_td align=center><table >
<tr>";

	$covi=0;
	while ($covr=tfa($cov)) {

		$covi++;
		$coverstr.= "<TR><td>";
		if($covr[uploadtype]=="url") {
			$covurl=$covr[filename];
		} else {
			$covurl="$dcrURL/_fulltext/$covr[fttype]/$covr[mid]/$covr[filename]";
		}
		 $coverstr.= "<A HREF='$dcrURL/dublin.linkout.php?url=".urlencode($covurl)."' target=_top><img src='$covurl' border=1 style='border-color:black' width=120 hspace=3 vspace=0
		 noclass='reflect'></A>";
		 $coverstr.= "</td></TR>";
	}
	$coverstr.="</tr></table></TD>
	</TR>
	</TABLE>";
} else {
	$tags=tmq("select * from media where ID='$ID' ");
	$tags=tmq_fetch_array($tags);
	$covinfo=get_coverbyinfo($tags,"style='float: left;' width=120 hspace=3 vspace=0 noclass='reflect' ");
	if ($covinfo[ispass]=="yes") {
		$covi=1;
		$coverstr.="<table width=150 border=0 aalign=center cellpadding=1 
	cellspacing=1 class=table_border><TR>	<TD class=table_head>". getlang("ภาพปก::l::Cover")."</TD>	</TR>
		<TR>	<TD class=table_td align=center><table ><tr>";
			$coverstr.= "<td>";
			$covurl="$dcrURL/_fulltext/$covr[fttype]/$covr[mid]/$covr[filename]";
			$coverstr.=$covinfo[html];
			$coverstr.= "</td>";
		$coverstr.="</tr></table></TD>
		</TR>
		</TABLE>";
	}
}

   //"_SETTING","serialcoverfromft" s
   $serialcoverfromft=trim(strtolower(getval("_SETTING","serialcoverfromft")));
   if ($serialcoverfromft=="yes" && $coverstr=="") {
      $sb1="SELECT *  FROM media_mid where pid='$ID' ";	
      $sb1="$sb1 order by jenum_1 desc,jenum_2 desc,jenum_3 desc,jenum_4 desc,jenum_5 desc,jenum_6 desc,id desc";
      $sql1 ="$sb1" ; 
      $result = tmq($sql1,false);
      while ($row = tmq_fetch_array($result)) {
         $keyid="SERIAL-$row[pid]-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[calln]";

         $serialcoverfromfts=tmq("select * from globalupload where keyid = '$keyid' and (substr(ctt,1,5)='image') order by filename asc limit 1 ",false);
         if (tnr($serialcoverfromfts)!=0) {
            $serialcoverfromftr=tfa($serialcoverfromfts);
      		if ($reflect=="yes") { 
      			$coverstr.=" class='reflect' ";
      		}
      		//$coverstr.=" $addition_html";
            $covi=$covi+1;
      		$coverstr.="<table width=150 border=0 aalign=center cellpadding=1 
      	cellspacing=1 class=table_border><TR>	<TD class=table_head>". getlang("ภาพปก::l::Cover")."</TD>	</TR>
      		<TR>	<TD class=table_td align=center><table ><tr>";
      			$coverstr.= "<td>";
      			$covurl="$dcrURL/_globalupload/".$serialcoverfromftr[keyid]."/".$serialcoverfromftr[hidename]."";
      			$coverstr.= "<A HREF='$dcrURL/dublin.linkout.php?url=".urlencode($covurl)."' target=_top><img src='$covurl' border=1 style='border-color:black' width=120 hspace=3 vspace=0
		 noclass='reflect'></A></td>";
      		$coverstr.="</tr></table></TD>
      		</TR>	</TABLE>";
            break;
         }
      }

   }   
   //"_SETTING","serialcoverfromft" e
   
$covertdcss="";
if ($coverstr=="") {
	$covertdcss=" style='display:none' ";
}
$retstr="<TABLE  width='".($_TBWIDTH-15)."' border=0 align=center cellpadding=0 
cellspacing=2>
<TR valign=top>
	<TD $covertdcss align=right>$coverstr</TD>
	<TD><!-- startcovertable -->";
	$marctablew=$_TBWIDTH-24;//765;
	if ($covi!=0) {
		$marctablew=$_TBWIDTH-180;//610;
	}
$retstr.="<table bgcolor=darkgray width='$marctablew' border=1 align=center cellpadding=1 
cellspacing=1 bordercolor=#f5f5f5  class=table_borderhtmlbibdsp>";

                                        $sql82="select * from bkdsp order by ordr";
                                        $result=tmq($sql82);
										echo tmq_error();
                                        while ($rowd=tmq_fetch_array($result))
                                            {
if (trim($rowd[boundwith])=="") {
	$rowd[boundwith]="all";
	$r["all_num"]=1;
}

/*
echo"<TABLE>
	<TR>
		<TD><PRE>";
print_r($r_2);
	echo"</PRE></TD>
	</TR>
	</TABLE>";
			echo "<PRE>"."$rowd[boundwith]_num"."=[".$r["$rowd[boundwith]_num"]."]</PRE>";
			*/

for ($multiloop=1;$multiloop<=$r["$rowd[boundwith]_num"];$multiloop++) { 

			$x = str_replace("$","$",$rowd[val]);

			$r_orig=$r;
			$userkey="";
			if ($multiloop!=1) {
				$userkey="_$multiloop";
			}
			eval("\$fulldata=\$r$userkey;");
			//fix ie
         $fulldata=str_replace('""',"",$fulldata);
         
			//echo("\$fulldata=\$r$userkey;<BR>");
			//echo("<B>\$r=\$r$userkey</B><BR>$x<BR>");
			$x=str_replace("\$r[","\$fulldata[",$x);
			$x=addslashes($x);
			//printr("-".$fulldata[tag520_indi]."-");
			//printr($fulldata);
			eval("\$str = \"$x\";");
			//echo("\$str = \"$x\";");
			//unset($fulldata);
			$r=$r_orig;
			$str=stripslashes($str);
			//echo "[$str]";
			$x2=explodenewline($str);
			$x3=Array();
			foreach ($x2 as $key => $value) {
				$rowd[boundwith]=trim($rowd[boundwith]);
				$autogentxtbyindi_val1="";
				$autogentxtbyindi_val2="";
				if (count($autogentxtbyindi[$rowd[boundwith]])>0) {
					$first_indi=substr($fulldata[$rowd[boundwith]."_indi"],0,1);
					$second_indi=substr($fulldata[$rowd[boundwith]."_indi"],1,1);
					if ($first_indi==" ") {$first_indi="blank";}
					if ($second_indi==" ") {$second_indi="blank";}
					$autogentxtbyindi_val1=$autogentxtbyindi[$rowd[boundwith]][first][$first_indi];
					$autogentxtbyindi_val2=$autogentxtbyindi[$rowd[boundwith]][second][$second_indi];
				}

				$newval="$value";
				if (strlen($newval)==2) {
					$newval='';
				}
				$newval=hidemarc($newval,$rowd[hidefid],$rowd[linksubf]);
				//echo "<PRE>[$newval]</PRE>";
				$newval=dspmarc($newval,$rowd[replacewith]);
				//hide string with limit count
				 if ($rowd[hidestr]!="") {
					  $tmp=explode(",",$rowd[hidestr]);
					  foreach ($tmp as $tmp2) {
						  $tmp3=explode("=",$tmp2);
						  if (!isset($tmp3[2])) {
							$tmp3[2]=0;
						  }
						  $count=intval($tmp3[2]);
							//echo "<PRE>str_replace2($tmp3[0],$tmp3[1],$newval,$count);</PRE>";
						  $newval=str_replace2($tmp3[0],$tmp3[1],$newval,$count);
					  }
				 }
				$newval=trim($newval,$rowd[trimthis]);
				if ($rowd[linkrow]!="") {
					$newval="<A HREF=\"$rowd[linkrow]".strip_tags((($newval)))."\" target=_top>".$newval."</A>";
					//echo "[$dcrURL]";
					//echo "[$newval]";
					$newval=str_replace("[dcr]","$dcrURL",$newval);
				}

//authdb s
$newvalorig=$newval;
@reset($authdb);
//printr($authdb);
while (list($authdbk,$authdbv)=each($authdb)) {
	if (trim(strip_tags($newvalorig))!="") { 
		//printr($authdbv);
		$authpospos = strpos(",,,$authdbv[1],,,", $rowd[boundwith]);
		if ($authpospos === false) {
			//notfound
			//$retstr.= "notfound  strpos(,,,$authdbv[1],,,, $rowd[boundwith]); $authdbv[1] <br>";
		} else {
			//$newval.= "found $authdbv[1] <br>";
			$auths=tmq("select * from authoritydb where $authdbv[0] like '%".addslashes(trim(strip_tags($newvalorig)," .-*/"))."%' ",false);
//			$auths=tmq("select * from authoritydb where $authdbv[2] like '%".addslashes(trim(strip_tags($newvalorig)))."%' ",false);
			$authresults=Array();
			while ($authsr=tfa($auths)) {
            //printr($authsr);
				///$authresults[str_remspecialsign($authdbv[3])]=$authresults[str_remspecialsign($authdbv[3])]."\n".$authsr[$authdbv[2]];
				$authresults[($authdbv[3])]=$authresults[($authdbv[3])]."\n".$authsr[$authdbv[2]];
				//$newval.= "$authdbv[2] : ".stripslashes($authsr[$authdbv[2]])."<br>";
			}
			@reset($authresults);
			while (list($authresultsk,$authresultsv)=each($authresults)) {
				$authresulti=explodenewline($authresultsv);
				$authresulti=arr_filter_remnull($authresulti);
				if (count($authresulti)>0) {
				$newval.="<form method=get target=_top action='$dcrURL"."searching.php' style=\"display: inline-block; margin: 0px 0px 0px 0px; \"> <select name='MDESCRIPTION' style=\"display: inline-block; border: 0px solid black!important; font-size: 12px;background-image:none!important;margin: 0px 0px 0px 0px; width: 100px;;\" onchange=\"this.form.submit(); \"><option value='' selected >$authdbv[3] :";
					while (list($authresultik,$authresultiv)=each($authresulti)) {
						$authresultiv=substr($authresultiv,2);
						$authresultiv=marc_getsubfields($authresultiv,"no");
						$authresultiv=$authresultiv[a];
						$authresultiv=trim($authresultiv," .");
						$newval.= " <option value='".str_replace("--"," ",((trim(strip_tags(dspmarc($authresultiv))))))."'>".stripslashes($authresultiv)."";
					}
					$newval.="</select></form>";
				}
			}
			//printr($authresults);
			//printr($auths_dest);

		}
	}
}
//$retstr.= "xxx";
//authdb e

				//$newval=hidemarc($newval,$rowd[hidefid],$rowd[hidestr],$rowd[trimthis]);
				$x3[]=$newval;
				//$x2[$key]=str_replace($value,$rowd[hidefid],$rowd[hidestr],$rowd[trimthis]);


			}

			unset($fulldata);

			//printr($x3);
			$str=implode($x3,"\n");
			$str=str_replace("\n\n","\n",$str);
			$str=trim($str);
			$str=trim($str,"\n");
			$str=str_replace("\n","<BR>",$str);
			//$str=hidemarc($str,$rowd[hidefid],$rowd[hidestr]);
			//echo "$x / -" . trim(dspmarc($str)) . "-";
			$str=dspmarc($str);
			//echo "[[$str]]";
			if (trim(strip_tags(trim($str)))!="") {
			$retstr.="<tr bgcolor=#f3f3f3 valign=top ><td width = 20% valign = top  class=table_headhtmlbibdsp style='text-align:right; font-weight: bold;'>&nbsp;<nobr>";

$retstr.= getlang($rowd[name]);
$retstr.="&nbsp;</nobr></td>
<td width =70%  class=table_tdhtmlbibdsp  style='text-align:left; padding-left: 4px;'>";
$str=str_replace("[dcr]","$dcrURL",$str);
//printr($systemhide);
//fulltext display
if ($systemhide[$rowd[boundwith]]=="yes") {
	$retstr.="<img border=0 align=absmiddle src='$dcrURL/neoimg/ulibfulltext.png' TITLE='ULIB - Fulltext management'> ";
}

$retstr.= $autogentxtbyindi_val1;
$retstr.= $autogentxtbyindi_val2;
if (strtolower($rowd[formatisn])=="yes") {
	//echo "[$str]";
	$str=str_formatisn($str);
}
$retstr.= $str;
//fix ie
$retstr=str_replace('""',"",$retstr);
//end fulltext display
$retstr.=" </td></tr>";
									
															}
                                            } // end multiloop
											}// end fetch array
$retstr.="</table>";


$retstr.="<!-- endcovertable --></TD>
</TR>
</TABLE>";

return $retstr;
}
?>