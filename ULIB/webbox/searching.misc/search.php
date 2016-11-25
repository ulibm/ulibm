<?php 
set_time_limit(120);
include("../../inc/config.inc.php");
html_start();
include("$dcrs/webbox/func-head.php");
include($dcrs."webbox/searching.misc/search.inc.func.php");
include($dcrs."webbox/searching.misc/search.inc.sqlcollection.php");
include($dcrs."webbox/searching.misc/local_buildsearchsql.php");

$processsearchfilter=sessionval_get("processsearchfilter");
$processsearchfilter=unserialize($processsearchfilter);
if (floor($set_yea_start)!=0) {
	$processsearchfilter[yea_start]=floor($set_yea_start);
}
if (floor($set_yea_end)!=0) {
	$processsearchfilter[yea_end]=floor($set_yea_end);
}
if (count($searchfilter)!=0) { // set search filter from _GET
	@reset($searchfilter);
	while (list($k,$v)=each($searchfilter)) {
		if ($processsearchfilter[$k][$v]=="no" || $processsearchfilter[$k][$v]=="") {
			$processsearchfilter[$k][$v]="yes";
		} else {
			$processsearchfilter[$k][$v]="no";
		}
	}
}
if ($resetfilter=="yes") {
	$processsearchfilter=Array();
	//die;
}

//local search hist s

$localsearchhist=sessionval_get("localsearchhist");
$localsearchhist=unserialize($localsearchhist);
$localsearchhist=arr_filter_remnull($localsearchhist);
$localsearchhist[]=$indexcode.":".$KW;
$localsearchhist=array_unique($localsearchhist);
$localsearchhist=serialize($localsearchhist);
sessionval_set("localsearchhist",$localsearchhist);
if (count($localsearchhist)!=0) {
	?><script type="text/javascript"><!--
	top.local_localsearchhistupdate('<?php  echo count($localsearchhist);?>');
//--></script><?php 
} else {
	?><script type="text/javascript"><!--
	top.local_localsearchhistupdate('resetall');
//--></script><?php 
}

//local search hist e

sessionval_set("processsearchfilter",serialize($processsearchfilter));
//printr($processsearchfilter);
//printr($_GET);

stat_add("visithp_type","searchmodule");
//echo "[KW=$KW]";
$KW=str_replace("[[plussign]]","+",$KW);
$KW=str_replace("[[minussign]]","-",$KW);
$KW=str_replace("."," ",$KW);
//echo "[$KW]";

$KW=trim($KW);
$KW=stripslashes($KW);
$KW=rem2space($KW);
$KW=str_replace("--"," ",$KW);

if ($KW=="") {
	html_dialog("Data Missing","กรุณากรอกคำที่ต้องการค้นหา::l::Please enter keyword");
	die;
}
$kw=explodewithquote($KW);
//printr($kw);
			@reset($kw);
			$kwa=Array(); // 
			$foundignoreword=Array(); // 
			while (list($kwk,$kwv)=each($kw)) {
           // $kwv=addslashes($kwv);
				$sqlignoreword=tmq("select * from ignoreword where word='".addslashes($kwv)."' ",false);
				$sqlignoreword=tmq_num_rows($sqlignoreword);
				if ($sqlignoreword!=0) {
					$foundignoreword[] = $kwv;
				} else {
					$kwa[] = trim($kwv," ,");
					statordr_add("search_text",iconvth($kwv));
				}
				$searchdb[$searchdbkey]=$ALLNONSTOPWORD;
				//echo $setx."<BR>";
			}

//printr($kwa);
//print_r($foundignoreword);
$ignorewordlist=implode(",",$foundignoreword);
$ignorewordlist=trim($ignorewordlist);
$ignorewordlist=trim($ignorewordlist,",");
if (trim($ignorewordlist)!="" && $ignorewordlist!=",") {
	echo "<FONT COLOR=gray class=smaller>".getlang("คำต่อไปนี้เป็น Stopword ซึ่งจะไม่นำมาสืบค้น::l::these are Stopword which not include in this search")." <B class=smaller>$ignorewordlist</B> <A HREF='stopwords.php'  class=smaller target=_blank>".getlang("รายละเอียดเพิ่มเติม::l::more information")."..</A></FONT><br>";
}

//prepare data
$repocatedbs=tmq("select * from oai_repocate order by name");
$repocatedb=Array();
while ($repocatedbr=tfa($repocatedbs)) {
   $repocatedbsub=tmq("select * from oai_repo where cate='$repocatedbr[code]'  order by name");
   if (tnr($repocatedbsub)==0) {
      continue;
   }
   $repocatedb[$repocatedbr[code]][name]=getlang($repocatedbr[name]);
   $repocatedb[$repocatedbr[code]][code]=($repocatedbr[code]);
   $repocatedbsubtmp="";
   while ($repocatedbsubr=tfa($repocatedbsub)) {
      $repocatedbsubtmp=$repocatedbsubtmp.",'oai-".addslashes($repocatedbsubr[code])."'";
   }
   $repocatedbsubtmp=trim($repocatedbsubtmp,", ");
   $repocatedb[$repocatedbr[code]][subs]=$repocatedbsubtmp;
}
//printr($repocatedb);
$mdtypedb=tmq_dump("media_type","code","name");
$shelvesdb=tmq_dump2("media_place","code","name,main");
$libsitedb=tmq_dump("library_site","code","name");
$mapdb=tmq_dump("index_ctrl","code","fid"," where searchable='yes' ");
$mapdbname=tmq_dump("index_ctrl","code","name");
@reset($kwa);
$indexfid=$mapdb[$indexcode];
if ($indexfid=="") {
	$indexfid="kw";
}

