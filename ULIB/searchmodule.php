<?php 
	stat_add("visithp_type","searchmodule");
	$currentsearchwidth=605;
	$is_bibratingenable=barcodeval_get("bibrating-o-enable");

?><table width="<?php  echo $_TBWIDTH?>" border=0 align=center bgcolor=white cellpadding=0 cellspacing=0>

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

<tr valign=top><td width=165
style="width: 165!important; border-color: #626262; border-style: dotted; border-width: 0px; border-right-width: 1px;">

<iframe width=165 height=100% ID="searchlimitationIFRAMESIDE" frameborder=no src="search.filterframe.php" scrolling=NO  onload="resizeIframe2('searchlimitationIFRAMESIDE')"></iframe>

	</td>
	<td width="<?php  echo $currentsearchwidth;?>" style="width: <?php  echo $currentsearchwidth;?>!important;" align=left>
<!--  -->
<?php 
include("webpage.inc.quicksearch.php");
?>
<TABLE width="<?php  echo $currentsearchwidth-150;?>" noalign=center border=0 cellpadding=0 cellspacing=0>
	<TR>
		<TD align=left valign=top><?php 
		include("search.inc.sqlcollection.php");
			include ("./search.inc.func.php");
//printr($_GET);
//trap error
if (!is_array($searchdb)) {
	$searchdb=Array();
}
if (!is_array($ssql_searchedword)) {
	$ssql_searchedword=Array();
}
//trap error


$allsearchstr="";
$allsearchurl="";
		$ignorewordlist = "";
		$searchworddb=tmq_dump("index_ctrl","code","name");
		reset($searchdb);
		foreach ($searchdb as $searchdbkey => $searchdbvalue) {
			$searchdb[$searchdbkey]=stripslashes($searchdb[$searchdbkey]);
			$searchdb[$searchdbkey]=rem2space($searchdb[$searchdbkey]);
			$tmp =explode(" ",$searchdb[$searchdbkey]);
			$ALLNONSTOPWORD="";
			foreach ($tmp as $x) {
				if ($x!="" && $x!="[[AND]]" && $x!="[[OR]]" && $x!="[[NOT]]") {
					$sqlignoreword=tmq("select * from ignoreword where word='$x' ",false);
					$sqlignoreword=tmq_num_rows($sqlignoreword);
					if ($sqlignoreword!=0) {
						$ignorewordlist = "$ignorewordlist , $x";
						//echo "[removing = $searchdbkey $searchdb[$searchdbkey]]";
					} else {
						$allsearchstr=$allsearchstr.$searchdb[$searchdbkey]; // for check blank search
						$allsearchurl=$allsearchurl."searchdb[$searchdbkey]=$searchdb[$searchdbkey]&";
						$ALLNONSTOPWORD.=' '.$x;
					}
				} else {
					$ALLNONSTOPWORD.=' '.$x;
				}
			}
			$searchdb[$searchdbkey]=$ALLNONSTOPWORD;
			//echo $setx."<BR>";
		}
		$allsearchstr=$allsearchstr.$searchbybarcode.$searchbybibid; // for check blank search
//print_r($searchdb);
//echo "[$setx]";

//echo "++$MDESCRIPTION++";
$ignorewordlist=trim($ignorewordlist);
$ignorewordlist=trim($ignorewordlist,",");
	if (trim($ignorewordlist)!="" && $ignorewordlist!=",") {
		echo "<FONT COLOR=gray class=smaller>".getlang("คำต่อไปนี้เป็น Stopword ซึ่งจะไม่นำมาสืบค้น::l::these are Stopword which not include in this search")." <B class=smaller>$ignorewordlist</B> <A HREF='stopwords.php'  class=smaller>".getlang("รายละเอียดเพิ่มเติม::l::more information")."..</A></FONT><BR>";
	}

