<?php 
;
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();
$libsitedb=tmq_dump2("library_site","code","name");
$startrow=floor($startrow);
//printr($_REQUEST);
?>


          <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3">
            <tr align="center">
              <td colspan="3">
			    <form name="form1" action="DBbook.php" method="post" >
			    <input type=hidden name=additionalfilter value="<?php  echo $additionalfilter;?>">
			  <TABLE cellspacing=0 cellpadding=2 width=<?php  echo $_TBWIDTH?>>
			  <TR>
			  	<TD colspan=9 bgcolor=e9e9e9><img 
src="../image/search.gif" width="18" height="15" hspace="4"><?php  echo getlang("ค้นหา::l::Search"); ?></TD>
</TR>
			  <TR>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>

			  	<TD><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?><BR>ISBN/ISSN<BR><?php  echo getlang("ผู้แต่ง::l::Author"); ?></TD>
				<TD>
				<input type="text" name="keyword" ID="keywordID" value="<?php  echo stripslashes($keyword);?>" size=15  style="border-color:darkred;border-left-width:3"><BR>
 <input type="text" name="isbn" ID="isbnID" value="<?php  echo stripslashes($isbn);?>" size=15 style="border-color:darkred;border-left-width:3"><BR>
 <input type="text" name="authorname" ID="authornameID" value="<?php  echo stripslashes($authorname);?>" size=15  style=";border-left-width:3">
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
				<TD>Call Number<BR>
				<?php  echo getlang("บาร์โค้ด::l::Barcode"); ?> <br />
				Bib. ID</TD>
				<TD>
<input type=text name=calln ID="callnID" value="<?php  echo $calln; ?>" size=15><br />
<input type=text name=sbc ID="sbcID" value="<?php  echo $sbc; ?>" size=15><br />
<input type=text name=sbib ID="sbibID" value="<?php  echo $sbib; ?>" size=15>
<input type=hidden name=fclimitmd ID="fclimitmdID" value="<?php  echo $fclimitmd; ?>" size=15>
<input type=hidden name=fclimitpl ID="fclimitplID" value="<?php  echo $fclimitpl; ?>" size=15>
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
<TD><input type="submit" name="Submit" value="<?php  echo getlang("ตกลง::l::Submit"); ?>"><BR>
<?php 
if ($keyword!="" || $sbc!="" || $search!="" || $calln!="" || $isbn!="" || $authorname!="" || $sbib!="" || $afilter!=""|| $fclimitmd!="" || $fclimitpl!="") {
   echo "<a href='$PHP_SELF' class='a_btn smaller'>".getlang("แสดงทั้งหมด::l::Show all")."</a>";
}
?>
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
<TD>
<a href="addDBbook.php?typeid=<?php  echo $typeid; ?>&faculty=<?php  echo $faculty; 
?>" class=a_btn><?php  echo getlang("เพิ่มรายการใหม่::l::Key new record"); ?></a><BR>
<a href="easyadd.php?typeid=<?php  echo $typeid; ?>&faculty=<?php  echo $faculty; 
?>" noonclick="return confirm('<?php  echo getlang("แน่ใจหรือที่จะใช้แบบฟอร์มกรอกแบบง่าย\\n\\nการกรอกแบบง่ายอาจได้ข้อมูลที่ไม่ถูกต้องตามมาตรฐาน \\nควรใช้เมื่อต้องการกรอกข้อมูลอย่างเร่งด่วน \\nและต้องทำการแก้ไขข้อมูลให้ถูกต้องตามมาตรฐานภายหลัง::l::Please confirm before use easy key new.\\n\\nEasy key new might incompatible with MARC standard\\nUse easy key new only in urgent situation\\nand must recorrect these record later.");?>');" class=a_btn><?php  echo getlang("คีย์รายการใหม่แบบ Non-MARC::l::Key new (Non-MARC)"); ?></a><BR>
<A HREF="parsemarc.php" class=a_btn><?php  echo getlang("วาง MARC::l::Parse MARC");?></A>
</TD>			  </TR>
			  </TABLE> 
		  </form>   
