<?php 
function local_anyyesmember($wh) {
	@reset($wh);
	$res=false;
	while (list($k,$v)=@each($wh)) {
		//echo "$v";
		if ($v=="yes") {
			$res=true;
		} 
	}
	//echo "false";
	return $res;
}


function local_media_headtr() {
global $local_media_headtr_firsttime;
global $dcrURL;
if ($local_media_headtr_firsttime=="") {
?><SCRIPT LANGUAGE="JavaScript">
<!--
local_all_all=false;
function local_all(wh) {
//alert(wh);
	//x=document.forms["searchform"].getElementsByTagName("input");
		if (local_all_all==true)
		{
			local_all_all=false;
		} else {
			local_all_all=true;
		}
for (i = 0; i < wh.length; i++) {
		if (local_all_all==true)
		{
			wh[i].checked=local_all_all;
		} else {
			wh[i].checked=local_all_all;
		}
}

}

function local_swapitem(wh) {
	x=getobj(wh);
	if (x.checked==false) {
		x.checked=true;
	} else {
		x.checked=false;
	}
}
//-->
</SCRIPT>
<STYLE>
.searchtd_1_normal {
	background-color: #F5F5F5;
	cursor: hand; cursor: pointer;
	border-width: 0px; border-style: solid; border-color: #C8C8C8; border-top-width: 1px;
	border-bottom-width: 1px; border-bottom-color:  #FFFFFF;
}
.searchtd_1_over {
	cursor: hand; cursor: pointer;
	background-color: #FFAC00;
	border-width: 0px; border-style: solid; border-color: #FFA042; border-top-width: 1px;
	border-bottom-width: 1px;
}
.searchtd_2_normal {
	background-color: #FFFFFF;
	border-width: 0px; border-style: solid; border-color: #C8C8C8; border-top-width: 1px;
	border-bottom-width: 1px; border-bottom-color:  #FFFFFF;
}
.searchtd_2_over {
	background-color: #FFFBEC;
	border-width: 0px; border-style: solid; border-color: #FFA042; border-top-width: 1px;
	border-bottom-width: 1px;
}
.searchtd_3_normal {
	background-color: #FFFFFF;
	border-width: 0px; 
}
</STYLE>
<?php 
}
$local_media_headtr_firsttime="no";
?>
<tr bgcolor = "#ffffff">
      <td width = "20" align = center class=table_head>
<IMG SRC="<?php echo $dcrURL;?>neoimg/Checkmark.gif" WIDTH="16" HEIGHT="16" BORDER="0" onclick="local_all(document.forms['searchform']['marksave[]'])" style="cursor: hand; cursor: pointer;"></td>

      <td  align = center width=690  class=table_head><?php  echo getlang("ผลการค้นหา::l::Search results"); ?></td>

      <td width = "90" class=table_head><nobr><?php  echo getlang("เลขเรียก::l::CallNumber"); ?></font></td>

  </tr>
<?php 
}


