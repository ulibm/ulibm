<?php  
;
ob_start();
//sleep(3);
  include("inc/config.inc.php");
$puresearchstr=trim(sessionval_get("puresearchstr"));

$tmpget=print_r($_GET,true);
$dspv=sessionval_get("searchdspv");
$dspv=$dspv."&";
$dspv=str_replace('&&','&',$dspv);
$dspv=str_replace('limitplacespec=&','',$dspv);
$dspv=str_replace('resourcetypespec=&','',$dspv);
$dspv=str_replace('searchyear=&','',$dspv);
$dspv=str_replace('searchlang=&','',$dspv);
$dspv=str_replace('searchbybarcode=&','',$dspv);
$dspv=str_replace('searchbybibid=&','',$dspv);
$puresearchnolimitsql=trim(sessionval_get("puresearchnolimitsql"));
$puresearchonlylimitsql=trim(sessionval_get("puresearchonlylimitsql"));
$cachecode=md5($puresearchstr."-".$tmpget."-".$dspv."-".$puresearchnolimitsql."-".$puresearchonlylimitsql);;

///pcache_s($cachecode,0,0,false,"search-filterframe");

include ("./search.inc.func.php");
	
	html_start();
	$pure_sql=sessionval_get("searchsql");
	$mapdb=tmq_dump("index_ctrl","code","fid");

	if ($puresearchstr=="") {$puresearchstr='_';}
	if ($puresearchnolimitsql=="") {$puresearchnolimitsql=' anD 1';}
	if ($puresearchonlylimitsql=="") {$puresearchonlylimitsql=' anD 1';}
	$dspv=stripslashes($dspv);
	$dspv=stripslashes($dspv);
	$dspv=stripslashes($dspv);
	//echo "[$dspv]";
	$_PAGE_FILE=sessionval_get("_PAGE_FILE");
	//echo $_PAGE_FILE;
	if ($_PAGE_FILE=="") {
		$_PAGE_FILE="advsearching.php";
	}
	?>
<style>
body {
	background-color: #E8FDEB;
}
</style>



<table width=100%>
<tr><td style="background-image: url(./neoimg/search.refine.png);background-repeat: no-repeat; height: 60; padding-left: 25px; padding-top: 30px;" valign=top>
<B><?php echo getlang("กำหนดขอบเขต::l::Search Refining");?></B></td></tr>
</table>

	<TABLE width=100% align=center noclass=table_border>
	<TR>
	<TD class=table_td width=25%><?php echo getlang("สืบค้นที่ไหนดี::l::Where to search");?></TD>
				</tr>
		</TABLE>
<?php  
$someshown="no";


if ($puresearchstr!="_" && $puresearchstr!="") {
//start search list by index_ctrl
$searchdb=tmq_dump2("index_ctrl","code","name,fid","where ispresearch='yes' order by ordr");

reset($searchdb);

//printr($mapdb);

foreach ($searchdb as $searchdbkey => $searchdbvalue) {
	$searchname=getlang($searchdbvalue[0]);
	///1 $pure_sql  AND //stripped sql;
	$c="select count(id) as cc from index_db where 1 $puresearchonlylimitsql  AND  (1 
	" . ssql(trim($puresearchstr),$mapdb[$searchdbkey]) . " ) ";
	//echo "[$mapdb[$searchdbkey]]";
	$c=tmq($c,false);
	$c=tmq_fetch_array($c);
	echo "<span class=smaller>";
	if ($c[cc]!=0) {
		echo "<A HREF='$_PAGE_FILE?$dspv&kw[]=".trim($puresearchstr).
		"&bool[]=[[AND]]&searchopt[]=$searchdbkey' target=_top class=smaller>";
	}
	echo $searchname ."</A> (".number_format($c[cc]).")</span><BR>";
}
?><BR><?php  

}
ob_flush(); flush();// sleep(1);