</td>
            </tr>
            <tr align="center">
              <td colspan="3">    <div align="left">
<?php 
	if ($IDEDIT!="") {
		 html_label('b',$IDEDIT);
	} elseif ($linkfrom!="") {
		 html_label('b',$linkfrom);
	}
?></div><?php 

    // หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT SQL_BIG_RESULT ID,LIBSITE,tag999,tag245,ispublish,(tag245 like '__$keyword%' or tag245 like '__^_$keyword%') as titlekw  FROM media where 1 ";
if ($sbc!="") {
	$s=tmq("select * from media_mid where bcode='$sbc' ");
	if (tmq_num_rows($s)!=0) {
   $sbclist="";
	while ($sbcr=tmq_fetch_array($s)) {
      $sbclist=$sbclist.",".$sbcr[pid];
	}
   $sbclist=trim($sbclist,", ");
	  $sql1="$sql1  and id in ($sbclist)";
	}
}
  if ($search=='wrongdc') {
	  /* UNDER CONSTRUCTION HERE*/
	$sql1="$sql1 and " . getval("stat","dc_tagname") . " not like '%^a%' ";
	$sql1="$sql1 or " . getval("stat","dc_tagname") . " not like '%^a___.%' ";
	$sql1="$sql1 or " . getval("stat","dc_tagname") . " not like '%^a% ___.%' ";
  }
  $keyword=str_replace("/"," ",$keyword);
  $keyword=str_replace(":"," ",$keyword);
  $keyword=str_replace("  "," ",$keyword);
  if ($keyword <> "") {
      //echo "<pre>[$keyword]</pre>";
		$sql1= "$sql1  ".ssql_for_raw($keyword,"titl");
      //echo "<pre>".ssql_for_raw($keyword,"titl")."</pre>";
  }
  if ($calln <> "") {
		$sql1= "$sql1  ".ssql_for_raw($calln,"index01","begin");
		//$sql1= "$sql1  ".ssql_for_raw("[[OR]] ".$calln,"index01");
  }
  if ($isbn <> "") {
    $sql1= "$sql1  ".ssql_for_raw($isbn,"isbn");
  }
  if ($authorname <> "") {
    $sql1= "$sql1  ".ssql_for_raw($authorname,"auth");
  }
  if ($sbib <> "") {
    $sql1= "$sql1  and ID='$sbib' ";
  }	
  if ($fclimitmd <> "") {
   $fclimitmduse=$fclimitmd;
    $sql1= "$sql1  and cachemdtype like '%,$fclimitmduse,%' ";
  }	
  if ($fclimitpl <> "") {
   $fclimitpluse=$fclimitpl;
    $sql1= "$sql1  and cacheplacelist like '%,$fclimitpluse,%' ";
  }	

//echo $sql1;
if ($isbn!="" || $keyword!="" || $authorname!="") {

			$addstr="".getlang("หากต้องการเพิ่มรายการใหม่ด้วยข้อมูลที่ท่านป้อน::l::Key new record with your entered information")." <A HREF=\"addDBbook.php?loadtitle=$keyword&loadisbn=$isbn&loadauth=$authorname\"> ".getlang("กรุณาคลิกที่นี่::l::Click here")."</A> : "."  <A HREF=\"easyadd.php?loadtitle=$keyword&loadisbn=$isbn&loadauth=$authorname\"> ".getlang("(การเพิ่มรายการแบบ Non-MARC)::l::(Non-MARC form)")."</A>";
			if (library_gotpermission("bibstream") && barcodeval_get("activateulib-refcode")!="") {
				$addstr.=" <br> <A HREF=\"../library.bibstream/index.php?kw=$keyword $isbn\"> ".getlang("ค้นหาด้วย BibStream::l::Search in bibStream")."</A>"; 
			}
}
	///$result=my sql_unbuffered_query($sql1);
         
