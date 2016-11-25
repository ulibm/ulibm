<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	 include("_REQPERM.php");
        mn_lib();

sessionval_set("lastrestourcetypeitem",$RESOURCE_TYPE);
sessionval_set("lastrestourceplaceitem",$itemplace);
sessionval_set("lastbiblevelsession",$biblevel);

pagesection(getlang("คีย์รายการใหม่แบบง่าย::l::Easy Key new"));
//printr($_POST);

function localgetlang($str,$tmplang) {
	$str=explode("::l::",$str);
		if ( $tmplang=="th") {
			$tmpl1= $str[0];
		} else {
			$tmpl1= $str[1];
		}

	return $tmpl1;
}
?>

<CENTER><?php 
$status="";
$itemplace=$itemplace;
$libsite=$FLIBSITE;
$itemtype=$RESOURCE_TYPE;
$bcsep_field=$newline;
$importid="ULibNon-MARC:".get_library_name($useradminid);

$Stime=time();
$i=0;
$e=0;
$itemadded=1;
//$resultmap_fid=tmq_dump("easyadd_map","classid","fid");;
//$resultmap_tp=tmq_dump("easyadd_map","classid","tp");;
$fixedwidthfield=getval("MARC","fixedwidthfield");

$resultdata=Array();
$biblevel=trim(substr($biblevel,0,1));
if ($biblevel=="") {
	$biblevel="m";
}
if ($biblevel=="s") {
	$isbntag="tag022";
} else {
	$isbntag="tag020";
}
$pubyear=trim(substr($dat[pub],0,4));
if ($pubyear=="") {
	$pubyear="||||";
}
$matlang=trim(substr($matlang,0,3));
if ($matlang=="") {
	$matlang="|||";
}
if ($matlang=="eng") {
	$langprocess="en";
} else {
	$langprocess="th";
}
$data=explodenewline($dat[isbn]);
$data=arr_filter_remnull($data);
@reset($data);
$datr="";
while (list($k,$v)=each($data)) {
	$datr="$datr".$newline."  $v";
}
$isbn=trim($datr,$newline);

$data=explodenewline($dat[auth]);
$data=arr_filter_remnull($data);
if (count($data)<=1) {
	$auth1="  $data[0]";
	$auth2="";
} else {
	@reset($data);
	list($k,$v)=each($data);
	$auth1="  $v";
	$auth2="";
	while (list($k,$v)=each($data)) {
		$auth2="$auth2".$newline."  $v";
	}
	$auth2=trim($auth2,$newline);

}

$data=explodenewline($dat[orgauth]);
$data=arr_filter_remnull($data);
if (count($data)<=1) {
	$orgauth1="  $data[0]";
	$orgauth2="";
} else {
	@reset($data);
	list($k,$v)=each($data);
	$orgauth1="  $v";
	$orgauth2="";
	while (list($k,$v)=each($data)) {
		$orgauth2="$orgauth2".$newline."  $v";
	}
	$orgauth2=trim($orgauth2,$newline);

}
$dat[publocate]=trim($dat[publocate]);
if ($dat[publocate]=="") {
	$dat[publocate]=localgetlang("ม.ป.ท.::l::n.p.",$langprocess);;
} 
$pos = strpos($dat[publisher], "^b");
if ($pos === false) {
	$dat[publisher]="^b$dat[publisher]";
}
if ($dat[publisher]!="") {
	//$dat[publocate]=":".$dat[publocate];
	$dat[publisher]=":".$dat[publisher];
} 
echo "$dat[pub]/$langprocess";
$dat[pub]=trim($dat[pub]);
if ($dat[pub]=="") {
	$dat[pub]=localgetlang("ม.ป.ป.::l::n.d.",$langprocess);;
}
$pos = strpos($dat[pub], "^c");
if ($pos === false) {
	$dat[pub]="^c$dat[pub]";
}
$dat[edition]=trim($dat[edition]);
if ($dat[edition]!="") {
	if ($langprocess=="en") {
		if (substr($dat[edition],-1)=="1") {
			$dat[edition]=$dat[edition]."st";
		} elseif (substr($dat[edition],-1)=="2") {
			$dat[edition]=$dat[edition]."nd";
		} elseif (substr($dat[edition],-1)=="3") {
			$dat[edition]=$dat[edition]."rd";
		} else {
			$dat[edition]=$dat[edition]."th";
		}
	}
	$dat[edition]=localgetlang("พิมพ์ครั้งที่ $dat[edition]::l::$dat[edition] ed",$langprocess);;
}
$dat[page]=trim($dat[page]);
if ($dat[page]!="") {
	$dat[page]=localgetlang("$dat[page] หน้า::l::$dat[page] pages",$langprocess);
}
$dat[height]=trim($dat[height]);
if ($dat[height]!="") {
	$dat[height]="$dat[height] ".localgetlang("ซม.::l::cm",$langprocess);
	$pos = strpos($dat[height], "^b");
	if ($pos === false) {
		$dat[height]="^b$dat[height]";
	}
	if ($dat[page]!="") {
		$dat[height]=";$dat[height]";
	}
}
$data=explodenewline($dat[subj]);
$data=arr_filter_remnull($data);
@reset($data);
$datr="";
while (list($k,$v)=each($data)) {
	$datr="$datr".$newline."  $v";
}
$subj=trim($datr,$newline);
$data=explodenewline($dat[note]);
$data=arr_filter_remnull($data);
@reset($data);
$datr="";
while (list($k,$v)=each($data)) {
	$datr="$datr".$newline."  $v";
}
$note=trim($datr,$newline);