//echo barcodeval_get("webpage-o-searchmdtypedecis");
if (barcodeval_get("webpage-o-searchmdtypedecis")=="yes") {
$pos = strpos($dspv, "resourcetypespec=");
if ($pos === false) {		
	$someshown="yes";


	$classlim="select distinct mdtype from index_db where 1 ".$pure_sql;
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

	?><TABLE width=100%><TD class=table_td ><?php echo getlang("มีประเภทวัสดุ::l::Material Type");?></TD>
				</tr></table>
				<?php  

	@reset($alla);	
	$db=tmq_dump2("media_type","code","name");
	//printr($alla);
	if (!is_array($alla) || count($alla)==0|| count($alla)<1) {
		 echo "&nbsp; <font color=gray class=smaller>".getlang("ไม่มีรายการที่ตรงเงื่อนไข::l::No option available")."</font>";
	}
	$dspv2=local_gethiddenquery($dspv,"resourcetypespec");
	if (!is_array($alla) ) {
		 echo "&nbsp; <font color=gray class=smaller>".getlang("ไม่มีรายการที่ตรงเงื่อนไข::l::No option available")."</font>";
	}
	while (is_array($alla) && list($k,$v)=each($alla)) {
	  $c=tmq("select count(id) as cc from index_db where 1 $pure_sql and mdtype like '%,$v,%' ");
		$c=tmq_fetch_array($c);
		$db[$v]=trim(getlang($db[$v]));
		//printr($c);
		if ($db[$v]!="") {
			echo "<span class=smaller><A HREF='$_PAGE_FILE?$dspv2&resourcetypespec=$v' target=_top class=smaller>".($db[$v])."</A> (".number_format($c[cc]).")</span><BR>";
		}
	}
	?><BR><?php  
} else {
	//echo "&nbsp; <font color=gray>".getlang("กำหนดแล้ว::l::Defined")."</font>";
}		

}
ob_flush(); flush();// sleep(1);

if (barcodeval_get("webpage-o-searchmdplacedecis")=="yes") {

$pos = strpos($dspv, "limitplacespec=");
if ($pos === false) {
	$someshown="yes";
	?><TABLE width=100%><tr>
			<TD class=table_td ><?php echo getlang("สถานที่จัดเก็บ::l::Location ");?></TD>
</tr></table>
<?php  
	$classlim="select distinct placelist from index_db where 1 ".$pure_sql;
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
	if (!is_array($alla) || count($alla)==0) {
		 echo "&nbsp; <font color=gray class=smaller>".getlang("ไม่มีรายการที่ตรงเงื่อนไข::l::No option available")."</font>";
	}
	$db=tmq_dump2("media_place","code","name,main");
	$db_libsite=tmq_dump2("library_site","code","name");
	//printr($db);
	$dspv2=local_gethiddenquery($dspv,"limitplacespec");
	while (is_array($alla) && list($k,$v)=each($alla)) {
	  $c=tmq("select count(id) as cc from index_db where 1 $pure_sql and placelist like '%,$v,%' ");
		$c=tmq_fetch_array($c);
		//printr($c);
		echo "<span class=smaller><A HREF='$_PAGE_FILE?$dspv2&limitplacespec=$v' target=_top class=smaller>".getlang($db[$v][0])."</A> (".number_format($c[cc]).")<BR>&nbsp;&nbsp; <FONT  COLOR=#757575 class=smaller style='font-size:13px;'>(".getlang($db_libsite[$db[$v][1]]).")</FONT></span><BR>";
	}
	?><BR><?php  
} else {
	//echo "&nbsp; <font color=gray>".getlang("กำหนดแล้ว::l::Defined")."</font>";
}	

} // isshow place
ob_flush(); flush();// sleep(1);