$_basesearchsql=local_buildsearchsql();
$sql="select mid,id from index_db where (ispublish='yes' or remoteindex<>'localDB' or importid like 'havester:%') and $_basesearchsql ";
//$_basesearchsql=$sql;
//echo $sql;
echo "".getlang("ค้นหาคำว่า::l::Searching")." ";
/////////////////////////////////////////////searchsuggest s
@reset($kwa);
$sgi=0;
$sgdivstr="";
$sg_leftpadd="";
while (list($sgk,$sgv)=each($kwa)) {
	//$sgv=trim($sgv,' \"');
	$sg_rightpadd="";
	$sgi++;
	if ($sgi<=1) {
		$sgv=ltrim($sgv,"+-");
	}
	$sgvu=usoundex_get(trim($sgv,' \"'));
	//echo "[$sgv=$sgvu]";
	$sgvu_pref=substr($sgvu,0,1);
	$sgvu=ltrim($sgvu,"+-");
   $sgvu=($sgvu);
	//echo "$sgv=$sgvu ($sgvu_pref); ";
	?><a href="javascript:void(null);" onclick="localsghideall('sgdiv<?php  echo $sgi;?>'); "><?php 
	echo stripslashes("$sgv ");
	?></a><?php 
	$sgsearch=tmq("select * from indexword where usoundex like '%".addslashes($sgvu)."%' and length(word1)>3 order by length(word1) limit 50",false);
	//$sgsearch=tmq("SELECT *, LEVENSHTEIN_RATIO( '$sgv', word1 ) as textDiff FROM indexword HAVING textDiff > 60; ");
	$sgsearchcc= tnr($sgsearch);
	$sgdivstr.="<div ID='sgdiv$sgi'  style='display:none; position: absolute; width:770px; top: 0px; left: 10px; padding: 5px 5px 5px 5px; background-color: white;
		-webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
		box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);' >";
	if ($sgsearchcc>0) {
		$sg_lencount=0;
		while ($sgsearchr=tfa($sgsearch)) {
			$sg_lencount=$sg_lencount+mb_strlen($sgsearchr[word1]);
			//echo ($sg_lencount)." ";
			if (($sg_lencount)>185) {
				break;
			}
			//echo "[$sgsearchr[word1]]";
			$sgstruse=$sg_leftpadd;
			$sgstruse.=" ";
			if ($sgvu_pref=="-") {
				$sgstruse.="-";
			}
			if ($sgvu_pref=="+") {
				$sgstruse.="+";
			}
			$sgstruse.=$sgsearchr[word1]." ";
			$sgstruse.=mb_substr($KW,strlen($sg_leftpadd." ".$sgv));
			$sgdivstr.="<a href='javascript:void(null);' class=smaller onclick=\"parent.local_directfromsearchif('".addslashes($sgstruse)."');\">".stripslashes($sgsearchr[word1])."</a> ";
		}
	} else {
		$sgdivstr.= "<i>".getlang("ไม่มีคำแนะนำเพิ่มเติม::l::No suggestion")." [$sgv]</i>";
	}
	$sgdivstr.="</div>";
	$sg_leftpadd=$sg_leftpadd." ".$sgv;
}
//$kwastr=implode(",",$kwa);
//echo $kwastr ;
echo " ".getlang("ด้วย::l::in")."";
echo getlang($mapdbname[$indexcode]);

?><div style="clear:both"></div>
<div style='position:relative; display:inline;'><?php  echo $sgdivstr;?></div><?php 
?><script type="text/javascript">
<!--
function localsghideall(dspdiv) {
	for (i=1;i<=<?php  echo $sgi?> ;i++ ) {
		if (dspdiv!=('sgdiv'+i)) {
			tmp=getobj('sgdiv'+i);
			tmp.style.display='none';
		}
	}
	tmp=getobj(dspdiv);
	if (tmp.style.display=="inline") {
		tmp.style.display='none';
	} else {
		tmp.style.display='inline';
	}
}
//-->
</script>
<?php 
/////////////////////////////////////////////searchsuggest e

$is_bibratingenable=barcodeval_get("bibrating-o-enable");


