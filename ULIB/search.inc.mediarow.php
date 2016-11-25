<?php 
function search_inc_media($row) {
	global $i;
	global $shelvesdb;
	global $remoteindexmap;
	global $is_bibratingenable;
	if ($is_bibratingenable=="") {
		$is_bibratingenable=barcodeval_get("bibrating-o-enable");
	}
	global $mdtypedb;
	global $libsitedb;
  global $dcrURL;

	global $searchdb;
	global $searchworddb;
	global $startrow;	
	if ("$row[mid]"!=0 ) {
/////////////////////////////////////////////////////////////////////////////////////////////////
	$indexdb=tmq("select * from index_db where mid='$row[mid]' ",false);
	$indexdb=tmq_fetch_array($indexdb);
	$jsid="jsid".randid();
	$leftspace="&nbsp;&nbsp;&nbsp;";
	$smallfontsize="12px";

	$mPri=$row[mid];
	$tags=tmq("select * from media where id='$row[mid]' ");
	$tags=tmq_fetch_array($tags);


	$title=marc_getsubfields(substr($tags[tag245],2));
	$mAuth=marc_getauth($mPri);
	//printr($title);
	$title=$title[a] . ' ' . $title[b];
	$title=trim($title);
	$title=trim($title,'.=/');
	$title_len=60;

	if ($title=="") {
	  $title=marc_gettitle($row[mid]);
		if ($title=="") {
		 $title="<i>".getlang("ไม่มีชื่อเรื่อง::l::No title")."</i>";
		}
	}
	$titlefull='';
	if (mb_strlen($title)>($title_len+2)) {
		$titlefull=$title;
		$title=mb_substr($title,0,$title_len).'..';
	}

	//printr($searchdb);
	echo "<tr  valign=top ID='tr$jsid' 
	onmouseover=\"getobj('td1$jsid').className='searchtd_1_over';getobj('td2$jsid').className='searchtd_2_over'\" 
	onmouseout=\"getobj('td2$jsid').className='searchtd_2_normal';getobj('td1$jsid').className='searchtd_1_normal';getobj('td2$jsid').className='searchtd_2_normal'\"> "; 

	echo "<td ID='td1$jsid' class=searchtd_1_normal
		onclick=\"local_swapitem('chkbox$jsid');\"
		><INPUT TYPE=checkbox NAME='marksave[]' value='$row[mid]' style=\"border: 0;background-color: transparent\" ID='chkbox$jsid' onmousedown=\"local_swapitem('chkbox$jsid');;\"></td>";

	echo "<TD ID='td2$jsid' class=searchtd_2_normal>";
////////////
if ($is_bibratingenable=="yes") {
	$ratedb=tmq("select * from webpage_bibrating_sum where bibid='$row[mid]' ");
	if (tmq_num_rows($ratedb)!=0) {
		$ratedb=tmq_fetch_array($ratedb);
		$scoredsp=number_format($ratedb[votescore],1);
		$scoretxt=floor(($ratedb[votescore]*20)/5);
		$scorecounttxt=number_format($ratedb[votecount]);
		$scoretxt=floor($scoretxt*5);

		?><div style="float:right; font-weight: normal; color: #725105; padding-left: 7px;" class=smaller2>Rated:
		<B class=smaller2><?php  echo $scoredsp;?></B>/<?php  echo $scorecounttxt;?> <img width='24' height=24 align=absmiddle src='<?php  echo $dcrURL?>/neoimg/bibrating/s<?php  echo $scoretxt?>.png'> </div><?php 
	}
}
//////////////
echo res_cov_dsp($row[mid],$tags);
//////////////
	$searchdb_kw=explode(' ',$searchdb[kw]);
	foreach ($searchdb_kw as $x) {
		$mAuth=str_replace($x,"<U>$x</U>",$mAuth);
		$title=str_replace($x,"<U>$x</U>",$title);
	}
	$searchdb_au=explode(' ',$searchdb[au]);
	foreach ($searchdb_au as $x) {
		$title=str_replace($x,"<U>$x</U>",$title);
	}
	if (trim($title)=="") {
		 $title="<i>".getlang("ไม่มีชื่อเรื่อง::l::Untitled")."</i>";
	}
//////////////
	$webreview=tmq("select * from webpage_showcase where mid='$mPri' ",false);
	$webreviewstr="";
	if (tmq_num_rows($webreview)!=0) {
		$webreviewstr="&nbsp;<IMG SRC='./neoimg/reviewicon.png' WIDTH='20' HEIGHT='20' BORDER='0' align=absmiddle><B><FONT COLOR='#000066' style='font-size: 11px;'> ".getlang("มี review::l::Got review!")."</FONT></B>";
	}
//////////////
	if (barcodeval_get("webpage-o-upacnopopup")=="yes") {
		$tghtml=" ";
	} else {
		$tghtml=" target=_blank ";
	}
	echo "<A  href='dublin.php?&f=dublin&ID=$mPri'  $tghtml TITLE=\"".addslashes($titlefull)."\" style='padding-left: 3px;'><U>".$title."</U></A>$webreviewstr";


	//author
	$mAuth=trim($mAuth);

	$yea=$tags[tag008];
	$yea=substr($yea,7,4);
	$yea=floor($yea);
	if ($yea<1000) {
		$yea="";
	}
	if ($mAuth!="" || $yea!="") {
		echo "<BR>".$leftspace;
	}

	echo "<FONT COLOR='#000000' style='font-size: $smallfontsize;'>";
	if ($mAuth!="") {
		echo "<A HREF=\"searching.php?MAUTHOR=".urlencode(strip_tags($mAuth))."&makeref=yes\" style='color: #34333E; font-size: $smallfontsize;'>$mAuth</A>";
	}
	if ($yea!="") {
		echo " / $yea";
	}
	echo "</FONT>";

	echo "<FONT COLOR='#646464' style='font-size: $smallfontsize;'>";
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
	while (list($k,$v)=each($tmp)) {
		if ($v!="") {
			$tmpstr2.=getlang($shelvesdb[$v][0]).'('.getlang($libsitedb[$shelvesdb[$v][1]]).'),';
		}
	}
	$tmpstr2=trim($tmpstr2,',');


	if ($tmpstr1.$tmpstr2!="") {
		echo "<BR>$leftspace$tmpstr1";
		if ($tmpstr2!="") {
			echo " ".getlang("ที่::l::at")." $tmpstr2";
		}
	}
	echo "</FONT>";

$ittt=($startrow) + $i;
	//         echo $mm_o;




	$tmp=marc_getsubfields($tags[ulibtag856]);
	$urlprefix="";
//printr($tmp);
	if (count($tmp)<2 || trim($tmp[u])=='') {
		$tmp=marc_getsubfields($tags[tag856]);
		$urlprefix="dublin.linkout.php?url=";
		//$tmp[u]=urlencode($tmp[u]);
	}
	$counteconn=count(arr_filter_remnull(explodenewline(trim($tags[tag856]))))+count(arr_filter_remnull(explodenewline(trim($tags[ulibtag856]))));
	//printr($tmp);
//echo $row[tag856];
	if ($tmp[u]!=""){
		if ($tmp[z]=="") {
			$tmp[z]="E-connect";
		}
		$_len=30;
		$dspurl=$tmp[u];
		if (strlen($dspurl)>($_len+2)) {
			$dspurl=substr($dspurl,0,$_len).'..';
		}
		echo "<BR>$leftspace<A HREF='$urlprefix$tmp[u]' target=_blank title=\"$tmp[z]\" style='font-size: $smallfontsize; color: #279D00'><IMG SRC='neoimg/ebook.gif' WIDTH=19 HEIGHT=17 BORDER=0 ALT='Fulltext' align=absmiddle> $tmp[z] [$dspurl]</A>";
		if ($counteconn>1) {
			$counteconn--;
			echo "<FONT style='font-size: $smallfontsize; color: #575757'> (".getlang("มีอีก::l::more ")." $counteconn ".getlang("ลิงค์::l::Links").")</FONT>";
		}
		//echo "<FONT  COLOR=#660000>$tmp[u]</FONT> []";
	}
	echo " ";

	$itdstr="";
	if (barcodeval_get("webpage-o-upachideitem")=="yes") {
	} else {
		$itd=tmq("select * from media_mid where pid='$row[mid]' ");
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
			 $itdstr="ไม่มีไอเทมให้บริการ";
		} else {
			if ($itdok==0 && $itdcheckedout!=0) {
			 $itdstr="ทุกไอเทมถูกยืมอยู่ ($itdcheckedout ไอเทม)"; 
			}
			if ($itdok!=0 && $itdcheckedout==0) {
			 $itdstr="ทุกไอเทมพร้อมให้บริการ (มี $itdok ไอเทม)"; 
			}
			if ($itdok!=0 && $itdcheckedout!=0) {
			 $itdstr="มี $itdok พร้อมให้บริการ และ $itdcheckedout ไอเทมถูกยืม (มี ".($itdok+$itdcheckedout)." ไอเทม)"; 
			}
		}
		$itdstr=trim($itdstr);
		if ($itdstr!="") {
			 echo "<BR>$leftspace<font style='font-size: 12px; color: #333333;'><img src='./neoimg/Warning.gif' align=absmiddle border=0> $itdstr</font>";
		}
	}		
	
	
	echo "</td>";
	echo "<td valign=top class=searchtd_3_normal>";
	$tmp=marc_getsubfields($tags[tag260]);
	$mcalln=marc_getcalln($mPri,"<BR>");
	$mcalln=str_replace('<BR><BR>','<BR>',$mcalln);
	$mcalln=trim($mcalln);
	$mcalln=trim($mcalln,'<BR>');
	//echo "[$mcalln]";
	//$mcalln=explode('<BR>',$mcalln);
	//$mcalln=$mcalln[0];
	if (strtolower(substr($mcalln,0,4))=="<br>") {
		 $mcalln=substr($mcalln,4);
	}
//	$mcalln=str_replace2("<BR>","",$mcalln,"1");
	?><TABLE  style='width: 90px' cellpadding=2 cellspacing=2 border=0 height=80>
	<TR>
		<TD valign=top style="border-width: 0px; border-style: solid; border-color: #FF9900; border-right-width: 1px; border-bottom-width: 1px; background-image: url(./neoimg/search.calln.png); padding-top: 5px; padding-left: 10px; font-size: 13px;" ><?php  echo $mcalln;?>&nbsp;</TD>
	</TR>
	</TABLE><?php 
	echo "</td>";



	echo "</tr>";
	} else { // remote index
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//printr($row);
	$indexdb=tmq("select * from index_db where id='$row[id]' ",false);
	$indexdb=tmq_fetch_array($indexdb);

	$jsid="jsid".randid();
	$leftspace="&nbsp;&nbsp;&nbsp;";
	$smallfontsize="12px";

	$mPri=$row[mid];

	$title=stripslashes($indexdb[titl]);
	$mAuth=stripslashes($indexdb[auth]);
	//printr($title);

	$title_len=60;

	if ($title=="") {
		if ($title=="") {
		 $title="<i>".getlang("ไม่มีชื่อเรื่อง::l::No title")."</i>";
		}
	}
	$titlefull='';
	if (mb_strlen($title)>($title_len+2)) {
		$titlefull=$title;
		$title=mb_substr($title,0,$title_len).'..';
	}

	//printr($searchdb);
	echo "<tr  valign=top ID='tr$jsid' 
	onmouseover=\"getobj('td1$jsid').className='searchtd_1_over';getobj('td2$jsid').className='searchtd_2_over'\" 
	onmouseout=\"getobj('td2$jsid').className='searchtd_2_normal';getobj('td1$jsid').className='searchtd_1_normal';getobj('td2$jsid').className='searchtd_2_normal'\"> "; 

	echo "<td ID='td1$jsid' class=searchtd_1_normal
		onclick=\"local_swapitem('chkbox$jsid');\"
		><INPUT TYPE=checkbox NAME='marknosave[]' value='' style=\"display:none\" ID='chkbox$jsid' ></td>";

	echo "<TD ID='td2$jsid' class=searchtd_2_normal>";

	if (count($remoteindexmapdb)<1) {
		$remoteindexmap=getval("_SETTING","remoteindexmap");
		$remoteindexmap=explodenewline($remoteindexmap);
		@reset($remoteindexmap);
		$remoteindexmapdb=Array();
		while (list($mk,$mv)=each($remoteindexmap)) {
			$mv=explode('=',$mv);
			//printr($mv);
			$mv[1]=trim($mv[1]);
			if ($mv[1]!="" && $mv[0]!="") {
				$remoteindexmapdb[$mv[0]]=explode('%',stripslashes($mv[1]));
				//echo $mv[0];
			}
		}
	}

	$baseu_r_l=trim($remoteindexmapdb["$indexdb[remoteindex]"][1],'/');

		echo "<img src='$indexdb[remoteindex_cov]' border=1 style='border-color:black; float: left;' width=100 hspace=0 vspace=0>";
		//////////////
	$searchdb_kw=explode(' ',$searchdb[kw]);
	foreach ($searchdb_kw as $x) {
		$mAuth=str_replace($x,"<U>$x</U>",$mAuth);
		$title=str_replace($x,"<U>$x</U>",$title);
	}
	$searchdb_au=explode(' ',$searchdb[au]);
	foreach ($searchdb_au as $x) {
		$title=str_replace($x,"<U>$x</U>",$title);
	}
	if (trim($title)=="") {
		 $title="<i>".getlang("ไม่มีชื่อเรื่อง::l::Untitled")."</i>";
	}

	$tghtml=" target=_blank ";
	echo "<A  href='$baseu_r_l/index.php?&mode=viewrecord&mid=$indexdb[remoteindex_ref]'  $tghtml TITLE=\"".addslashes($titlefull)."\" style='padding-left: 3px;'><U>".$title."</U></A>$webreviewstr";


	//author
	$mAuth=trim($indexdb[auth]);

	if ($mAuth!="") {
		echo "<BR>".$leftspace;
	}

	echo "<FONT COLOR='#000000' style='font-size: $smallfontsize;'>";
	if ($mAuth!="") {
		echo "<A HREF=\"searching.php?MAUTHOR=".urlencode(strip_tags(str_remspecialsign($mAuth,' ')))."&makeref=yes\" style='color: #34333E; font-size: $smallfontsize;'>".str_remspecialsign($mAuth,' ')."</A>";
	}
	echo "</FONT>";

	echo "<FONT COLOR='#646464' style='font-size: $smallfontsize;'>";
	//printr($remoteindexmapdb);
	//echo "$indexdb[remoteindex]";
	echo "<BR><BR>$leftspace<img src='$dcrURL/neoimg/icon_external.png' hspace=2 border=0 align=absmiddle TITLE='".getlang("จากฐานข้อมูลภายนอก::l::From external database").":".getlang($remoteindexmapdb["$indexdb[remoteindex]"][0])."'>".getlang("จากฐานข้อมูลภายนอก::l::From external database").': '.getlang($remoteindexmapdb["$indexdb[remoteindex]"][0]);
	echo "</FONT>";

$ittt=($startrow) + $i;
	//         echo $mm_o;


	echo " ";

	
	
	echo "</td>";
	echo "<td valign=top class=searchtd_3_normal>";

//	$mcalln=str_replace2("<BR>","",$mcalln,"1");
	?><TABLE  style='width: 90px' cellpadding=2 cellspacing=2 border=0 height=80>
	<TR>
		<TD valign=top style="border-width: 0px; border-style: solid; border-color: #FF9900; border-right-width: 1px; border-bottom-width: 1px; background-image: url(./neoimg/search.calln.png); padding-top: 5px; padding-left: 10px; font-size: 13px;" ><img src="<?php  echo $baseu_r_l?>/_tmp/logo/_weblogoicon.png" hspace=0 vspace=0 border=0 width=70><?php  echo $mcalln;?>&nbsp;</TD>
	</TR>
	</TABLE><?php 
	echo "</td>";



	echo "</tr>";
	}
	$i++;
	$s=$i - 1;
}
?>