?> 
<form method="get" action="<?php  echo $PHP_SELF;?>">
	<?php  echo getlang("การกรองเพิ่มเติม::l::Additional Filter")." ";
	$afilter=Array();
	$afilter[ld07s]=Array();
	$afilter[ld07s][name]=getlang("วารสาร::l::Serials");
	$afilter[ld07s][sql]=" substring(leader,8,1)='s' ";
	$afilter[ld07b]=Array();
	$afilter[ld07b][name]=getlang("บทความวารสาร::l::Journal Index");
	$afilter[ld07b][sql]=" substring(leader,8,1)='b' ";
	$afilter[unpublish]=Array();
	$afilter[unpublish][name]=getlang("รายการที่ไม่เผยแพร่::l::Unpublished");
	$afilter[unpublish][sql]="  ispublish<>'yes'  ";
	$afilter[publish]=Array();
	$afilter[publish][name]=getlang("รายการที่เผยแพร่::l::Published");
	$afilter[publish][sql]="  ispublish='yes'  ";
	$afilter[has856]=Array();
	$afilter[has856][name]=getlang("มีข้อมูลในแท็ก 856::l::with data in 856");
	$afilter[has856][sql]="  length(tag856)>6  ";
	$afilter[doesnthas856]=Array();
	$afilter[doesnthas856][name]=getlang("มี Fulltext::l::Has Fultlext");
	$afilter[doesnthas856][sql]="  length(ulibtag856)>6  ";
	$afilter[emptylibsite]=Array();
	$afilter[emptylibsite][name]=getlang("ไม่กำหนดสาขาห้องสมุด::l::No campus defined");
	$afilter[emptylibsite][sql]="  trim(LIBSITE)=''  ";

	$saf=tmq("select * from library_site");
	while ($safr=tfa($saf)) {
		$afilter["libsite_$safr[code]"]=Array();
		$afilter["libsite_$safr[code]"][name]=getlang("เป็นของสาขา::l::Campus").":".getlang($safr[name]);
		$afilter["libsite_$safr[code]"][sql]="  LIBSITE='$safr[code]'  ";
	}
	$saf=tmq("select * from media_fttype");
	while ($safr=tfa($saf)) {
		$afilter["fttype_$safr[code]"]=Array();
		$afilter["fttype_$safr[code]"][name]=getlang("ไฟล์แนบ::l::Files").":".getlang($safr[name]);
		$afilter["fttype_$safr[code]"][sql]="  ulibnote like '%,$safr[code],%'  ";
	}
	$afilter[webpageshowcase]=Array();
	$afilter[webpageshowcase][name]=getlang("แสดงที่หน้าหลัก::l::on showcase");
	$afilter[webpageshowcase][sql]="  webpageshowcase='yes'  ";
	
	@reset($afilter);
	?><select name="afilter" ID="afilter"  onchange="additionalfilterchange();">
		<option value="" ><?php  echo getlang("เลือกตัวกรอง::l::Choose filter");?>
		<?php 
		while (list($k,$v)=each($afilter)) {
			$afl="";
			if ($k==$additionalfilter) {
				$afl="selected";
			}
			?><option value="<?php  echo $k;?>" <?php  echo $afl;?>><?php  echo getlang($v[name]);?><?php 
		}
		?>
	</select>
	<script type="text/javascript">
	<!--
		function additionalfilterchange() {
			tmp=getobj("afilter").selectedIndex;
			tmp2 = getobj("afilter").options;
			newurl=tmp2[tmp].value;
			//alert(newurl); return;
			//keyword=$keyword&isbn=$isbn&sbc=$sbc&authorname=$authorname&additionalfilter=$additionalfilter&calln=$calln
			addparam="";
			addparam=addparam+"&keyword="+getobj("keywordID").value;
			addparam=addparam+"&isbn="+getobj("isbnID").value;
			addparam=addparam+"&sbc="+getobj("sbcID").value;
			addparam=addparam+"&authorname="+getobj("authornameID").value;
			addparam=addparam+"&calln="+getobj("callnID").value;
			addparam=addparam+"&fclimitmd="+getobj("fclimitmdID").value;
			addparam=addparam+"&fclimitpl="+getobj("fclimitplID").value;
			self.location=tmp="<?php  echo $dcrURL;?>library.book/DBbook.php?additionalfilter="+newurl+addparam;
		}
	//-->
	</script>