$allsearchstr=str_replace('[[AND]]','',$allsearchstr);
$allsearchstr=str_replace('[[OR]]','',$allsearchstr);
$allsearchstr=str_replace('[[NOT]]','',$allsearchstr);
$allsearchstr=str_replace(' ','',$allsearchstr);

	$sql="";
	$puresearchnolimitsql="";
	$puresearchonlylimitsql="";

            if (trim($allsearchstr)!="")
                { //if searching

$mdtypedb=tmq_dump("media_type","code","name");
$shelvesdb=tmq_dump2("media_place","code","name,main");
$libsitedb=tmq_dump("library_site","code","name");

$mapdb=tmq_dump("index_ctrl","code","fid");
//print_r($mapdb);
/*
index_init_INDEXWORDDB();
		*/
		$searchstr2usis="";
		$ifstatword=getval("_SETTING","savesearchword");
		foreach ($searchdb as $searchdbkey => $searchdbvalue) {
			$searchdb[$searchdbkey]=strip_tags($searchdb[$searchdbkey]);
			if ($ifstatword=="yes") {
				$statstr=$searchdb[$searchdbkey];
				$statstr=str_replace("[[AND]]","",$statstr);
				$statstr=str_replace("[[OR]]","",$statstr);
				$statstr=str_replace("[[NOT]]","",$statstr);
				$statstr=trim(rem2space($statstr));
				$searchstr2usis.=' '.$statstr;
				statordr_add("search_text",iconvth($statstr));
			}
			$sql = "$sql  " . ssql(trim($searchdb[$searchdbkey]),$mapdb[$searchdbkey]);
		}
		sessionval_set("puresearchnolimitsql",$sql);	
		sessionval_set("searchstr2usis",$searchstr2usis);	

	if ($searchyear!="") {
		$sql.=" and fixw like '_____$searchyear%' ";
		$puresearchonlylimitsql.=" and fixw like '_____$searchyear%' ";
	}
	if ($searchlang!="") {
		$sql.=" and fixw like '_________________________________$searchlang%' ";
		$puresearchonlylimitsql.=" and fixw like '_________________________________$searchlang%' ";
	}
	if ($collectionsql!="") {
		$sql.="$collectionsql";
		$puresearchonlylimitsql.="$collectionsql";
	}
	if ($limitplacespec!="") {
		$sql.=" and placelist like '%$limitplacespec%' ";
		$puresearchonlylimitsql.=" and placelist like '%$limitplacespec%' ";
	}
	if ($resourcetypespec!="") {
		$sql.=" and mdtype like '%$resourcetypespec%' ";
		$puresearchonlylimitsql.=" and mdtype like '%$resourcetypespec%' ";
	}	
	if ($searchbybarcode!="") {
		$sql.=" and bcode like '%,$searchbybarcode,%' ";
		$puresearchonlylimitsql.=" and bcode like '%,$searchbybarcode,%' ";
	}
	if ($searchbybibid!="") {
		$sql.=" and mid = '$searchbybibid' ";
		$puresearchonlylimitsql.=" and mid = '$searchbybibid' ";
	}
	if ($limitsubj!="") {
		$sql.=" and subj like '%$limitsubj%' ";
		$puresearchonlylimitsql.=" and subj like '%$limitsubj%' ";
	}
	sessionval_set("puresearchonlylimitsql-nolimitcalln",$sql);	
	if ($limitcallnloadsub!="" && $limitcallnloadsub2=="") {
		$sql.=" and (trim(index01) like '$limitcallnloadsub%' or trim(index01) like '^a$limitcallnloadsub%') ";
		$puresearchonlylimitsql.=" and (trim(index01) like '$limitcallnloadsub%' or trim(index01) like '^a$limitcallnloadsub%') ";
	}
	if ($limitcallnloadsub2!="") {
		$sql.=" and ((index01) like '__$limitcallnloadsub$limitcallnloadsub2%' or trim(index01) like '__^a$limitcallnloadsub$limitcallnloadsub2%') ";
		$puresearchonlylimitsql.=" and ((index01) like '__$limitcallnloadsub$limitcallnloadsub2%' or trim(index01) like '__^a$limitcallnloadsub$limitcallnloadsub2%') ";
	}
	sessionval_set("puresearchonlylimitsql",$puresearchonlylimitsql);	
	
	//print_r($ssql_searchedword);
		$allsearchurl="$allsearchurl&limitplacespec=$limitplacespec&resourcetypespec=$resourcetypespec&searchyear=$searchyear&searchlang=$searchlang&searchbybarcode=$searchbybarcode&limitsubj=$limitsubj&searchbybibid=$searchbybibid&limitcallnloadsub=$limitcallnloadsub&limitcallnloadsub2=$limitcallnloadsub2";
		$dspv=$allsearchurl;

		sessionval_set("searchdspv",$dspv);	

		$dspv=local_gethiddenquery($dspv,"thisisfortestremovenull"); 
		//echo $dspv;

		//send to filterframe
		sessionval_set("puresearchstr",$searchstr2usis);	

		/////start create display text
		reset($searchdb);
		$setx="";
		$stat_searchnofound="";
		foreach ($searchdb as $searchdbkey => $searchdbvalue) {
			$setx.=getlang("$searchworddb[$searchdbkey]")." ";
			$stat_searchnofound.=" ".$searchworddb[$searchdbkey];
			$Tsetx="$searchdb[$searchdbkey] ";
				$Tsetx=str_replace("[[AND]]","<font color='#7C9E87' style='font-weight: normal'>and</font>",$Tsetx);
				$Tsetx=str_replace("[[OR]]","<font color='#7C9E87' style='font-weight: normal'>or</font>",$Tsetx);
				$Tsetx=str_replace("[[NOT]]","<font color='#7C9E87' style='font-weight: normal'>not</font>",$Tsetx);
			$setx.=$Tsetx;
			if (count($searchdb)>=2)  {
				$setx.=" <a href=\"$_PAGE_FILE?".local_gethiddenquery($dspv,"searchdb[$searchdbkey]")."\"><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
			}
			$setx.=" ,";
		}
		$setx=trim($setx,",");
		$setx=trim($setx);
		/////// end create display text
		

	$sql_base="SELECT id,titl,auth,bibrating,mid,remoteindex FROM index_db where  ispublish='yes' and 1  ";
	$pure_sql=$sql;
	$sqlexec=$sql_base.$sql;

	$resultperpage=floor(barcodeval_get("webpage-o-resultperpage"));
	if ($resultperpage==0) {
		$resultperpage=12;
	}
	$orderbydb[title]=" order by titl asc";
	$orderbydb[titledesc]=" order by titl desc";
	$orderbydb[author]=" order by auth asc,titl asc";
	$orderbydb[authordesc]=" order by auth desc,titl asc";
	$orderbydb[rating]=" order by bibrating asc,titl asc";
	$orderbydb[ratingdesc]=" order by bibrating desc,titl asc";

	if ($sortingby=="") {
		if ($is_bibratingenable=="yes") {
			$sortingby="ratingdesc";
		} else {
			$sortingby="title";
		}
	}
	//echo "[$sortingby]";
	$sqlexec.=" ".$orderbydb[$sortingby];
	//echo $sqlexec;
	$result=tmqp($sqlexec,"$_PAGE_FILE?$dspv","",$resultperpage);

///////////////////////////                    
//echo "<PRE>$pure_sql</PRE>";
//////////////////////////


					echo tmq_error();
                   $NRow=tmq_num_rows($result);
                    // Query ข้อมูลตามจำนวนที่กำหนด
                    $result4sum=tmq($sqlexec,false);
                    //echo $sql . tmq_error();
                    $NRow4sum=tmq_num_rows($result4sum);
                    echo "<div align=left><img src='./neoimg/spacer.gif' width=2 height=5><nobr><font 
 style='color: #4B4B4B'>".getlang("พบจำนวน::l::Found")." " . number_format($NRow4sum) . "  ".getlang("รายการ::l::record(s)")."</font></nobr>";
		@reset ($HTTP_POST_VARS);
                    echo " ";

if ($NRow4sum<=1) {
?><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj("searchlimitationIFRAMESIDE").style.display="none";
//-->
</SCRIPT><?php 
}


	echo "<BR>&nbsp;<b>";
	$setx=stripslashes($setx);
	echo getlang("ค้นหา ::l::Searching ").(trim($setx,","));
?>
</TD>
<td width=150 valign=top align=right>
		<?php 
	$addquerya=explode('?',$HTTP_REFERER);
	$reffile=$addquerya[0];
	$gstr1="::<B>&nbsp;".getlang("สืบค้นใหม่::l::New search")."&nbsp;</B>,$_PAGE_FILEBACK,green,_self";
	if ($makeref=='yes') {
		$tmpref="";
		$addquerya=explode('?',$HTTP_REFERER);
		$reffile=$addquerya[0];
		$addquerya=$addquerya[1];
		$addquerya=explode('&',$addquerya);
		reset ($addquerya); 
		//printr($_SERVER);
		//list ($key, $val) = each ($addquerya); //removefirst
		while (list ($key, $val) = each ($addquerya)) { 
			$addqueryi=explode('=',$val);
			if($addqueryi[0]=="makeref" || $addqueryi[0]=="startrow") {
				 continue;
			}	
			$addqueryi[1]=iconvth($addqueryi[1]);;
			$tmpref.=urldecode($addqueryi[0])."=".urldecode($addqueryi[1])."&";
		} 
		//echo "[$tmpref]";
		$gstr2="::".getlang("กลับหน้ารายการ::l::Back to list").",$reffile?$tmpref,gray,_self";
	}
	/*
	?><TABLE cellspacing=0 cellpadding=0 border=0>
	<TR>
		<TD align=right><?php html_guidebtn($gstr1);?></TD>
	</TR></TABLE><?php 
		*/
	if ($gstr2!=""){?><TABLE cellspacing=0 cellpadding=0>
	<TR>
		<TD><?php html_guidebtn($gstr2);?></TD>
	</TR></TABLE><?php  } ?>

		</td>
        </TR>
    </TABLE>
	<TABLE cellspacing=0 cellpadding=0 width=100% nowidth="<?php  echo $currentsearchwidth;?>" align=center>
	<TR>
		<TD><?php 
//	$gstr3=getlang("กำหนดขอบเขต::l::Limit search").",javascript:loadSearchAssist('searchlimitation'),gray,_self";
  if (is_array($searchdb[su]) || $searchdb[su]!="" || $searchdb[kw]!='') {
		$gstr3.="::".getlang("หัวเรื่องใกล้เคียง::l::Related Subject").",javascript:loadSearchAssist('searchlimitationsubj'),gray,_self";
	}
//	$gstr3.="::".getlang("ค้นหาจากรหัสบาร์โค้ด::l::Barcode Search").",javascript:loadSearchAssist('searchfrombarcode'),gray,_self";
	if (getval("_SETTING","use-usoundex")=="yes")	 {
		$suarray=explode(' ',$searchdb[su]. ' ' . $searchdb[kw] );
		$suarray=join($suarray,' ');
		sessionval_set("suarray",$suarray);	
		$gstr3.="::".getlang("คำอื่น ๆ::l::Related word").",javascript:loadSearchAssist('kwsuggession'),gray,_self";
	}
	if ($NRow4sum>1) {
		$gstr3.="::".getlang("เรียงลำดับ::l::Sorting").",javascript:loadSearchAssist('searchlimitationsorting'),gray,_self";
	}
	if ($NRow4sum>10 && barcodeval_get("webpage-o-searchautocallnfiltertype")!="Not show") {
		$gstr3.="::".getlang("กรองเลขหมู่::l::Callnumber Filtering").",javascript:loadSearchAssist('searchlimitationcallnum'),gray,_self";
	}
	html_guidebtn($gstr3);
?></TD>
	</TR>
	<TR>
		<TD class=smaller><?php 
		if ($limitplacespec!="" ||$limitsubj!="" ||$resourcetypespec!="" ||$searchbybarcode!="" ||$searchyear!=""||$searchlang!=""||$limitcallnloadsub!="") {
			echo getlang("กำหนดขอบเขต:::l::Limit search:");
		}
		if ($limitplacespec!="") {
			$limitplacespecstr=tmq("select * from media_place where code='$limitplacespec' ");
			$limitplacespecstr=tmq_fetch_array($limitplacespecstr);
			echo getlang("สถานที่ ::l::On location ").getlang($limitplacespecstr[name]);
						echo " <a href='$_PAGE_FILE?".local_gethiddenquery($dspv,"limitplacespec")."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		if ($limitcallnloadsub!="") {
			echo getlang("หมวดหลัก ::l::Main callnumber ").$limitcallnloadsub;
			$tmplimitcalln=local_gethiddenquery($dspv,"limitcallnloadsub");
			$tmplimitcalln=local_gethiddenquery($tmplimitcalln,"limitcallnloadsub2");
						echo " <a href='$_PAGE_FILE?".$tmplimitcalln."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		if ($limitcallnloadsub2!="") {
			echo getlang("หมวดรอง ::l::Minor callnumber ").$limitcallnloadsub2;
			$tmplimitcalln=local_gethiddenquery($dspv,"limitcallnloadsub2");
						echo " <a href='$_PAGE_FILE?".$tmplimitcalln."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		if ($resourcetypespec!="") {
			if ($limitplacespec!="") {
				echo " , ";
			}
			$resourcetypespecstr=tmq("select * from media_type where code='$resourcetypespec' ");
			$resourcetypespecstr=tmq_fetch_array($resourcetypespecstr);
			echo getlang("ประเภท ::l::resource type ").getlang($resourcetypespecstr[name]);
			echo " <a href='$_PAGE_FILE?".local_gethiddenquery($dspv,"resourcetypespec")."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		if ($searchyear!="") {
			if ($limitplacespec!="" || $resourcetypespec!="") {
				echo " , ";
			}
			echo getlang(" ปี ::l:: Year ").$searchyear ;
			echo " <a href='$_PAGE_FILE?".local_gethiddenquery($dspv,"searchyear")."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		if ($searchbybarcode!="") {
			if ($limitplacespec!="" || $resourcetypespec!="" || $searchyear!="" ) {
				echo " , ";
			}		
			echo "".getlang(" บาร์โค้ด ::l:: Barcode ").$searchbybarcode;
			echo " <a href='$_PAGE_FILE?".local_gethiddenquery($dspv,"searchbybarcode")."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		if ($searchlang!="") {
			if ($searchbybarcode!="" || $limitplacespec!="" ||$resourcetypespec!="" || $searchyear!="" ) {
				echo " , ";
			}		
			echo "".getlang(" ภาษา ::l:: Language ").ucwords($searchlang);
			echo " <a href='$_PAGE_FILE?".local_gethiddenquery($dspv,"searchlang")."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		if ($limitsubj!="") {
			if ($limitplacespec!="" || $resourcetypespec!="" || $searchbybarcode!="" || $searchyear!="" || $searchlang!="" ) {
				echo " , ";
			}
			echo getlang(" ขอบเขตหัวเรื่อง ::l:: Limit Subject ").$limitsubj;
			echo " <a href='$_PAGE_FILE?".local_gethiddenquery($dspv,"limitsubj")."'><img align=absmiddle border=0 src='neoimg/smallClose.gif'></a>";
		}
		?></TD>
	</TR>
	</TABLE>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		
	function loadSearchAssist(wh) {

		tmp=getobj('searchfrombarcode');
		tmp.style.display="none"
		tmp=getobj('kwsuggession');
		tmp.style.display="none"
		tmp=getobj('searchlimitationsubj');
		tmp.style.display="none"
		tmp=getobj('searchlimitationsorting');
		tmp.style.display="none"
		tmp=getobj('searchlimitationcallnum');
		tmp.style.display="none"
		//if (wh=="searchlimitation") {
		//	 tmp=getobj("searchlimitationIFRAME");
		//	 tmp.src="";
		//}
		if (wh=="searchlimitationsubj") {
			 tmp=getobj("searchlimitationsubjIFRAME");
			 tmp.src="search.filtersubjframe.php";
		}
		if (wh=="kwsuggession") {
			 tmp=getobj("searchfilterkwIFRAME");
			 tmp.src="search.filterkwframe.php";
		}
		if (wh=="searchlimitationcallnum") {
			 tmp=getobj("searchfilterautocallnIFRAME");
			 tmp.src="search.filterlimitcallnframe.php?limitcallnloadsub=<?php  echo $limitcallnloadsub;?>&limitcallnloadsub2=<?php  echo $limitcallnloadsub2;?>";
		}
		tmp=getobj(wh);
		tmp.style.display="block"

	}

	//-->
	</SCRIPT>
<TABLE width="<?php  echo $currentsearchwidth;?>" noalign=center>
	<TR>
	<TD>
	<?php 
		sessionval_set("searchsql",$sql);	
		sessionval_set("_PAGE_FILE",$_PAGE_FILE);			
		//sessionval set dspv at above
	?>

	
	<span id="searchlimitationsorting" style="display: none; background-color: #FFFFFF;
	border-width: 01px;
	border-style: solid;
	border-color: #008BCE; padding-botton:0; padding:4;">
	<BR>
	<B><?php 
	echo getlang("เรียงลำดับตาม::l::Sort by").": ";
	?></B>
	<?php  if ($sortingby=="title") { echo "<U>";}?>
	<A HREF="advsearching.php?<?php echo $dspv;?>&sortingby=title"><?php 
	echo getlang("ชื่อเรื่อง::l::Title");
	?></A></U>,
	<?php  if ($sortingby=="author") { echo "<U>";}?>
	<A HREF="advsearching.php?<?php echo $dspv;?>&sortingby=author"><?php 
	echo getlang("ชื่อผู้แต่ง::l::Author")."";
	?></A></U><?php 
	if ($is_bibratingenable=="yes") {
		?>,
	<?php  if ($sortingby=="ratingdesc") { echo "<U>";}?>
		<A HREF="advsearching.php?<?php echo $dspv;?>&sortingby=ratingdesc"><?php 
		echo getlang("ความนิยม::l::Rating")."";
		?></A></U>
	<?php 
	}
	?>
	</span>

	<span id="searchlimitationsubj" style="display: none; background-color: #FFFFFF;
	border-width: 01px;
	border-style: solid;
	border-color: #008BCE; padding-botton:0; padding:4;">
	<iframe width=98% height=150 ID="searchlimitationsubjIFRAME" frameborder=no nosrc="search.loading.php"></iframe>
	</span>
	<span id="searchlimitationcallnum" style="display: none; background-color: #FFFFFF;
	border-width: 01px;
	border-style: solid;
	border-color: #008BCE; padding-botton:0; padding:4;">
	<iframe width=98% height=200 ID="searchfilterautocallnIFRAME" frameborder=no nosrc="search.loading.php"></iframe>
	</span>
	
	<span ID="searchfrombarcode" style="display: none; background-color: #FFFFFF;
	border-width: 01px;
	border-style: solid;
	border-color: #008BCE; padding-botton:0; padding:4;">

	<TABLE class=table_border>
	<FORM METHOD=GET ACTION="<?php  echo $_PAGE_FILE;?>">
			<TR>
		<TD class=table_head><?php  echo getlang("กรุณากรอกบาร์โค้ดวัสดุ::l::Enter material's barcode");?></TD>
		<TD class=table_td><INPUT TYPE="text" NAME="searchbybarcode" maxlength=50 value="<?php  echo $searchbybarcode;?>"></TD>
	</TR>
		<TR>
		<TD class=table_td colspan=2 align=center>
		<INPUT TYPE="submit" value=" Search "></TD>
	</TR>
<?php 
local_getnhiddenquerysting("searchbybarcode");
?>
	</FORM>	</TABLE>
	</span>

	<span ID="kwsuggession" style="display: none; background-color: #FFFFFF;
	border-width: 01px;
	border-style: solid;
	border-color: #008BCE; padding-botton:0; padding:4;">
	<iframe width=98% height=170 ID="searchfilterkwIFRAME" frameborder=no nosrc="search.loading.php"></iframe>


</span></TD>
</TR>
</TABLE>

	<?php 
	if ($limitcallnloadsub!="") {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
				loadSearchAssist('searchlimitationcallnum');	
		//-->
		</SCRIPT><?php 
	}
	?>


    <table width = "<?php  echo $currentsearchwidth;?>" align=center border = 0 cellspacing = "0" cellpadding = "0">
        <tr>
            <td width = "70" colspan = "4">
                <img src = "./neoimg/spacer.gif" width = 3 height = 5 border = 0 hspace = 0 vspace = 0></td>
        </tr>
        <tr>
            <td valign = "top" align = center>
                <?php 
		if ($NRow == 0) { 
			statordr_add("searchnotfound_text",iconvth($stat_searchnofound));

		?>
		<center><br><br><font size=+2 face='MS Sans Serif'><nobr><?php  echo getlang("ไม่มีรายการใดตรงกับเงื่อนไขการค้นหา::l::No record satisfy your search"); ?> <BR><BR><BR>
<?php 
		} elseif ($NRow == 1) { 
			$row=tmq_fetch_array($result);
		$indexdb=tmq("select * from index_db where mid='$row[mid]' ",false);
		$indexdb=tmq_fetch_array($indexdb);
		if ($row[remoteindex]=='localDB') {

			pagesection("แสดงผลการสืบค้นที่พบ 1 รายการ::l::Display result, found 1 Bibliographic");
?>
<table bgcolor=white width=100% border=0 align=center cellpadding=1
cellspacing=0 >
<tr><td><a href='dublinfull.php?f=all&ID=<?php  echo $row[mid];?>' target=_blank><B>Marc Display</B></a></td>
  </tr></table>
 <?php 
			echo html_displaymedia($row[mid]);
			$ID=$row[mid];
			include("dublin.bibacc.php");
			$module=get_itemmodule($row[mid]);
			if ($module=="item") {
				html_displayitem($row[mid],$item);
			} elseif ($module=="serial") {
				html_displayserial($row[mid],$item);
			} else {
				echo "ผิดพลาด ไม่สามารถหาโมดูลสำหรับ $momodule";
			}

?><TABLE align=center cellpadding=0 cellspacing=0 border=0>
<FORM METHOD=POST ACTION="savemarked.php" target=savemarked>

<TR>
	<TD align=center><INPUT TYPE=hidden NAME='marksave[]' value='<?php  echo $row[mid];?>' >
	<INPUT TYPE="submit" value="<?php  echo getlang("Save This Record");?>" class=frmbtn style="width:160px"><BR><iframe name=savemarked width=400  height=20 frameborder=0 scrolling=NO align=absmiddle src="savemarked.php"></iframe></TD>
</TR></FORM>
</TABLE>
<?php 
		if (getval("_SETTING","display_biblabelatupac")=="yes") {
			 ?><br /><br /><table width=780 align=center>
			<tr><td><?php html_label('b',$row[mid]);?></td></tr>
			</table>
			<?php 
		}
		} else {
			//if found remoteindex 1 record
			local_media_headtr();
				$i=1;
				search_inc_media($row);
			local_media_headtr();
		}
	} else {
                ?>
<table width = "<?php  echo $currentsearchwidth;?>" align = center border = "0" cellspacing = "1" cellpadding = "3">
<FORM METHOD=POST ACTION="savemarked.php" target=savemarked name="searchform">
<?php 
local_media_headtr();
    $i=1;
  while ($row=tmq_fetch_array($result))  {
    search_inc_media($row);
  }
local_media_headtr();
?>
			<tr><td colspan=5 width=100%><INPUT TYPE="submit" value="Save Marked Record" class=frmbtn style="width:160px">
			<iframe name=savemarked width=300  height=20 frameborder=0 scrolling=NO align=absmiddle src="savemarked.php"></iframe></td></tr>
			</FORM>
<?php 
				echo $_pagesplit_btn_var;	
			?>
    </table>
    <?php 
		}

} else{ //if not searching
	include("search.inc.pleaseenter.php");
}
        ?>
        </td>
        </tr>
        </table>
				
				<!--  -->
				
				</td>
