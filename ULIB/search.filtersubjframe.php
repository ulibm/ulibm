<?php  
;
  include("inc/config.inc.php");
				include ("./search.inc.func.php");
	html_start();
	$pure_sql=sessionval_get("searchsql");
	$dspv=sessionval_get("searchdspv");
	$dspv2=local_gethiddenquery($dspv,"limitsubj");
	$suarray=sessionval_get("suarray");
	$suarray=explode(' ',$suarray);
	$suarray=arr_filter_remnull($suarray);
	$_PAGE_FILE=sessionval_get("_PAGE_FILE");
	?>
	<TABLE width=98% align=center class=table_border>
	<TR>
		<TD class=table_head width=25%><?php echo getlang("หัวเรื่องใกล้เคียง::l::Related Subject");?></TD>
	</TR>
	<TR valign=top>
		<TD class=table_td><?php  
$dspv=str_replace('&&','&',$dspv);
$dspv=str_replace('limitsubj=&','',$dspv);

$pos = strpos($dspv, "limitsubj=");

if ($pos === false) {
  		
  	$all="";
  	$matchcount=0;
  	foreach ($suarray as $vi) {
  		$v=trim($vi);
  		if ($v=="[[AND]]" || $v=="[[OR]]" || $v=="[[NOT]]") {
  			 continue;
  		}
  		$v=str_remspecialsign($v);
  		if ($v=="") {
  			continue;
  		}
  		$thisall="";
  		$tmpw=usoundex_get($v);
  		$thisword="<B>$vi</B><!--  [$tmpw] --> ";
  		$tmpl=strlen($tmpw);
  		$v="select distinctrow word1 from index_db_subj where usoundex like '%$tmpw%' 
  		or
  		(word1 like '%$vi%' )
  		";
  		if ($fullmode!='yes') {
  			 $v.="limit 20";
  		} else {
				 $v.="limit 30";
			}
  		$v=tmq($v , false);
    	$max=10;
    	if ($fullmode=="yes") {
    		 $max=20;
    	}
  		$c=0;
  		$allselected=0;
  		while ($r=tfa($v)) {
  			//$r[word1]=substr($r[word1],2);
  			$r[word1]=dspmarc($r[word1]);
  			if ($vi==$r[word1]) {
  				continue;
  			}
  			$r[word1]=trim($r[word1],'"');
  			$r[word1]=trim($r[word1],"'");
  			$r[word1]=addslashes($r[word1]);			

  
  			$cc=tmq("select count(id) as cc from index_db where 1 $pure_sql and subj like '%$r[word1]%' ",false);
  		  $cc=tfa($cc);
  			if ($cc[cc]==0) {
  				 continue;
  			}
				$allselected++;
    		if ($c>=$max) {
  				 continue;
    		}
  			$c++;
  			$thisall.=" <A HREF=\"$_PAGE_FILE?$dspv2&limitsubj=".urlencode($r[word1])."\" target=_top style='font-size: 14px;' target=_top>$r[word1]</A> ";
  		  $thisall.= "(".number_format($cc[cc]).") ,";
  		}
  		if ($c>0) {
  			$thisall=$thisword . trim($thisall,",") . "<BR>";
  			$matchcount++;

    		$all=$all.trim($thisall,","); 
			}

  
  	}
  	echo $all;
  	if ($matchcount==0) {
  		 echo "&nbsp; <font color=gray>".getlang("ไม่มีรายการที่ตรงเงื่อนไข::l::No option available")."</font>";
  	} else {
  	if ($allselected>$max) {
  		 echo "<br /> <a href='search.filtersubjframe.php?fullmode=yes'>".getlang("แสดงทั้งหมด $allselected::l::Show all $allselected")."</a>";
  	}
	}
} else {
	echo "&nbsp; <font color=gray>".getlang("กำหนดแล้ว::l::Defined")."</font>";
}		
		?></TD>
	</TR>
	</TABLE>