function search_inc_media($row) {
//echo strtolower(getval("_SETTING","webhidecallnboxatresultlist"));
global $_ISULIBHAVESTER;
global $_havestdb;
	global $i;
	global $_memid;
	global $shelvesdb;
	global $remoteindexmap;
	global $oairepdb;
	global $oairepdbcate;
	global $oairepdbcatename;
	global $is_bibratingenable;
	if ($is_bibratingenable=="") {
		$is_bibratingenable=barcodeval_get("bibrating-o-enable");
	}

	global $mdtypedb;
	global $libsitedb;
	  global $dcrURL;
	  global $dcrs;

	global $searchdb;
	global $searchworddb;
	global $startrow;	
//echo "[$dcrURL]";
	if ("$row[mid]"!=0 ) {
/////////////////////////////////////////////////////////////////////////////////////////////////
	$indexdb=tmq("select * from index_db where mid='$row[mid]' limit 1",false);
	$indexdb=tmq_fetch_array($indexdb);
	$jsid="jsid".randid();
	$smallfontsize="12px";
	$leftspace="<font style='font-size: $smallfontsize;'>&nbsp;&nbsp;&nbsp;</font>";


	$mPri=$row[mid];
	$tags=tmq("select * from media where id='$row[mid]' ");
	$tags=tmq_fetch_array($tags);

   //calln
   $tmp=marc_getsubfields($tags[tag260]);
	$mcalln=marc_getcalln($mPri," <BR>");
	$mcalln=str_replace('<BR><BR>','<BR>',$mcalln);
	$mcalln=trim($mcalln);
	//$mcalln=trim($mcalln,'<BR>');
	$mcalln=strip_tags($mcalln);
	//echo "[$mcalln]";
	
	$title=marc_getsubfields(mb_substr($tags[tag245],2));
	$mAuth=marc_getauth($mPri);
	//printr($title);
	$title=$title[a] . ' ' . $title[b];
	$title=trim($title);
	$title=trim($title,'.=/');
	$title_len=150;

	if ($title=="") {
	  $title=marc_gettitle($row[mid]);
		if ($title=="") {
		 $title="<i>".getlang("ไม่มีชื่อเรื่อง::l::No title")."</i>";
		}
	}
	$titlefull='';
	if (strlen($title)>($title_len+2)) {
		$titlefull=$title;
		//echo mb_internal_encoding() ;
		$title="".mb_substr($title,0,$title_len).'..';
	}

	//printr($searchdb);
	echo "<tr  valign=top ID='tr$jsid' 
	onmouseover=\"getobj('td1$jsid').className='searchtd_1_over';getobj('td2$jsid').className='searchtd_2_over'\" 
	onmouseout=\"getobj('td2$jsid').className='searchtd_2_normal';getobj('td1$jsid').className='searchtd_1_normal';getobj('td2$jsid').className='searchtd_2_normal'\"> "; 

	echo "<td ID='td1$jsid' class=searchtd_1_normal
		onclick=\"local_swapitem('chkbox$jsid');\"
		><INPUT TYPE=checkbox NAME='marksave[]' value='$row[mid]' style=\"border: 0;background-color: transparent\" ID='chkbox$jsid' onmousedown=\"local_swapitem('chkbox$jsid');;\"></td>";

	echo "<TD ID='td2$jsid' class=searchtd_2_normal";
	//echo strtolower(getval("_SETTING","webhidecallnboxatresultlist"));
if (strtolower(getval("_SETTING","webhidecallnboxatresultlist"))!="yes") {
   if (( trim($mcalln)!="" && trim($mcalln)!="&nbsp;")) {
      echo " colspan=1 ";
   } else {
      echo " colspan=2 ";
   }
} else {
   echo " colspan=2 ";
}


	echo ">";

//////////////
//echo res_cov_dsp($row[mid],$tags);
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
		$webreviewstr="&nbsp;<IMG SRC='$dcrURL"."neoimg/gicons/maps/ic_rate_review_grey600_24dp.png' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><B><FONT COLOR='#000066' style='font-size: 11px;'> ".getlang("มี review::l::Got review!")."</FONT></B>";
	}
//////////////
	if (barcodeval_get("webpage-o-upacnopopup")=="yes") {
		$tghtml=" target=_top ";
	} else {
		$tghtml=" target=_blank ";
	}
//////////////
echo res_cov_dsp($row[mid],$tags,"80","no","","float:left; margin-right: 5px;");
//////////////

	echo "

		<A  href='$dcrURL"."dublin.php?&f=dublin&ID=$mPri'  $tghtml TITLE=\"".addslashes($titlefull)."\" style='padding-left: 3px; ' target=_top>".stripslashes($title)."</A>$webreviewstr";


	//author
	$mAuth=trim($mAuth);

	$marctype=$tags[leader];
	$marctype=mb_substr($marctype,7,1);
	//echo "[$marctype]";
	$yea=$tags[tag008];
	$yea=mb_substr($yea,7,4);
	$yea=floor($yea);
	if ($yea<1000) {
		$yea="";
	}
	if ($mAuth!="" || $yea!="") {
		echo "<BR>".$leftspace;
	}

	echo "<FONT COLOR='#000000' style='font-size: $smallfontsize;'>";
	if ($mAuth!="") {
		echo "<A HREF=\"$dcrURL"."searching.php?MAUTHOR=".urlencode(strip_tags($mAuth))."&makeref=yes\" style='color: #34333E; font-size: $smallfontsize;' target=_top>$mAuth</A>";
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
	//echo "[".$indexdb[placelist]."]";
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
	$urlprefix=$dcrURL."dublin.linkout.php?url=";
//printr($tmp);
	if (count($tmp)<2 || trim($tmp[u])=='') {
		$tmp=marc_getsubfields($tags[tag856]);
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
			$dspurl=mb_substr($dspurl,0,$_len).'..';
		}
		echo "<BR><div style=\"display: inline-block; ; width: 340px;text-overflow:ellipsis; overflow: hidden;\"><nobr>
		
		$leftspace<A HREF='$urlprefix$tmp[u]' target=_blank title=\"$tmp[z]\" style='font-size: $smallfontsize; color: #279D00'><IMG SRC='$dcrURL"."neoimg/gicons/action/ic_book_grey600_24dp.png' WIDTH=12 HEIGHT=12 BORDER=0 ALT='Fulltext' align=absmiddle>$tmp[z] [$dspurl]</A></nobr></div>";
		if ($counteconn>1) {
			$counteconn--;
			echo "<FONT style='font-size: $smallfontsize; color: #575757'> (".getlang("มีอีก::l::more ")." $counteconn ".getlang("ลิงค์::l::Links").")</FONT>";
		}
		//echo "<FONT  COLOR=#660000>$tmp[u]</FONT> []";
	}
	echo " ";

   $ishavester=false;
   if ($_ISULIBHAVESTER=="yes") {
   	if (!is_array($_havestdb)) {
   		$_havestdb=tmq_dump2("ulibhavestlist","code","name,url,url_bibid");
   	}
   	$itd=tmq("select * from  media_havest_id where hashed='".addslashes($tags[keyid])."' ",false);
      if (tnr($itd)!=0) {
         $ishavester=true;
         $itdr=tfa($itd); //printr($itdr);
                  global $dcrs;
         	global $_havestdb;

         	if (!is_array($_havestdb)) {
         		$_havestdb=tmq_dump2("ulibhavestlist","code","name,url,url_bibid");
         	}
         	$itd=tmq("select * from  media_havest_id where hashed='".addslashes($tags[keyid])."' ");
         	?><BR><div style=""><?php
         	while ($itdr=tmq_fetch_array($itd)) {
         		$jsbid="box".randid();
         		//printr($itdr);
         		if ($_havestdb[$itdr[havestpid]][0]!="") {
         			?><div ID="<?php echo $jsbid;?>" style="display:block; border: 1px #FF9900 solid; font-size: 11; width: 70%; height: 30; padding: 2 2 2 2; margin: 1; float: right; cursor:hand;
         -moz-border-radius-topleft:3;
         -moz-border-radius-topright:3;
         -moz-border-radius-bottomright:3;
         -moz-border-radius-bottomleft:3;
         -webkit-border-top-left-radius:3;
         -webkit-border-top-right-radius:3;
         -webkit-border-bottom-left-radius:3;
         -webkit-border-bottom-right-radius:3;
         background-image:URL(<?php echo $dcrURL?>_havester/sv/extbg.png);
         background-repeat:no-repeat;
         background-position:right top; 
         "
         			onclick="window.open('<?php
         				$tmpbiburl=str_replace('[bibid]',$itdr[bibid],$_havestdb[$itdr[havestpid]][2]);
         				echo  $tmpbiburl;
         			?>');";
         			onmouseover="this.style.backgroundColor='#FFCC00';"
         			onmouseout="this.style.backgroundColor='';"><FONT style="font-size: 13"> <img src="<?php echo $dcrURL?>neoimg/icon_external.png" align=baseline hspace=3><img border=0 width=16 height=16 align=absmiddle src='<?php
         	if (file_exists("$dcrs/_tmp/havestclientlogo-$itdr[havestpid].png")==true) {
         		echo "$dcrURL/_tmp/havestclientlogo-$itdr[havestpid].png";
         	}  else {
         		echo  "$dcrURL/_tmp/mediatype.png";
         	}
         ?>'><?php echo $_havestdb[$itdr[havestpid]][0];?></FONT> <div ID='loading<?php echo $jsbid?>'><img width=10 height=10 border=0 src="<?php echo $dcrURL?>_havester/sv/small_loading.gif"></div></div>
         <SCRIPT LANGUAGE="JavaScript">
         <!--
         if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
         	xmlhttp<?php echo $jsbid?>=new XMLHttpRequest();
         } else{// code for IE6, IE5
         	xmlhttp<?php echo $jsbid?>=new ActiveXObject("Microsoft.XMLHTTP");
         }
         xmlhttp<?php echo $jsbid?>.onreadystatechange=function() {
         	if (xmlhttp<?php echo $jsbid?>.readyState==4 && xmlhttp<?php echo $jsbid?>.status==200) {
         		//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
         		tmp1=getobj("loading<?php echo $jsbid?>");
         		tmp1.style.display="none";
         		tmp=getobj("<?php echo $jsbid?>");
         		tmpstrres=xmlhttp<?php echo $jsbid?>.responseText+"";
         		tmpstrres=""+mydecode(tmpstrres)+"";
         		tmp.innerHTML=tmp.innerHTML+" <BR><FONT style='font-size: 11'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+tmpstrres+"</FONT>";
         		/*
         		tmpstrres="99"+mydecode(tmpstrres)+"66";
         		//alert(tmpstrres);
         		tmp.innerHTML=tmp.innerHTML+" ["+tmpstrres+"]";
         		*/
         	}
         }
         xmlhttp<?php  echo $jsbid?>.open("GET","<?php echo $dcrURL?>globalpuller.php?charset=UTF-8&url=<?php echo urlencode($_havestdb[$itdr[havestpid]][1]."/_havester/cli/bibstatus.php?bibid=$itdr[bibid]" );?>",true);
         xmlhttp<?php echo $jsbid?>.send();
         //-->
         </SCRIPT>
         			<?php
         		}
         	}
         	?></div><?php
      }
   }

	$itdstr="";
   if ($ishavester==false) {
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
    			 $itdstr=get_noitemstr($marctype);//"ไม่มีไอเทมให้บริการ";
    		} else {
    			if ($itdok==0 && $itdcheckedout!=0) {
    			 $itdstr=getlang("ทุกไอเทมถูกยืมอยู่ ($itdcheckedout ไอเทม) " .
    			 "::l::All items has beec borrowed ($itdcheckedout)"); 
    			}
    			if ($itdok!=0 && $itdcheckedout==0) {
    			 $itdstr=getlang("ทุกไอเทมพร้อมให้บริการ (มี $itdok ไอเทม)".
    			 "::l::All item ready");; 
    			}
    			if ($itdok!=0 && $itdcheckedout!=0) {
    			 $itdstr=getlang("มี $itdok พร้อมให้บริการ และ $itdcheckedout ไอเทมถูกยืม (มี ".($itdok+$itdcheckedout)." ไอเทม)".
    			 "::l::$itdok ready, $itdcheckedout borrowed"); 
    			}
    		}
    		$itdstr=trim($itdstr);
    		if ($itdstr!="") {
    			 echo "<BR>$leftspace<font style='font-size: 12px; color: #333333;'><img src='$dcrURL"."/neoimg/gicons/action/ic_info_outline_black_24dp.png' width=12 height=12 align=absmiddle border=0> $itdstr</font>";
    		}
    	}	
	}
	?>
	<div style="position: relative; width: 100%; border: 0px solid blue; text-align: right; pointer-events: none;">
   	<div style="float:right; border: 0px solid red; position: absolute; width: 40%; text-align: right; vertical-align: bottom; bottom:0; right:0; pointer-events: auto ;" class=smaller2><?php 
   	////////////
   	$urltologin=$dcrURL."member/?backto=".urlencode("$dcrURL/dublin.php?ID=$row[mid]");