$orderbydb[title]=" order by if(titl = '' or titl is null,1,0),titl asc";
$orderbydb[titledesc]=" order by titl desc";
$orderbydb[author]=" order by if(auth = '' or auth is null,1,0),auth asc,titl asc";
$orderbydb[authordesc]=" order by auth desc,titl asc";
$orderbydb[rating]=" order by bibrating asc,titl asc";
$orderbydb[ratingdesc]=" order by bibrating desc,titl asc";

if ($sortingby=="") {
   $sortingby=getval("_SETTING","searchdefsort");
 	if (strtolower($is_bibratingenable)!="yes" && ($sortingby=="rating" ||$sortingby=="ratingdesc")) {
		$sortingby="title";
	}  
	if ($sortingby=="") {
		$sortingby="title";
	}   /*
	if ($is_bibratingenable=="yes") {
		$sortingby="ratingdesc";
	} else {
		$sortingby="title";
	}*/
}

$resultperpage=floor(barcodeval_get("webpage-o-resultperpage"));
if ($resultperpage==0) {
	$resultperpage=12;
}

$dspv="KW=".urlencode($KW)."&indexcode=$indexcode";

$sql.=" ".$orderbydb[$sortingby];

//echo $sql;///xxx
$result=tmqp($sql,"search.php?$dspv","",$resultperpage);

$NRow=tmq_num_rows($result);
$result4sum=tmq($sql,false); ///
$NRow4sum=tmq_num_rows($result4sum);
echo "<nobr> <font  style='color: #4B4B4B'>".getlang("พบจำนวน::l::Found")." " . number_format($NRow4sum) . "  ".getlang("รายการ::l::record(s)")."</font></nobr>";

?><span id="searchlimitationsorting" style="display: inline; 
	border-width: 0px;
	border-style: solid;
	border-color: #008BCE; padding-botton:0; padding:4;">
	<BR>
	<B><?php 
	echo getlang("เรียงลำดับตาม::l::Sort by").": ";
	?></B>
	<?php  if ($sortingby=="title") { echo "<U>";}?>
	<A HREF="search.php?<?php echo $dspv;?>&sortingby=title"><?php 
	echo getlang("ชื่อเรื่อง::l::Title");
	?></A></U>,
	<?php  if ($sortingby=="author") { echo "<U>";}?>
	<A HREF="search.php?<?php echo $dspv;?>&sortingby=author"><?php 
	echo getlang("ชื่อผู้แต่ง::l::Author")."";
	?></A></U><?php 
	if ($is_bibratingenable=="yes") {
		?>,
	<?php  if ($sortingby=="ratingdesc") { echo "<U>";}?>
		<A HREF="search.php?<?php echo $dspv;?>&sortingby=ratingdesc"><?php 
		echo getlang("ความนิยม::l::Rating")."";
		?></A></U>
	<?php 
	}
	?>
	</span>