//merging
$sql="insert into media set
leader='".("00000na$biblevel  2200000uu 4500")."',
$fixedwidthfield='".("020711s$pubyear    th a          000 0 $matlang d")."',
$isbntag='".($isbn)."',
tag245='  ".($dat[title])."',
tag100='".($auth1)."',
tag700='".($auth2)."',
tag110='".($orgauth1)."',
tag710='".($orgauth2)."',
tag082='  ".($dat[callcdc])."',
tag050='  ".($dat[callnnlm])."',
tag060='  ".($dat[callnlc])."',
tag099='  ".($dat[callnlocal])."',
tag260='  ".($dat[publocate])." ".($dat[publisher]).",".($dat[pub])."',
tag300='  ".($dat[page])."".($dat[height])."',
tag250='  ".($dat[edition])."',
tag650='  ".($subj)."',
tag500='  ".($note)."'
";
//echo "<pre>".$sql."</pre>";
//die ("[$langprocess]");

//echo "<pre>".$sql."</pre>";
tmq($sql,false);
$pid=tmq_insert_id();

		$now=time();
		$s=tmq("show columns from media where Field ='lastdt' ");
		if (tmq_num_rows($s)==0) {
			tmq("update media set lastdt='$now' where ID='$pid' limit 1 ;");
		}

//die;
//printr($_POST);
//print_r($resultmap_fid);
//echo "<BR><BR><BR>";

	
	//echo "[$r[$name2]$name]";

			if ($ITEMBARCODE!="") {
			//echo "asdfd";
			$barcodeid=explodenewline($ITEMBARCODE);
			$barcodeid=arr_filter_remnull($barcodeid);
			//printr($barcodeid);
				reset($barcodeid);
				foreach ($barcodeid as $barcodeidk=>$barcodeidv) {
					$barcodeidv=str_remspecialsign($barcodeidv);
					$barcodeidv=trim($barcodeidv);

					if ($barcodeidv!="") {
						$cccb=tmq("select * from media_mid where bcode='$barcodeidv'");
						if (tmq_num_rows($cccb)==0) {
							//echo $barcodeidv;
							$bitemsql="insert into media_mid set
							RESOURCE_TYPE='$itemtype' ,
							pid='$pid' ,
							bcode='$barcodeidv' ,
							price='$dat[price]' ,
							status='$status' ,
							libsite='$libsite' ,
							
							place='$itemplace' ";
							if ($itemadded!=1) {
								$bitemsql.=",inumber='".localgetlang("ฉ.::l::c.",$langprocess)."$itemadded' ";
							}
							tmq($bitemsql,false);
							$itemadded++;
						}
					}
				}
			}
	index_reindex($pid);

$Etime=time();

?></CENTER>
<BR><CENTER><?php  echo getlang("บันทึกข้อมูลสำเร็จ::l::Success"); ?> </CENTER>

<?php  
//redir("easyadd.php?lastitem=$pid");
redir("DBbook.php?IDEDIT=$pid");
foot();
?>