<td width=200 background="./neoimg/hpsidebar-sidebg.png" 
style="border-color: #626262; border-style: dotted; border-width: 0px; border-left-width: 1px; background-color: <?php echo barcodeval_get("hpsidebarsearch-o-colo");?>">
<?php  echo barcodeval_get("hpsidebarsearch-o-firsthtml");?>
	<?php  if (getval("_SETTING","display_search_addusis")=="yes") {?>
		<iframe width=100% height=100% ID="usissearchassistIFRAMESIDE" frameborder=no scrolling=no onload="resizeIframe2('usissearchassistIFRAMESIDE');" src="<?php  
		echo "globalpuller.php?url=".urlencode(
			getval("SYSCONFIG","ulibmasterurl")."search.usisassist.php?fromrefcode=".  barcodeval_get("activateulib-refcode")."&keyword=". urlencode($searchstr2usis)
		);
		 ;?>"></iframe>
	<?php  } elseif (barcodeval_get("hpsidebarsearch-o-enable")=="yes") {  
			$webpage_hpsidebarmode="search";
			include("webpage.hpsidebar.php");
		 } else { ?>
&nbsp;
	<?php  } ?>
	</td>
	</tr>
</table>
				<SCRIPT LANGUAGE="JavaScript">
				<!--
					getobj("INTERNALTEXTBOXKWSEARCH").value='<?php  
					$searchstr2usis_tmpsearchbox=trim($searchstr2usis);
					$searchstr2usis_tmpsearchbox=str_replace("'",'&quot;',$searchstr2usis_tmpsearchbox);
					echo trim($searchstr2usis_tmpsearchbox);
					$rcsval=sessionval_get("RecentSearches");
					$rcsval=explodenewline($rcsval);
					$rcsval[-1]=trim($searchstr2usis_tmpsearchbox)."[spliter]".$_SERVER[REQUEST_URI]."[spliter]".$NRow4sum;
					//printr($rcsval);
					$rcsval = arr_filter_remnull($rcsval);
					$rcsval = array_unique($rcsval);
					ksort($rcsval);
					//printr($rcsval);
					$rcsval=implode($newline,$rcsval);
					sessionval_set("RecentSearches",$rcsval)
					?>';
				//-->
				</SCRIPT>