</form></div> 
<?php 
   echo "".getlang("เรียงลำดับ::l::Sort")."";
?> 
<select name=optionsort id=optionsort onchange="localoptionsortchage(this);">
<?php
$sortoptions=Array("bibid","bibiddesc","name","namedesc","auth","authdesc","calln","callndesc");
@reset($sortoptions);
$sorted=trim($sorted);
if ($sorted=="") {
   $sorted="bibiddesc";
}
$sortdsp=Array();
$sortdsp[none]=getlang("-");
$sortdsp[name]=getlang("ชื่อเรื่อง ก-ฮ::l::Title a-z");
$sortdsp[namedesc]=getlang("ชื่อเรื่อง ฮ-ก::l::Title z-a");
$sortdsp[auth]=getlang("ผู้แต่ง ก-ฮ::l::Author a-z");
$sortdsp[authdesc]=getlang("ผู้แต่ง ฮ-ก::l::Author z-a");
$sortdsp[bibid]=getlang("Bib.ID 0-9");
$sortdsp[bibiddesc]=getlang("Bib.ID 9-0");
$sortdsp[calln]=getlang("CallN 0-9");
$sortdsp[callndesc]=getlang("CallN 9-0");
while (list($k,$v)=each($sortoptions)) {
   $sl="";
   $vdsp=$sortdsp[$v];
   if ($sorted==$v) {
      $sl="selected checked";
   }
   echo "<option value='$v' $sl>$vdsp";
}
?>
</select> 
<script>
function localoptionsortchage(wh) {
   self.location="<?php echo $PHP_SELF;?>?<?php 
   echo "DBbook.php?keyword=$keyword&isbn=$isbn&sbc=$sbc&authorname=$authorname&additionalfilter=$additionalfilter&calln=$calln&fclimitmd=$fclimitmd&fclimitpl=$fclimitpl";
   ?>&sorted="+wh.options[wh.selectedIndex].value;
}
</script>
<?php 

//printr($afilter);
$additionalfilter=trim($additionalfilter);
if ($additionalfilter!="" && is_array($afilter[$additionalfilter])==true) {
	$sql1="$sql1
	 and " . $afilter[$additionalfilter][sql]. " ";
}
/*
if ($keyword <> "") {
	$sql1="$sql1 order by titlekw desc";
} else {
	$sql1="$sql1 order by id desc";
}*/
if ($sorted=="bibid") {
	$sql1="$sql1 order by id asc";
}
if ($sorted=="bibiddesc") {
	$sql1="$sql1 order by id desc";
}
if ($sorted=="name") {
	$sql1="$sql1 order by tag245 asc";
}
if ($sorted=="namedesc") {
	$sql1="$sql1 order by tag245 desc";
}
if ($sorted=="auth") {
	$sql1="$sql1 order by tag100 asc";
}
if ($sorted=="authdesc") {
	$sql1="$sql1 order by tag100 desc";
}
$MARCdspcallnum=getval("MARCdsp","callnum");
$MARCdspcallnum=trim($MARCdspcallnum," ,");
if ($sorted=="calln") {
   $MARCdspcallnum=str_replace(","," asc,",$MARCdspcallnum);
   $MARCdspcallnum=trim($MARCdspcallnum," ,");
	$sql1="$sql1 order by $MARCdspcallnum asc";
}
if ($sorted=="callndesc") {
   $MARCdspcallnum=str_replace(","," desc,",$MARCdspcallnum);
   $MARCdspcallnum=trim($MARCdspcallnum," ,");
	$sql1="$sql1 order by $MARCdspcallnum desc";
}

	//echo "<pre>".$sql1."</pre>";
    $result = tmqp($sql1,"DBbook.php?keyword=$keyword&isbn=$isbn&sbc=$sbc&authorname=$authorname&additionalfilter=$additionalfilter&calln=$calln&fclimitmd=$fclimitmd&fclimitpl=$fclimitpl&sorted=$sorted",$addstr);

