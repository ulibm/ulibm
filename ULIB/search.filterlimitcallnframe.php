<?php  //พ
  include("inc/config.inc.php");

$mode=barcodeval_get("webpage-o-searchautocallnfiltertype");
$pure_sql=sessionval_get("puresearchonlylimitsql-nolimitcalln");
$dspv=sessionval_get("searchdspv");
$_PAGE_FILE=sessionval_get("_PAGE_FILE");

if ($_PAGE_FILE=="") {
	$_PAGE_FILE="advsearching.php";
}
$loadsub=$limitcallnloadsub;
$loadsub2=$limitcallnloadsub2;
$baselink="$_PAGE_FILE?$dspv";
$baselink=str_replace('limitcallnloadsub2=','rem=',$baselink);
$baselink=str_replace('limitcallnloadsub=','rem=',$baselink);

pcache_s(base64_encode("$baselink$loadsub$loadsub2"),0,0,false,"search-callnfilterframe");

html_start();
?><style>
.localfocus {
	border-width: 1;
	border-color: #0F288C;
	border-style: solid;
	background-color: #E8EEFD;
	border-bottom-width: 2;
	cursor: hand; cursor: pointer;
}
.localblur {
	border-width: 1;
	border-color: #626262;
	border-style: solid;
	background-color: #E8EEFD;
	border-bottom-width: 2;
	cursor: hand; cursor: pointer;
}
.localfix {
	border-width: 1;
	border-color: #626262;
	border-style: solid;
	background-color: #7C9DF3;
	border-bottom-width: 2;
}
</style><?php  
if ($mode=="DC") {
	$catedb=tmq_dump2("keyhelp_dclist","dc","text","where dc like '_00' ");
	$catedb2=tmq_dump2("keyhelp_dclist","dc","text","where dc like '$loadsub"."_0' ");
	$callni=explode(',',"0,1,2,3,4,5,6,7,8,9");
	$add1="00";
	$add2="0";
	$colspan=10;
	$graphH=50;
}
if ($mode=="LC/NLM") {
	$catedb=tmq_dump2("keyhelp_lclist","num","text","where num like '_' ");
	$catedb2=tmq_dump2("keyhelp_lclist","num","text","where num like '$loadsub"."_' ");
	$callni=explode(',',strtoupper($_STR_A_Z));
	$add1="";
	$add2="";
	$colspan=26;
	$graphH=30;
}
//printr($callni);
//printr($catedb);
	$res=Array();
	$max=0;
	@reset($callni);
	while (list($k,$i)=each($callni)) {
		$n=tmq("select substring(trim(index01),1,1) as callnx from index_db where 1 $pure_sql  having callnx='$i' ");
		$res[$i]=tmq_num_rows($n);
		if ($res[$i]>$max) {
			$max=$res[$i];
		}
		if ($loadsub==$i && $loadsub!="") {
			$defaultdsp=$catedb[$i.$add1];
		} 
	}
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
	function localdsp(txt) {
		tmp=getobj('DISPLAYERx');
		tmp.innerHTML=txt;
	}
	function localdsp2(txt) {
		tmp=getobj('DISPLAYERx2');
		tmp.innerHTML=txt;
	}
	//-->
	</SCRIPT><TABLE width=100% cellpadding=1 cellspacing=2>
	<TR>
	<?php  
//		echo "[ $loadsub [";
if ($defaultdsp=="") {
	$defaultdsp="&nbsp;";
}
@reset($callni);
while (list($k,$i)=each($callni)) {
	if ($loadsub==$i && $loadsub!="") {
		$html=" class='localfix' ";
	} else {
		$html=" class='localblur' 
		onmouseover=\"this.className='localfocus'; localdsp('".$catedb[$i.$add1]."');\"
		onmouseout=\"this.className='localblur'; localdsp('$defaultdsp');\"
		onclick=\"top.location='$baselink&limitcallnloadsub=$i'; \" ";
	}
	?>
		<TD <?php echo $html;?> TITLE="<?php echo $catedb[$i.$add1];?>"><?php 
	if ($mode=="LC/NLM") { echo "<TABLE cellpadding=0 cellspacing=0><TR><TD>"; }
		echo html_graph("H",$max,$res[$i],10,$graphH,"#001155");
	if ($mode=="LC/NLM") { echo "</TD></TR></TABLE>"; }
	echo "<B class=smaller>$i"."$add1<BR>";
	if ($mode=="DC") { echo "<BR>"; }
	echo "</B>";
	echo "<FONT class=smaller2>$res[$i]</FONT>";	
	?></TD>
	<?php  
	}?>
	</TR>
	<!-- ////////////////////////////////////////////////////////////////////////////////////////////////// -->
	<TR>
		<TD colspan=<?php echo $colspan;?> height=15><span class=smaller id="DISPLAYERx"><?php echo $defaultdsp;?></span></TD>
	</TR>
	<?php if ($loadsub!="") { 
	//printr($catedb2);
	$res=Array();
	$max=0;
	@reset($callni);
while (list($k,$i)=each($callni)) {
		$n=tmq("select substring(trim(index01),1,2) as callnx from index_db where 1 $pure_sql  having callnx='$loadsub$i' ",false);
		$res[$i]=tmq_num_rows($n);
		if ($res[$i]>$max) {
			$max=$res[$i];
		}
		if ($loadsub2==$i && $loadsub2!="") {
			$defaultdsp2=$catedb2[$loadsub.$i.$add2];
		} 
	}
if ($defaultdsp2=="") {
	$defaultdsp2="&nbsp;";
}
//printr($res);
		?>
	<TR>
	<?php  
	@reset($callni);
while (list($k,$i)=each($callni)) {
	if ($loadsub2==$i && $loadsub2!="") {
		$html=" class='localfix' ";
	} else {
		$html=" class='localblur' 
		onmouseover=\"this.className='localfocus'; localdsp2('".$catedb2["$loadsub".$i.$add2]."');\"
		onmouseout=\"this.className='localblur'; localdsp2('$defaultdsp2');\"
		onclick=\"top.location='$baselink&limitcallnloadsub=$loadsub&limitcallnloadsub2=$i'; \" ";
	}
	?>
		<TD <?php echo $html;?> TITLE="<?php echo $catedb2["$loadsub".$i.$add2];?>"><?php 
	if ($mode=="LC/NLM") { echo "<TABLE cellpadding=0 cellspacing=0><TR><TD>"; }
	echo html_graph("H",$max,$res[$i],10,$graphH,"#001155");
	if ($mode=="LC/NLM") { echo "</TD></TR></TABLE>"; }
	echo "<B class=smaller>$loadsub".$i."$add2<BR>";
	if ($mode=="DC") { echo "<BR>"; }
	echo "</B>";
	
	echo "<FONT class=smaller2>$res[$i]</FONT>";	
	?></TD>
	<?php  
	}?>
	</TR>
	<TR>
		<TD colspan=<?php echo $colspan;?> height=15><span class=smaller id="DISPLAYERx2"><?php echo $defaultdsp2;?></span></TD>
	</TR>
	<?php  }?>
	</TABLE><?php  

?><?php  
pcache_e();
?>