if (barcodeval_get("webpage-o-searchmdlangdecis")=="yes") {

$pos = strpos($dspv, "searchlang=");
if ($pos === false) {
	 include("./search.filterframe.langset.php");
$someshown="yes";
	?>	<TABLE width=100%><TR valign=top>

				<TD class=table_td ><?php echo getlang("ภาษา::l::Language");?></TD></tr></table>
<?php  
	$classlim="select distinct SUBSTRING(fixw,34,3) as reslang  from index_db where 1 ".$pure_sql;
	$classlim.="  order by reslang desc ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	$max=10;
	if ($fullmode=="yes") {
		 $max=100;
	}
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
	if (!is_array($alla) || count($alla)==0) {
		 echo "&nbsp; <font color=gray class=smaller>".getlang("ไม่มีรายการที่ตรงเงื่อนไข::l::No option available")."</font>";
	}	
	$dspv2=local_gethiddenquery($dspv,"searchlang");
	$i=0;
	while (list($k,$v)=each($alla)) {
		$i++;
	  $c=tmq("select count(id) as cc from index_db where 1 $pure_sql and fixw like '_________________________________$k%' ",false);
		$c=tmq_fetch_array($c);
		//printr($c);
		echo "<span class=smaller>$i. <A HREF='$_PAGE_FILE?$dspv2&searchlang=$k' target=_top class=smaller>".ucwords(getlang($v))."</A> (".number_format($c[cc]).")</span><BR>";
	}
	if ($allselected>$max) {
		$allselecteddsp=$allselected-$max;
		 echo "<div align=right><a href='search.filterframe.php?fullmode=yes' class=smaller2>".getlang("มีอีก $allselecteddsp::l::$allselecteddsp more")." ..</a></div>";
	}
	?><BR><?php  
} else {
	//echo "&nbsp; <font color=gray>".getlang("กำหนดแล้ว::l::Defined")."</font>";
}

} //isshow lang
ob_flush(); flush();// sleep(1);

if (barcodeval_get("webpage-o-searchmdyeadecis")=="yes") {

$pos = strpos($dspv, "searchyear=");
if ($pos === false) {
$someshown="yes";
	?>	<TABLE width=100%><TR valign=top>

				<TD class=table_td ><?php echo getlang("ปี::l::Year");?></TD></tr></table>
<?php  
	$classlim="select distinct FLOOR(SUBSTRING(fixw,6,4)) as resyear  from index_db where 1 ".$pure_sql;
	$classlim.=" having resyear>1000 and resyear<3000 order by resyear desc ";
	$classlim=tmq($classlim,false);
	$alla=Array();
	$max=5;
	if ($fullmode=="yes") {
		 $max=100;
	}
	while ($classlimr=tmq_fetch_array($classlim)) {
		  $alla[]=$classlimr[resyear];
	}
	$alla=arr_filter_remnull($alla);
	$allselected=count($alla);
	//printr($alla);
	@reset($alla);
	if (!is_array($alla) || count($alla)==0) {
		 echo "&nbsp; <font color=gray class=smaller>".getlang("ไม่มีรายการที่ตรงเงื่อนไข::l::No option available")."</font>";
	}	
	$dspv2=local_gethiddenquery($dspv,"searchyear");
	$i=0;
	while (list($k,$v)=each($alla)) {
		$i++;
		if ($i>$max) {
			break;
		}
	  $c=tmq("select count(id) as cc from index_db where 1 $pure_sql and fixw like '_____$v%' ",false);
		$c=tmq_fetch_array($c);
		//printr($c);
		echo "<span class=smaller>$i. <A HREF='$_PAGE_FILE?$dspv2&searchyear=$v' target=_top class=smaller>".getlang($v)."</A> (".number_format($c[cc]).")</span><BR>";
	}
	if ($allselected>$max) {
		$allselecteddsp=$allselected-$max;
		 echo "<div align=right><a href='search.filterframe.php?fullmode=yes' class=smaller2>".getlang("มีอีก $allselecteddsp::l::$allselecteddsp more")." ..</a></div>";
	}
	?><BR><?php  
} else {
	//echo "&nbsp; <font color=gray>".getlang("กำหนดแล้ว::l::Defined")."</font>";
}

} // isshow year
ob_flush(); flush();// sleep(1);