?>
<!--  table for faucets-->
<table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" 
cellpadding="0" bgcolor=#ffffff> 
<tr valign=top>
<?php 
if (strtolower(getval("config","hidesystemlibfaucet"))!="yes") {
?>
<td width=180 style="background: #666666; padding: 2px 2px 2px 2px ; border-radius: 4px; 
-moz-border-radius: 4px; 
-webkit-border-radius: 4px; "><?php
$rsdb=tmq_dump2("media_type","code","name");
//$rsdbcc=tmq_dump2("media_type","code","cachelibfaucet");
if ($recalfaucet=="yes") { // recal only at first page
   $fcsql="select distinct RESOURCE_TYPE as ss, count(id) as cc from media_mid ";
   $fcsql.=" group by RESOURCE_TYPE order by cc desc";
   $fc=tmq($fcsql);
} else {
   $fcsql="select code as ss, cachelibfaucet as cc from media_type order by cachelibfaucet desc ";
   $fc=tmq($fcsql);

}
echo "<div style=\" display:inline-block; font-size: 15px; width: 100%; color: white; font-weight: bold;\">RESOURCE TYPE</div>";
   if ($recalfaucet=="yes") { 
      tmq("update media_type set cachelibfaucet='0' ;");
   }
   if (tnr($fc)==0) {
      echo "<div style=\" display:inline-block; font-size: 12px; width: 100%;";
      echo "background-color: #ffffff; color: darkgray; border-radius: 4px; 
-moz-border-radius: 4px; 
-webkit-border-radius: 4px; ";
      echo "\">";
      echo " - " .getlang("ไม่มีข้อมูล::l::No data")." - ";
      echo "</div>";
   }
while ($fcr=tfa($fc)) {
   if ($recalfaucet=="yes") { 
      tmq("update media_type set cachelibfaucet='$fcr[cc]' where code='$fcr[ss]' ;");
   }
   if (floor($fcr[cc])==0) continue;
   $tmprsname= getlang($rsdb[$fcr[ss]]);
   if (trim($tmprsname)=="") {
      $tmprsname="$fcr[ss]";
   }
   if ($fcr[ss]=="") {
      continue;
   }

   echo "<div style=\" display:inline-block; font-size: 12px; width: 100%;  border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; ";
   if ($fclimitmd==$fcr[ss]) {
      echo "background-color: #FFEFE8; color: black;";
   } else {
      echo "background-color: #ffffff; color: black;";
   }
   echo "\" >&nbsp;<a href=\"DBbook.php?keyword=$keyword&isbn=$isbn&sbc=$sbc&authorname=$authorname&additionalfilter=$additionalfilter&calln=$calln&fclimitpl=$fclimitpl&fclimitmd=$fcr[ss]\" target=_top 
   style='text-decoration: none; color: inherit;'>";
   echo $tmprsname;
   echo "</a> (";
   echo number_format($fcr[cc]);
   echo ")</div><BR>";
}
echo "<div style=\" display:inline-block; font-size: 15px; width: 100%; color: white; font-weight: bold;\">LOCATION</div>";
if ($recalfaucet=="yes") { // recal only at first page
   $fcsql="select distinct place as ss, count(id) as cc from media_mid ";
   $fcsql.=" group by place order by cc desc";
   $fc=tmq($fcsql);
} else {
   $fcsql="select code as ss, cachelibfaucet as cc from media_place order by cachelibfaucet desc";
   $fc=tmq($fcsql);
}
   if (tnr($fc)==0) {
      echo "<div style=\" display:inline-block; font-size: 12px; width: 100%;";
      echo "background-color: #ffffff; color: darkgray; border-radius: 4px; 
-moz-border-radius: 4px; 
-webkit-border-radius: 4px; ";
      echo "\">";
      echo " - " .getlang("ไม่มีข้อมูล::l::No data")." - ";
      echo "</div>";
   }
   
   if ($recalfaucet=="yes") { 
      tmq("update media_place set cachelibfaucet='0' ;");
   }
while ($fcr=tfa($fc)) { //printr($fcr);
   if ($recalfaucet=="yes") { 
      tmq("update media_place set cachelibfaucet='$fcr[cc]' where code='$fcr[ss]' ;");
   }
   if (floor($fcr[cc])==0) continue;
   $tmprsname= get_itemplace_name($fcr[ss]);
   if ($fcr[ss]=="") {
      continue;
   }
   echo "<div style=\" display:inline-block; font-size: 12px; width: 100%; border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; ";
   if ($fclimitpl==$fcr[ss]) {
      echo "background-color: #FFEFE8; color: black;";
   } else {
      echo "background-color: #ffffff; color: black;";
   }
   echo "\" >&nbsp;<a href=\"DBbook.php?keyword=$keyword&isbn=$isbn&sbc=$sbc&authorname=$authorname&additionalfilter=$additionalfilter&calln=$calln&fclimitmd=$fclimitmd&fclimitpl=$fcr[ss]\" target=_top 
   style='text-decoration: none; color: inherit;'>";
   echo $tmprsname;
   echo "</a> (";
   echo number_format($fcr[cc]);
   echo ")</div><BR>";

}
?></td>
<?php  } //is show faucets?>
<td>