if ($is_bibratingenable=="yes") {
	$ratedb=tmq("select * from webpage_bibrating_sum where bibid='$row[mid]' ");
	if (tmq_num_rows($ratedb)!=0) {
		$ratedb=tmq_fetch_array($ratedb);
		$scoredsp=number_format($ratedb[votescore],1);
		$scoretxt=floor(($ratedb[votescore]*20)/5);
		$scorecounttxt=number_format($ratedb[votecount]);
		$scoretxt=floor($scoretxt*5);

		?>
		 <img width='16' height=16 align=baseline src='<?php  echo $dcrURL?>/neoimg/bibrating/s<?php  echo $scoretxt?>.png'
		 TITLE="Rated: <?php  echo $scoredsp;?>/<?php  echo $scorecounttxt;?>"">
		<?php 
	}
}
if ($_memid!="") { 
   $favbook=tmq("select * from webpage_memfavbook where memid='$_memid' and bibid='$row[mid]' ");	
   if (tmq_num_rows($favbook)==0) {
   	?><a href="<?php echo $dcrURL."member/mainadmin.php?mempagemode=favbook&addfavbook=$row[mid]";?>" target=_blank>
   	<img src="<?php echo $dcrURL;?>neoimg/gicons/action/ic_favorite_outline_grey600_24dp.png" border=0 width=16 height=16 align=baseline
   	 TITLE="<?php 
         echo getlang("เพิ่มเล่มนี้ไว้ในรายการโปรด?::l::Add this to Favourite List");
      ?>" onclick="return confirm('<?php echo getlang("เพิ่มเล่มนี้ไว้ในรายการโปรด?::l::Add this to Favourite List?"); ?>');"><?php
   } else {
   	?><a href="<?php echo $dcrURL."member/mainadmin.php?mempagemode=favbook";?>" target=_top>
   	<img src="<?php echo $dcrURL;?>neoimg/gicons/action/ic_favorite_grey600_24dp.png" border=0 width=16 height=16 TITLE="<?php 
         echo getlang("เล่มนี้คือหนึ่งในรายการโปรดของคุณ::l::This is one of your Favourite List");
      ?>"><?php
   }
} else {
   ?><a href="<?php echo $urltologin;?>" target=_top>
   <img src="<?php echo $dcrURL;?>neoimg/gicons/action/ic_favorite_outline_grey600_24dp.png" border=0 width=16 height=16 TITLE="<?php 
      echo getlang("ล็อกอินเพื่อจัดการหนังสือเล่มโปรด::l::Login to manage favourite books");
   ?>"><?php
}
if (barcodeval_get("webpage-o-viewbib_emailtome")=="yes") {?>
 <A href='<?php echo $dcrURL?>dublin.emailme.php?id=<?php  echo $row[mid]?>' style='color:#173960' target=_blank><img src="<?php echo $dcrURL;?>neoimg/gicons/communication/ic_email_grey600_24dp.png" border=0 width=16 height=16 TITLE="<?php 
      echo getlang("E-mail record");
   ?>"></a> <?php
}
if (barcodeval_get("oss-o-isopen") == "yes") {
   $ossname= getlang(barcodeval_get("oss-o-name"));
   if ($_memid!="") { 
      ?><a href="<?php echo $dcrURL."OSS/landing.php?bibid=$row[mid]";?>" target=_blank>
      <img src="<?php echo $dcrURL;?>neoimg/gicons/image/ic_center_focus_weak_grey600_24dp.png" border=0 width=16 height=16 TITLE="<?php 
         echo $ossname;
      ?>"><?php
   } else {
      ?><a href="<?php echo $dcrURL."member/?backto=".urlencode($dcrURL."OSS/landing.php?bibid=$row[mid]");?>" target=_blank>
      <img src="<?php echo $dcrURL;?>neoimg/gicons/image/ic_center_focus_weak_grey600_24dp.png" border=0 width=16 height=16 TITLE="<?php 
         echo getlang("ล็อกอินเพื่อใช้บริการ::l::Login to use").":".$ossname;
      ?>"><?php
   }
}
//////////////
   	?></div>
	</div>
	<?php

	echo "</td>";