//start searchcloud

$someshown="yes";
	?>	<TABLE width=100%><TR valign=top>

				<TD class=table_td ><?php echo getlang("คำอื่นๆ::l::Search Cloud");?></TD></tr>
<tr>			<TD noclass=table_td  style='font-family:Tahoma;'><?php  
	$cloud="select * from searchcloud where isshow ='yes' order by ordr ";
	$cloud=tmq($cloud,false);

	while ($clor=tmq_fetch_array($cloud)) {
		$maxcloud=$clor[dspnum];
		if ($maxcloud>40) {$maxcloud=40;}
		if ($maxcloud<3) {$maxcloud=3;}
		echo "<i  class=smaller>".getlang($clor[name])."</i><BR>";
		$alla=explodenewline($clor[cloud]);
		$alla=arr_filter_remnull($alla);
		$allac=count($alla);
		//echo "[$allac/$maxcloud]";
		if ($allac>=$maxcloud) {$allac=$maxcloud;}
		$rand_keys = array_rand($alla, count($alla));
		echo "<div style='padding-left: 3px; display:block;border-width: 1px; border-style: dotted; border-color: #CECECE;'>";
		//printr($mapdb);
		for ($i=0;$i<$allac;$i++) {
			$cloudi=trim($alla[$rand_keys[$i]]);
			$cloudi=trim($cloudi);
			if ($cloudi=="") {
				continue;
				//echo("<BR>$i=$rand_keys[$i]");
			}
			$c="select count(id) as cc from index_db where 1 
			" . ssql(trim($cloudi),$mapdb[$clor[fid]]) . "  ";
			//echo "[$mapdb[$searchdbkey]]";
			$c=tmq($c,false);
			$c=tmq_fetch_array($c);
			$c=floor($c[cc]);
			$fsize=11;
			$fcol='#000001';
			if ($c==0) {	$fsize=11; $fcol='#777777';}
			if ($c>=3) {	$fsize=13; $fcol='#000050';}
			if ($c>=5) {	$fsize=13; $fcol='#00005a';}
			if ($c>=7) {	$fsize=13; $fcol='#000064';}
			if ($c>=9) {	$fsize=13; $fcol='#00006e';}
			if ($c>=15) {	$fsize=14; $fcol='#000078';}
			if ($c>=20) {	$fsize=14; $fcol='#000082';}
			if ($c>=25) {	$fsize=14; $fcol='#000096';}
			if ($c>=30) {	$fsize=14; $fcol='#0000a0';}
			if ($c>=35) {	$fsize=14; $fcol='#0000aa';}
			if ($c>=40) {	$fsize=14; $fcol='#0000b4';}
			if ($c>=45) {	$fsize=15; $fcol='#0000be';}
			if ($c!=0) {
				 echo " <!--<nobr>--><A HREF='$_PAGE_FILE?searchdb[$clor[fid]]=".trim(urlencode($cloudi)).
				 	"' target=_top style='font-size:$fsize;color:$fcol; font-family:Tahoma;' >";
			 } else {
				 echo " <!--<nobr>--><A 
				 target=_top style='font-size:$fsize;color:$fcol; font-family:Tahoma;' >";
			}
			echo trim($cloudi);
			echo "<FONT  COLOR=black style='font-size:11; font-family:Tahoma;' >(";
				echo number_format($c);
			echo ")</FONT>";
			if ($c!=0) {
				 echo "</A>";
			}
			echo "<!--</nobr>--> <WBR />
			\n";
			//printr($clor);
			@reset($mapdb);
		}
		echo "</div>";
	}

	?></TD></tr></TABLE><?php  
//end searchcloud


?>
	


<?php  
if ($someshown=="no") {
	echo "&nbsp; <font color=gray>".getlang("กำหนดทุกตัวเลือกแล้ว::l::All options are defined")."</font>";
}

ob_flush(); flush();// sleep(1);
//html_end();
///pcache_e();
?>