<table width="<?php 
if (strtolower(getval("config","hidesystemlibfaucet"))!="yes") { 
   echo $_TBWIDTH-180;
} else {
   echo $_TBWIDTH;
}
?>" align=center border="0" cellspacing="1" 
cellpadding="3" bgcolor=#F9EA9F> 
<tr bgcolor="#A27100" class=table_head> 
	<td width="30"><?php  echo getlang("ลำดับ::l::No."); ?></td> 
	 <td><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?></td>
	<td width="23%"><?php  echo getlang("ลบ/แก้ไข/ดู::l::Delete/Edit/View"); ?></td> 
</tr> 
                  <?php  
       	/* */
		$i=1;  
$prev_recordtitle="+++++++++++++++++++++++++++++++++++++++++++";

 while($row = tmq_fetch_array($result)){ 

	$mID = $row[ID]; 
	//printr($row);
	if ($row[LIBSITE]=="") {
		$row[LIBSITE]=$LIBSITE;
		tmq("update media set LIBSITE='$LIBSITE' where ID='$row[ID]'  ",false);
	}


	$ittt = ($startrow)+$i; 
	if ($linkfrom==$mID)  {
			  echo "<tr bgcolor=#BFFFE6> "; 
	} else {
		if ($i%2==0) {
			  echo "<tr bgcolor=#FFF1BB> "; 
		} else {
			  echo " <tr bgcolor=#FFFFFF> "; 
		}	
	}
          $strtype= $row3[show];  
        // echo "$strtype ";  
            echo "<td><font face='MS Sans Serif' size=2>$ittt</font></td>"; 

 
          echo "<td>";
		  if (strtolower($row[ispublish])!="yes") {
			echo "<b style='color: red' TITLE='Not Published'>!!</b>";
		  }
		  echo "<font face='MS Sans Serif' size=2 color=#003366>".stripslashes(marc_gettitle($mID));
		  $det=marc_getyea($mID);
		  if (trim($det)!="") {
			 echo "/".$det;
		  }
			  
		  echo "</font>"; 
		  if ($row[tag245]==$prev_recordtitle) {
			echo "<BR><FONT class=smaller2>".getlang("ชื่อเรื่องซ้ำกับรายการก่อนหน้า::l::tag245 duplicate with previous Bib.")." <A HREF='../library.dupcheck/index.php?searchtitle=".getlang($row[tag245])."'  class=smaller2 target=_blank>".getlang("หากต้องการตรวจรายการซ้ำคลิกที่นี่::l::Click here to check duplicate")."</A></FONT>";
		  }
		  $prev_recordtitle=$row[tag245];
		  echo "<BR><FONT class=smaller2 COLOR=666666>tag999:".dspmarc($row[tag999])."</FONT>";

   echo "</td>"; 
 echo"<td valign=top><font class=smaller2>";
if ($row[LIBSITE]==$LIBSITE || getlibsitebibrule($LIBSITE,$row[LIBSITE],"permission-delete")=="yes") {
	echo "<a onclick=\"return confirm('".getlang("คุณต้องการที่จะลบรายการนี้ใช่หรือไม่::l::Do you really want to delete this?")."'); \"
	href='delBook.php?ID=$mID&RESOURCE_TYPE=$mRTYPE&FORMAT=$mFORMAT&LANGUAGE=$mLang&typeid=$typeid&faculty=$faculty&startrow=$startrow&keyword=$keyword&calln=$calln'>".getlang("ลบ::l::Delete")."</a>/";
}

if ($row[LIBSITE]==$LIBSITE || getlibsitebibrule($LIBSITE,$row[LIBSITE],"permission-edit")=="yes") {
 echo "<a 
href='addDBbook.php?IDEDIT=$mID&RESOURCE_TYPE=$mRTYPE&FORMAT=$mFORMAT&LANGUAGE=$mLang&typeid=$typeid&faculty=$faculty&startrow=$startrow&keyword=$keyword&calln=$calln' >".getlang("แก้::l::Edit")."</a>/";
} 
echo "<a 
href='../dublin.php?ID=$mID&RESOURCE_TYPE=$mRTYPE&adm=on' target=_blank 
>".getlang("ดูรายละเอียด::l::View")."</a>";
$module=get_itemmodule($row[ID]);
if ($module!="serial") {
   if (get_itemmodule($row[ID],true)=="journalindex") {
      echo "<BR> &nbsp;&nbsp;<IMG SRC='../neoimg/Book.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><a href='../library/mainadmin.php#ser' onclick=\"return confirm('".getlang("ไปยังงานวารสาร?::l::Go to serial module?")."')\" class=smaller2>".getlang("บทความวารสาร::l::Journal Index")."</a>";
   } else {
      echo "<BR> &nbsp;&nbsp;<IMG SRC='../neoimg/Book.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><a href='../library.bitem/media_type.php?MID=$row[ID]&remotes_row=$startrow' class=smaller2>Items</a>";
      $r=tmq("select * from media_mid where pid='$row[ID]' ");
      $n=tmq_num_rows($r);
      echo "(" . number_format($n) . ")";
  }
} else {
 echo "<BR> &nbsp;&nbsp;<IMG SRC='../neoimg/Book.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><a href='../library/mainadmin.php#ser' onclick=\"return confirm('".getlang("ไปยังงานวารสาร?::l::Go to serial module?")."')\" class=smaller2>".getlang("วารสาร::l::Serials")."</a>";
  $r=tmq("select * from media_mid where pid='$row[ID]' ");
  $n=tmq_num_rows($r);
  echo "(" . number_format($n) . ")";
}
 $r=tmq("select * from media_ftitems where mid='$row[ID]' and fttype='cover' ");
  $n=tmq_num_rows($r);
  echo " <a href=\"../library.dbfulltext/mediacontent.php?FTCODE=cover&mid=$row[ID]\" target=_blank class=smaller2>".getlang("ภาพปก::l::Covers")."</a>(" . number_format($n) . ")";
	if ($row[LIBSITE]==$LIBSITE) {
		$libsitecol="#85B380";
	} else {
		$libsitecol="#B67D7C";
	}
	  echo "<BR><FONT class=smaller2 color='$libsitecol' TITLE='".getlang("เจ้าของ Bib::l::Bib. Owner")."' style='pointer-events: none;'>" .getlang("ของ::l::Owner").":".getlang($libsitedb[$row[LIBSITE]])."</FONT>";
  if ($row[LIBSITE]==$LIBSITE || getlibsitebibrule($LIBSITE,$row[LIBSITE],"permission-chowner")=="yes") {
	  echo " <A HREF='editLIBSITEOWNER.php?keyword=$keyword&isbn=$isbn&authorname=$authorname&sbc=$sbc&startrow=$startrow&editLIBSITEOWNER=$row[ID]' class=smaller2>".getlang("เปลี่ยน::l::Change")."</A>";
  } 
 ?></font></td> <?php 
           echo "</tr>"; 
		$i++; 
        $s = $i-1; 
}
	