;
//echo getval("_SETTING","webhidecallnboxatresultlist");
if (strtolower(getval("_SETTING","webhidecallnboxatresultlist"))!="yes") {
   if (( trim($mcalln)!="" && trim($mcalln)!="&nbsp;")) {
   	echo "<td valign=top class=searchtd_3_normal>";
   	//echo "[$mcalln]";
   	//$mcalln=explode('<BR>',$mcalln);
   	//$mcalln=$mcalln[0];
   	if (strtolower(mb_substr($mcalln,0,4))=="<br>") {
   		 $mcalln=mb_substr($mcalln,4);
   	}
      //	$mcalln=str_replace2("<BR>","",$mcalln,"1");
   	?><TABLE  style='width: 90px' cellpadding=2 cellspacing=2 border=0 height=80>
   	<TR>
   		<TD valign=top style="border-width: 0px; border-style: solid; border-color: #FF9900; border-right-width: 1px; border-bottom-width: 1px; background-image: url(<?php  echo $dcrURL; ?>neoimg/search.calln.png); padding-top: 5px; padding-left: 10px; font-size: 13px;" >
   		<?php  echo $mcalln;?>&nbsp;</TD>
   	</TR>
   	</TABLE><?php 
   	echo "</td>";
   } else {
   }
} else {
   //echo " colspan=2 ";
}



	echo "</tr>";
	} else { // remote index

	/////////////////////////////////////////////////////////////////////////////////////////////////
	//printr($row);
	$indexdb=tmq("select * from index_db where id='$row[id]' ",false);
	$indexdb=tmq_fetch_array($indexdb);
	if (mb_substr($indexdb[remoteindex],0,4)=="oai-") {
		$oaiid=substr($indexdb[remoteindex],4);
	/////////////////////////////////////////////////////////////////////////////////////////////////
	// oai s

		// remoteindex s
	$jsid="jsid".randid();
	$leftspace="<font style='font-size: $smallfontsize;'>&nbsp;&nbsp;&nbsp;</font>";
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

	echo "<TD ID='td2$jsid' class=searchtd_2_normal colspan=2>";

	if (count($oairepdb)<1) {
		$oairepdb=tmq_dump2("oai_repo","code","name");
	}
	if (count($oairepdbcate)<1) {
		$oairepdbcate=tmq_dump2("oai_repo","code","cate");
	}
	if (count($oairepdbcatename)<1) {
		$oairepdbcatename=tmq_dump2("oai_repocate","code","name");
	}

	echo "<img src='";
		if (file_exists($dcrs."_tmp/oaiimg/$oaiid.png")) {
			echo $dcrURL."_tmp/oaiimg/$oaiid.png";
		} else {
			echo $dcrURL."_tmp/oaiimg/default.png";
	
		}
		echo "' border=1 style='border-color:black; float: left;' width=80 hspace=0 vspace=0>";
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
	echo "<A  href='$dcrURL/dublinoai.php?&mode=viewrecord&mid=$indexdb[id]'  $tghtml TITLE=\"".addslashes($titlefull)."\" style='padding-left: 3px;'><U>".$title."</U></A>$webreviewstr";


	//author
	$mAuth=trim($indexdb[auth]);

	if ($mAuth!="") {
		echo "<BR>".$leftspace;
	}

	echo "<FONT COLOR='#000000' style='font-size: $smallfontsize;'>";
	if ($mAuth!="") {
		echo "<A HREF=\"$dcrURL"."searching.php?MAUTHOR=".urlencode(strip_tags(str_remspecialsign($mAuth,' ')))."&makeref=yes\" style='color: #34333E; font-size: $smallfontsize;' target=_top>".str_remspecialsign($mAuth,' ')."</A>";
	}
	echo "</FONT>";

	echo "<FONT COLOR='#646464' style='font-size: $smallfontsize;'>";
	//printr($remoteindexmapdb);
	//echo "$indexdb[remoteindex]";
	echo "<BR><BR>$leftspace<img src='$dcrURL/neoimg/icon_external.png' hspace=2 border=0 align=absmiddle TITLE='".getlang("จากฐานข้อมูลภายนอก::l::From external database").":".getlang($oairepdb[$oaiid])."'>".getlang("จากฐานข้อมูลภายนอก::l::From external database").': '.getlang($oairepdb[$oaiid]);
	//printr($oairepdb);
	//echo "[$oaiid]";
	$tmprepocatename=trim(getlang($oairepdbcatename[$oairepdbcate[$oaiid]]));
	if ($tmprepocatename!="") {
	  echo " [$tmprepocatename]";
	}
	echo "</FONT>";

$ittt=($startrow) + $i;
	//         echo $mm_o;


	echo " ";

	
	
	echo "</td>";



	echo "</tr>";
	// oai e
	} else {
		////////////////////////////////////////////////////////
		// remoteindex s
	$jsid="jsid".randid();
	$leftspace="<font style='font-size: $smallfontsize;'>&nbsp;&nbsp;&nbsp;</font>";
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
				//printr( $remoteindexmapdb[$mv[0]] );
				//echo $mv[0];
			}
		}
	}

	$baseu_r_l=rtrim($remoteindexmapdb["$indexdb[remoteindex]"][1],'/');

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
	echo "<A  href='$baseu_r_l/index.php?&mode=viewrecord&mid=$indexdb[remoteindex_ref]'  $tghtml TITLE=\"".addslashes($titlefull)."\" style='padding-left: 3px;' target=_top><U>".$title."</U></A>$webreviewstr";


	//author
	$mAuth=trim($indexdb[auth]);

	if ($mAuth!="") {
		echo "<BR>".$leftspace;
	}

	echo "<FONT COLOR='#000000' style='font-size: $smallfontsize;'>";
	if ($mAuth!="") {
		echo "<A HREF=\"$dcrURL"."searching.php?MAUTHOR=".urlencode(strip_tags(str_remspecialsign($mAuth,' ')))."&makeref=yes\" style='color: #34333E; font-size: $smallfontsize;'  target=_top>".str_remspecialsign($mAuth,' ')."</A>";
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
	}// remoteindex e

	}
	$i++;
	$s=$i - 1;
}

function local_getsearchnumcache($str) {
	$sqlstr=str_replace("select count(id) as cc from index_db where","",$str);
	//$sqlstr=str_replace("select count(id) as cc from index_db where","",$sqlstr);
	$sqlstr=str_replace(" ","",$sqlstr); 
	$sqlstr=addslashes($sqlstr);
	//tmq("delete from searchnumcache "); // force delete
	tmq("delete from searchnumcache where dt<".(time()-(60*15))); // 15 mins
	$chk=tmq("select * from searchnumcache where sqlstr='$sqlstr' ",false);
	if (tnr($chk)!=0) {
		$chk=tfa($chk);
      //echo "local_getsearchnumcache ret=$chk[cc]";
		return $chk[cc];
	}
	$s=tmq($str,false);
	$s=tfa($s);
	//echo "REFETCH";
	tmq("insert into searchnumcache set sqlstr='$sqlstr',cc='$s[cc]',dt=".time()." ");
   //echo "local_getsearchnumcache ret=$s[cc]";
	return $s[cc];
}
?>