<?php 
if ($NRow == 0) { 
			statordr_add("searchnotfound_text",($KW)."");

		?>
		<center><br><br><?php 
		local_edithtmlbtn("search6-searchnotfoundstr","แทรก/แก้ไขเนื้อหา (เมื่อสืบค้นแล้วไม่พบผลลัพธ์)::l::Insert/edit html (Search not found)");
		?><font size=+2 face='MS Sans Serif'><nobr><?php  echo getlang("ไม่มีรายการใดตรงกับเงื่อนไขการค้นหา::l::No record satisfy your search"); ?> <BR><BR><BR>
<?php 
		} elseif ($NRow == 1) { 
			$row=tmq_fetch_array($result);
			//printr($row);
			$indexdb=tmq("select * from index_db where ID='$row[id]' ",false);
			//echo tnr($indexdb);
			$row=tfa($indexdb);
			//echo "[$row[remoteindex]]";
			//printr($row);
			if ($row[remoteindex]=='localDB') {
			$_TBWIDTH="100%";
			pagesection("แสดงผลการสืบค้นที่พบ 1 รายการ::l::Display result, found 1 Bibliographic");
?>
<table bgcolor=white width=100% border=0 align=center cellpadding=1
cellspacing=0 >
<tr><td><a href='<?php  echo $dcrURL;?>dublinfull.php?f=all&ID=<?php  echo $row[mid];?>' target=_blank><B>Marc Display</B></a></td>
  </tr></table>
 <?php 
			echo html_displaymedia($row[mid]);
			$ID=$row[mid];
			//echo $dcrs;
			include($dcrs."dublin.bibacc.php");
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
	<INPUT TYPE="submit" value="<?php  echo getlang("Save This Record");?>" class=frmbtn style="width:200px"><BR><iframe name=savemarked width=400  height=20 frameborder=0 scrolling=NO align=absmiddle src="savemarked.php"></iframe></TD>
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
			?><table width = "<?php  echo $currentsearchwidth;?>" align = center border = "0" cellspacing = "1" cellpadding = "3">
			<FORM METHOD=POST ACTION="savemarked.php" target=savemarked name="searchform">
			<?php 
			local_media_headtr();
				$i=1;
				search_inc_media($row);
			local_media_headtr();
			?>			<tr><td colspan=5 width=100%><INPUT TYPE="submit" value="Save Marked Record" class=frmbtn style="width:200px">
			<iframe name=savemarked width=300  height=20 frameborder=0 scrolling=NO align=absmiddle src="savemarked.php"></iframe></td></tr>
			</FORM><?php 
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
			<tr><td colspan=5 width=100%><INPUT TYPE="submit" value="Save Marked Record" class=frmbtn style="width:200px">
			<iframe name=savemarked width=300  height=20 frameborder=0 scrolling=NO align=absmiddle src="savemarked.php"></iframe></td></tr>
			</FORM>
<?php 
				echo $_pagesplit_btn_var;	
			?>
    </table>
    <?php 
		}

////////////////////////////////////////////////////////////////////////////////////////////////////////
$retdata=Array();
?>
<script type="text/javascript">
<!--
	top.local_filterupdate('clear');
	top.local_filterupdate('setsearchkw',"<?php  echo addslashes($KW);?>");
	top.local_filterupdate('setsearchindex',"<?php  echo addslashes($indexcode);?>");
//-->
</script>
<?php 
$retdata[indexpredict]=Array();
$searchdb=tmq_dump2("index_ctrl","code","name,fid","where ispresearch='yes' order by ordr");
@reset($searchdb);
while (list($k,$v)=each($searchdb)) {
	$searchname=getlang($v[0]);
	$indexfid_local=getlang($v[1]);
	$_basesearchsql2=local_buildsearchsql("BUILDONLYBASE",$indexfid_local);
	$c="select count(id) as cc from index_db where (ispublish='yes' or importid like 'havester:%') and $_basesearchsql2  ";
	//echo $c;
	//echo "[$mapdb[$searchdbkey]]";
	$tmplocal_getsearchnumcache=local_getsearchnumcache($c);
	if (trim($tmplocal_getsearchnumcache)!="") {
		$retdata[indexpredict][$k]=Array();
		$retdata[indexpredict][$k][fid]=$k;
		$retdata[indexpredict][$k][name]=$searchname;
		$retdata[indexpredict][$k][cc]=number_format($tmplocal_getsearchnumcache);
	} else {
		$c=tmq($c,false);
		$c=tmq_fetch_array($c);
		$retdata[indexpredict][$k]=Array();
		$retdata[indexpredict][$k][fid]=$k;
		$retdata[indexpredict][$k][name]=$searchname;
		$retdata[indexpredict][$k][cc]=number_format($c[cc]);
	}
}
///////////////////////////////////////////////////////mdtype 
if (barcodeval_get("webpage-o-searchmdtypedecis")=="yes") {
	$_basesearchsql=local_buildsearchsql("mdtype");
	$classlim="select SQL_CACHE distinct mdtype from index_db where ".$_basesearchsql;
	$classlim.=" and mdtype<>',' and mdtype<>'' ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	while ($classlimr=tmq_fetch_array($classlim)) {
		$thisa=explode(',',$classlimr[mdtype]);
		$alla=array_merge($alla, $thisa);
		$alla=array_unique($alla);
	}

	$alla=arr_filter_remnull($alla);
	sort($alla);	
	//printr($alla);
	//$mdtypedb
	$retdata[mdtypepredict]=Array();
	while (is_array($alla) && list($k,$v)=each($alla)) {
		$c="select count(id) as cc from index_db where  (ispublish='yes' or importid like 'havester:%')  and $_basesearchsql and mdtype like '%,$v,%' ";
		$tmplocal_getsearchnumcache=local_getsearchnumcache($c);
		if (trim($tmplocal_getsearchnumcache)!="") {
			if (floor($tmplocal_getsearchnumcache)!=0) {
				$retdata[mdtypepredict][$k]=Array();
				$retdata[mdtypepredict][$k][fid]=$v;
				$retdata[mdtypepredict][$k][name]=getlang($mdtypedb[$v]);
				$retdata[mdtypepredict][$k][cc]=number_format($tmplocal_getsearchnumcache);
			}
		} else {
			$c=tmq($c,false);
			$c=tmq_fetch_array($c);
			//printr($c);
			if (floor($c[cc])!=0) {
				$retdata[mdtypepredict][$k]=Array();
				$retdata[mdtypepredict][$k][fid]=$v;
				$retdata[mdtypepredict][$k][name]=getlang($mdtypedb[$v]);
				$retdata[mdtypepredict][$k][cc]=number_format($c[cc]);
			}
		}
	}
}
////////////////////////////////////////////////////////////////////////////////////////place
if (barcodeval_get("webpage-o-searchmdplacedecis")=="yes") {
	$_basesearchsql=local_buildsearchsql("place");
	//$shelvesdb
	//$libsitedb
	$classlim="select SQL_CACHE distinct placelist from index_db where ".$_basesearchsql;
	$classlim.=" and placelist<>',' and placelist<>'' ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	while ($classlimr=tmq_fetch_array($classlim)) {
		$thisa=explode(',',$classlimr[placelist]);
		$alla=array_merge($alla, $thisa);
		$alla=array_unique($alla);
	}
	$alla=arr_filter_remnull($alla);
	sort($alla);
	@reset($alla);
	//printr($db);
	$retdata[placepredict]=Array();
	while (is_array($alla) && list($k,$v)=each($alla)) {
		$c="select count(id) as cc from index_db where  (ispublish='yes' or importid like 'havester:%')  and $_basesearchsql and placelist like '%,$v,%' ";
		$tmplocal_getsearchnumcache=local_getsearchnumcache($c);
		if (trim($tmplocal_getsearchnumcache)!="") {
			$retdata[placepredict][$k]=Array();
			$retdata[placepredict][$k][fid]=$v;
			$retdata[placepredict][$k][name]=getlang($shelvesdb[$v][0]);
			$retdata[placepredict][$k][libsite]=($shelvesdb[$v][1]);
			$retdata[placepredict][$k][libsitename]=getlang($libsitedb[trim(($shelvesdb[$v][1]))]);
			$retdata[placepredict][$k][cc]=number_format($tmplocal_getsearchnumcache);
		} else {
			$c=tmq($c);
			$c=tmq_fetch_array($c);
			//printr($c);
			$retdata[placepredict][$k]=Array();
			$retdata[placepredict][$k][fid]=$v;
			$retdata[placepredict][$k][name]=getlang($shelvesdb[$v][0]);
			$retdata[placepredict][$k][libsite]=($shelvesdb[$v][1]);
			$retdata[placepredict][$k][libsitename]=getlang($libsitedb[trim(($shelvesdb[$v][1]))]);
			$retdata[placepredict][$k][cc]=number_format($c[cc]);
		}
	}
}
//////////////////////////////////////////////////////////////lang
if (barcodeval_get("webpage-o-searchmdlangdecis")=="yes") {
	$_basesearchsql=local_buildsearchsql("lang");
	include("./search.filterframe.langset.php");
	$classlim="select SQL_CACHE distinct SUBSTRING(fixw,34,3) as reslang  from index_db where  ".$_basesearchsql;
	$classlim.="  order by reslang desc ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	$max=100;
	$count=0;
	while ($classlimr=tmq_fetch_array($classlim)) {
		$tmp=local_getlangfromcode($classlimr[reslang]);
		if ($tmp!="") {
			$count++;
			if ($count<=$max) {
			  $alla[$classlimr[reslang]]=$tmp;
			}
		}
	}
	$alla=arr_filter_remnull($alla);
	$allselected=count($alla);
	//printr($alla);
	@reset($alla);

	$i=0;
	while (list($k,$v)=each($alla)) {
		$i++;
		$c="select count(id) as cc from index_db where  (ispublish='yes' or importid like 'havester:%')  and $_basesearchsql and fixw like '_________________________________$k%' ";
		$tmplocal_getsearchnumcache=local_getsearchnumcache($c);
		if (trim($tmplocal_getsearchnumcache)!="") {
			$retdata[langpredict][$k]=Array();
			$retdata[langpredict][$k][fid]=$k;
			$retdata[langpredict][$k][name]=$v;
			$retdata[langpredict][$k][cc]=number_format($tmplocal_getsearchnumcache);
		} else {
			$c=tmq($c,false);
			$c=tmq_fetch_array($c);
			//printr($c);
			$retdata[langpredict][$k]=Array();
			$retdata[langpredict][$k][fid]=$k;
			$retdata[langpredict][$k][name]=$v;
			$retdata[langpredict][$k][cc]=number_format($c[cc]);
		}
	}
}
/////////////////////////////////////////////////////////////////yea
$yearthensepper=floor(getval("_SETTING","yearthensepper"));
if (barcodeval_get("webpage-o-searchmdyeadecis")=="yes") {
	$_basesearchsql=local_buildsearchsql("yea");
	$classlim="select distinct FLOOR(SUBSTRING(fixw,6,4)) as resyear,count(id) as cc  from index_db where ispublish='yes' and ".$_basesearchsql;
	$classlim.=" group by resyear having resyear>1000 and resyear<3000 order by resyear desc ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	$max=100;
   $tmpyearstackuse=Array();
	while ($classlimr=tmq_fetch_array($classlim)) {
        //printr($classlimr);
		  $alla[]=$classlimr[resyear];
        $tmpyearkey=$classlimr[resyear];
         if ($tmpyearkey<$yearthensepper) {
         	$tmpyearkey=$tmpyearkey+543;
         }
        $tmpyearstackuse[$tmpyearkey]=floor($tmpyearstackuse[$tmpyearkey])+$classlimr[cc];
	}
	$alla=arr_filter_remnull($alla);
	$allselected=count($alla);
	//printr($alla);
	@reset($alla);
	$i=0;
	while (list($k,$v)=each($alla)) {
		$tmpv=$v;
		if ($v<$yearthensepper) {
			$tmpv=$v+543;
		}
		$retdata[yearpredict][]=$tmpv;
	}

   
   ksort($tmpyearstackuse);
   @reset($tmpyearstackuse);
   $tmpyearstackusestr="";
   $tmpyearstackusemax=0;
   while (list($tmpyearstackusek,$tmpyearstackusev)=each($tmpyearstackuse)) {
      $tmpyearstackusestr.=":".$tmpyearstackusek."=".$tmpyearstackusev;
      if ($tmpyearstackusemax<$tmpyearstackusev) {
         $tmpyearstackusemax=$tmpyearstackusev;
      }
   }
   $tmpyearstackusestr=$tmpyearstackusemax.";".trim($tmpyearstackusestr,":");
   //echo "[$tmpyearstackusestr]";
   //printr($tmpyearstackuse);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////oaicate
	$_basesearchsql=local_buildsearchsql("oairepocate");
	//$tmpoaireponamedb=tmq_dump2("oai_repocate","code","name");
	$classlim="select SQL_CACHE distinct substr(remoteindex,5) as oairepo  from index_db where  ".$_basesearchsql;
	$classlim.="  order by oairepo desc ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	$max=100;
	$count=0;
	while ($classlimr=tmq_fetch_array($classlim)) { //printr($classlimr);
		$tmp=trim($classlimr[oairepo]);
		if ($tmp!="") {
			$count++;
			if ($count<=$max) {
			   $oairepogetcatecode=tmq("select * from oai_repo where code='$classlimr[oairepo]' ",false);
			   $oairepogetcatecoder=tfa($oairepogetcatecode);
			   $alla[$oairepogetcatecoder[cate]]=getlang($repocatedb[$oairepogetcatecoder[cate]][name]);
			}
		}
	}
	$alla=arr_filter_remnull($alla);
	$allselected=count($alla);
	//printr($alla);
	@reset($alla);

	$i=0;
	while (list($k,$v)=each($alla)) {
      //echo "[$k]";
		$i++;
		$c="select count(id) as cc from index_db where  (ispublish='yes' or importid like 'havester:%')  and $_basesearchsql and remoteindex in (".$repocatedb[$k][subs].") ";
		//echo $c;
		$tmplocal_getsearchnumcache=local_getsearchnumcache($c);
		if (trim($tmplocal_getsearchnumcache)!="") {
			$retdata[oairepocate][$k]=Array();
			$retdata[oairepocate][$k][fid]=$k;
			$retdata[oairepocate][$k][name]=$v;
			$retdata[oairepocate][$k][cc]=number_format($tmplocal_getsearchnumcache);
		} else {
			$c=tmq($c,false);
			$c=tmq_fetch_array($c);
			//printr($c);
			$retdata[oairepocate][$k]=Array();
			$retdata[oairepocate][$k][fid]=$k;
			$retdata[oairepocate][$k][name]=$v;
			$retdata[oairepocate][$k][cc]=number_format($c[cc]);
		}
	}


//printr($retdata);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////oai
	$_basesearchsql=local_buildsearchsql("oairepo");
	$tmpoaireponamedb=tmq_dump2("oai_repo","code","name");
	$classlim="select SQL_CACHE distinct substr(remoteindex,5) as oairepo  from index_db where  ".$_basesearchsql;
	$classlim.="  order by oairepo desc ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	$max=100;
	$count=0;
	while ($classlimr=tmq_fetch_array($classlim)) { //printr($classlimr);
		$tmp=getlang($tmpoaireponamedb[$classlimr[oairepo]]);
		if ($tmp!="") {
			$count++;
			if ($count<=$max) {
			  $alla[$classlimr[oairepo]]=$tmp;
			}
		}
	}
	$alla=arr_filter_remnull($alla);
	$allselected=count($alla);
	//printr($alla);
	@reset($alla);

	$i=0;
	while (list($k,$v)=each($alla)) {
		$i++;
		$c="select count(id) as cc from index_db where  (ispublish='yes' or importid like 'havester:%')  and $_basesearchsql and remoteindex ='oai-$k' ";
		$tmplocal_getsearchnumcache=local_getsearchnumcache($c);
		if (trim($tmplocal_getsearchnumcache)!="") {
			$retdata[oairepo][$k]=Array();
			$retdata[oairepo][$k][fid]=$k;
			$retdata[oairepo][$k][name]=$v;
			$retdata[oairepo][$k][cc]=number_format($tmplocal_getsearchnumcache);
		} else {
			$c=tmq($c,false);
			$c=tmq_fetch_array($c);
			//printr($c);
			$retdata[oairepo][$k]=Array();
			$retdata[oairepo][$k][fid]=$k;
			$retdata[oairepo][$k][name]=$v;
			$retdata[oairepo][$k][cc]=number_format($c[cc]);
		}
	}


/////////////////////////////////////////////////////////////////havester
if ($_ISULIBHAVESTER=="yes") {

	$_basesearchsql=local_buildsearchsql("havester");
	$tmphavesternamedb=tmq_dump2("ulibhavestlist","code","brief");
	$classlim="select SQL_CACHE distinct substr(importid,10) as havestc  from index_db where  ".$_basesearchsql;
	$classlim.="  order by havestc desc ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	$max=100;
	$count=0;
   //printr($tmphavesternamedb);
	while ($classlimr=tmq_fetch_array($classlim)) { //printr($classlimr);
		$tmp=getlang($tmphavesternamedb[$classlimr[havestc]]);
		if ($tmp!="") {
			$count++;
			if ($count<=$max) {
			  $alla[$classlimr[havestc]]=$tmp;
			}
		}
	}
	$alla=arr_filter_remnull($alla);
	$allselected=count($alla);
	//printr($alla);
	@reset($alla);

	$i=0;
	while (list($k,$v)=each($alla)) {
		$i++;
		$c="select count(id) as cc from index_db where  (ispublish='yes' or importid like 'havester:%') and $_basesearchsql and importid ='havester:$k' ";
      //echo $c."<br>";
      //echo "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

		$tmplocal_getsearchnumcache=local_getsearchnumcache($c);
      //echo "zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz";

		if (trim($tmplocal_getsearchnumcache)!="") {
			$retdata[havester][$k]=Array();
			$retdata[havester][$k][fid]=$k;
			$retdata[havester][$k][name]=$v;
			$retdata[havester][$k][cc]=number_format($tmplocal_getsearchnumcache);
		} else {
			$c=tmq($c,false);
			$c=tmq_fetch_array($c);
			//printr($c);
			$retdata[havester][$k]=Array();
			$retdata[havester][$k][fid]=$k;
			$retdata[havester][$k][name]=$v;
         //echo $c."$c[cc]<br>";
			$retdata[havester][$k][cc]=number_format($c[cc]);
		}
	}


//printr($retdata);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$chkbox_on="<img src='$dcrURL"."neoimg/checkbox-on.png' width=16 height=16 border=0 style='vertical-align:text-bottom;'>";
$chkbox_off="<img src='$dcrURL"."neoimg/checkbox-off.png' width=16 height=16 border=0 style='vertical-align:text-bottom;'>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (count($retdata[indexpredict])>0) {
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("สืบค้นที่ไหนดี::l::Where to search");?>");
//--></script><?php 
	@reset($retdata[indexpredict]);
	while (list($k,$v)=each($retdata[indexpredict])) {
	?><script type="text/javascript"><!--
	top.local_filterupdate('addsearchoption_single',"<?php  echo $v[name] . "(".$v[cc].")"?>","<?php  echo $v[fid]?>");
//--></script><?php 
	}
}
///////////////////////////////////////////////////////oairepocate
if (count($retdata[oairepocate])>0) {
	$tmpdspreponame=""
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("กลุ่มแหล่งข้อมูล::l::Repository Group");?>");
//--></script><?php 
   //printr($repocatedb);
	@reset($retdata[oairepo]);
	while (list($k,$v)=each($retdata[oairepocate])) {
		if ($processsearchfilter[oairepocate][$v[fid]]=="yes" && local_anyyesmember($processsearchfilter[oairepocate])==true) {
			$localimg=$chkbox_on;
		} else {
			$localimg=$chkbox_off;
		}
		//printr($v);
	?><script type="text/javascript"><!--
	top.local_filterupdate('addsearchoption',"<?php  
	$tmpdspmdtypename=$v[name];
	if (trim($tmpdspmdtypename)=="") {
		$tmpdspmdtypename=$v[fid];
	}
	echo  $localimg.$tmpdspmdtypename. "(".$v[cc].")"?>","oairepocate","<?php  echo $v[fid]?>");
//--></script><?php 
	}
}
///////////////////////////////////////////////////////oairepo
if (count($retdata[oairepo])>0) {
	$tmpdspreponame=""
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("แหล่งข้อมูล::l::Repository");?>");
//--></script><?php 
	@reset($retdata[oairepo]);
	while (list($k,$v)=each($retdata[oairepo])) {
		if ($processsearchfilter[oairepo][$v[fid]]=="yes" && local_anyyesmember($processsearchfilter[oairepo])==true) {
			$localimg=$chkbox_on;
		} else {
			$localimg=$chkbox_off;
		}
		//printr($v);
	?><script type="text/javascript"><!--
	top.local_filterupdate('addsearchoption',"<?php  
	$tmpdspmdtypename=$v[name];
	if (trim($tmpdspmdtypename)=="") {
		$tmpdspmdtypename=$v[fid];
	}
	echo  $localimg.$tmpdspmdtypename. "(".$v[cc].")"?>","oairepo","<?php  echo $v[fid]?>");
//--></script><?php 
	}
}
///////////////////////////////////////////////////////havester
if (count($retdata[havester])>0) {
	$tmpdspreponame=""
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("แหล่งข้อมูล::l::Repository");?>");
//--></script><?php 
	@reset($retdata[havester]);
	while (list($k,$v)=each($retdata[havester])) {
		if ($processsearchfilter[havester][$v[fid]]=="yes" && local_anyyesmember($processsearchfilter[havester])==true) {
			$localimg=$chkbox_on;
		} else {
			$localimg=$chkbox_off;
		}
		//printr($v);
	?><script type="text/javascript"><!--
	top.local_filterupdate('addsearchoption',"<?php  
	$tmpdspmdtypename=$v[name];
	if (trim($tmpdspmdtypename)=="") {
		$tmpdspmdtypename=$v[fid];
	}
	echo  $localimg.$tmpdspmdtypename. "(".$v[cc].")"?>","havester","<?php  echo $v[fid]?>");
//--></script><?php 
	}
}

///////////////////////////////////////////////////////mdtype
if (count($retdata[mdtypepredict])>0) {
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("ต้องการประเภทวัสดุ::l::Resource Type");?>");
//--></script><?php 
	@reset($retdata[mdtypepredict]);
	while (list($k,$v)=each($retdata[mdtypepredict])) {
		if ($processsearchfilter[mdtype][$v[fid]]=="yes" && local_anyyesmember($processsearchfilter[mdtype])==true) {
			$localimg=$chkbox_on;
		} else {
			$localimg=$chkbox_off;
		}
		//printr($v);
	?><script type="text/javascript"><!--
	top.local_filterupdate('addsearchoption',"<?php  
	$tmpdspmdtypename=$v[name];
	if (trim($tmpdspmdtypename)=="") {
		$tmpdspmdtypename=$v[fid];
	}
	echo  $localimg.$tmpdspmdtypename. "(".$v[cc].")"?>","mdtype","<?php  echo $v[fid]?>");
//--></script><?php 
	}
}
////////////////////////////////////////////////////////////////////////////////////////place
if (count($retdata[placepredict])>0) {
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("สถานที่::l::Shelves");?>");
//--></script><?php 
	@reset($retdata[placepredict]);
	while (list($k,$v)=each($retdata[placepredict])) {
		if ($processsearchfilter[place][$v[fid]]=="yes" && local_anyyesmember($processsearchfilter[place])==true) {
			$localimg=$chkbox_on;
		} else {
			$localimg=$chkbox_off;
		}
	?><script type="text/javascript"><!--
	top.local_filterupdate('addsearchoption',"<?php  echo $localimg.$v[name] . "(".$v[cc].")"."<br> &nbsp;&nbsp;&gt;".$v[libsitename]?>","place","<?php  echo $v[fid]?>");
//--></script><?php 
	}
}
//////////////////////////////////////////////////////////////lang
if (count($retdata[langpredict])>0) {
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("ภาษา::l::Languages");?>");
//--></script><?php 
	@reset($retdata[langpredict]);
	while (list($k,$v)=each($retdata[langpredict])) {
		if ($processsearchfilter[lang][$v[fid]]=="yes" && local_anyyesmember($processsearchfilter[lang])==true) {
			$localimg=$chkbox_on;
		} else {
			$localimg=$chkbox_off;
		}
	?><script type="text/javascript"><!--
	top.local_filterupdate('addsearchoption',"<?php  echo $localimg.$v[name] . "(".$v[cc].")"; ?>","lang","<?php  echo $v[fid]?>");
//--></script><?php 
	}
}
/////////////////////////////////////////////////////////////////yea
if (count($retdata[yearpredict])>0) {
	if (floor($processsearchfilter[yea_start])==0) {
		$processsearchfilter[yea_start]=min($retdata[yearpredict]);
	}
	if (floor($processsearchfilter[yea_end])==0) {
		$processsearchfilter[yea_end]=max($retdata[yearpredict]);
	}
	?><script type="text/javascript"><!--
	top.local_filterupdate('addheader',"<?php  echo getlang("ปีพิมพ์::l::Year");?>");
//--></script><?php 
	?><script type="text/javascript"><!--
	top.local_filterupdate('addyearoption',"<?php  echo min($retdata[yearpredict])?>","<?php  echo max($retdata[yearpredict])?>","<?php  echo floor($processsearchfilter[yea_start]);?>","<?php  echo floor($processsearchfilter[yea_end]);?>");
//--></script><?php 
   if ($tmpyearstackusestr!="") {
	?><script type="text/javascript"><!--
	top.local_filterupdate('addyearoptiongraph',"<?php  echo $tmpyearstackusestr?>","","","");
//--></script><?php 
   }
}

	?><script type="text/javascript"><!--
	top.local_filterupdate('resetall');
//--></script><?php 

$historyviewbiblist=sessionval_get("historyviewbiblist");
$historyviewbiblist=unserialize($historyviewbiblist);
$historyviewbiblist=arr_filter_remnull($historyviewbiblist);
if (count($historyviewbiblist)!=0) {
	?><script type="text/javascript"><!--
	top.local_histupdate('<?php  echo count($historyviewbiblist);?>');
//--></script><?php 
} else {
	?><script type="text/javascript"><!--
	top.local_histupdate('resetall');
//--></script><?php 
}
?>

<?php 
if (isset($_GET[startrow]) || floor($_GET[startrow])!=0) {
	?><script type="text/javascript"><!--
	top.scrollTo(0,0);
//--></script><?php 
}
?>