echo $_pagesplit_btn_var;
?>
<script language="javascript"> 
function resizeIframe2(id) { 
	try { 
		frame = document.getElementById(id); 
		frame.scrolling = "no"; 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight + 2; 
		 if (tmpfrheight>1600) {
			 tmpfrheight=1600;
		 }
		 objToResize.height = tmpfrheight;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script> 
<?php 
 //if (tmq_num_rows($result)==0 && getval("_SETTING","connecttoulibuc")=="yes" && (strlen($keyword)>3 || strlen($isbn)>3)) {
 if ( getval("_SETTING","displayyazatbookman")=="yes" && (strlen($keyword)>3 || strlen($isbn)>3 || strlen($authorname)>3)) {
				?>
				
<tr  style="background-color: white;"><td colspan=3 align=center style="background-color: white;"><iframe width=98% height=160 ID="yazdisplayIFRAME" frameborder=no scrolling=AUTO noonload="resizeIframe2('yazdisplayIFRAME');" src="./quickyaz.php?<?php  echo "keyword=".
	urlencode($keyword)."&isn=".urlencode($isbn)."&authorname=".urlencode($authorname);
?>"
style="border: solid 2 #FF8000; border-left-width: 12px;"
></iframe>
</td></tr>
<?php 	
		}

 //if (tmq_num_rows($result)==0 && getval("_SETTING","connecttoulibuc")=="yes" && (strlen($keyword)>3 || strlen($isbn)>3)) {
 if ( getval("_SETTING","connecttoulibuc")=="yes" && (strlen($keyword)>3 || strlen($isbn)>3 || strlen($authorname)>3)) {
				?>
				
<tr style="background-color: white;"><td colspan=3 style="background-color: white;" align=center><iframe width=98% height=500 ID="usissearchassistIFRAMESIDE" frameborder=no scrolling=AUTO noonload="resizeIframe2('usissearchassistIFRAMESIDE');" src="../globalpuller.php?url=<?php 
echo urlencode(
	getval("SYSCONFIG","ulibmasterurl")."_mine/global.php?fromrefcode=".
	barcodeval_get("activateulib-refcode")."&keyword=".
	urlencode($keyword)."&isn=".urlencode($isbn)."&authorname=".urlencode($authorname)
 );
?>"
style="border: solid 2 #FFCC33; border-left-width: 12px;"
></iframe>
</td></tr>
<?php 	
		}
		
 ?> 
                </table> 
<?php 

        // table แสดงเลขหน้า 
?>
<div align=left>
<?php 
	if ($IDEDIT!="") {
	 html_label('b',$IDEDIT);
	}?> <div>             </td> 
            </tr> 
       </table> 
      </td> 
    </tr> 
  </table> 
  
  </td></tr></table> <!-- end table for faucets-->
  
  
  <?php if (floor($startrow)==0) {?>
  <TABLE width=<?php  echo $_TBWIDTH?> align=center>
  <TR>
	<TD><B><?php  echo getlang("5 รายการล่าสุด::l::5 latest bib.");?></B><BR>
	<?php 
		$s=tmq("select ID,tag999 from media order by ID desc limit 5");
		while ($r=tmq_fetch_array($s)) {
			echo "<A HREF='$dcrURL/dublin.php?ID=$r[ID]' target=_blank class=smaller>".marc_gettitle($r[ID])."</A> ";
			echo "<FONT class=smaller2 COLOR=666666>tag999:".dspmarc($r[tag999])."</FONT>  <A HREF='addDBbook.php?IDEDIT=$r[ID]' class=smaller2>".getlang("แก้ไข::l::Edit")."</A><BR>";
		}
	?></TD>
  </TR>
  </TABLE>
  
  
  <?php 
  }
  foot();
  ?>