<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	 include("_REQPERM.php");
        mn_lib();

sessionval_set("lastrestourcetypeitem",$RESOURCE_TYPE);
sessionval_set("lastrestourceplaceitem",$itemplace);
sessionval_set("lastbiblevelsession",$biblevel);
sessionval_set("defstatussess",$status);

pagesection(getlang("คีย์รายการใหม่แบบง่าย::l::Easy Key new"));
//printr($_POST);
//die;
//pre check barcode
	//printr($bcode);
	//printr($tabean);
	//printr($inumber);
	//die;

$err="no";
if ($biblevel=="s") {
   unset($bcode);
}
@reset($bcode);
while (list($k,$v)=@each($bcode)) {
    if ($bcode[$k]!="") {
		$s="select * from media_mid where bcode='".$bcode[$k]."' ";
		$r=tmq($s);
		$n=tmq_num_rows($r);
		if ($n!=0) {
			echo "".getlang("หมายเลขบาร์โค้ด ".$bcode[$k]." ถูกใช้ไปแล้ว::l::Barcode ".$bcode[$k]." duplicated")."<BR>";
				$err="yes";
		}
	}
}
if ($err!="no") {
	 echo "<a href='javascript:history.go(-1)'>".getlang("กลับ::l::Back")."</a>";
	 die();
}

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
//$status="";
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

if ($biblevel=="s") {
	$tag020="";
	$tag022=$isbn;
} else {
	$tag020=$isbn;
	$tag022="";
}

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
if (trim($auth1)!="" && trim($orgauth1)!="") {
   if ($setauthmain=="auth") {
      $orgauth2="$orgauth1".$newline.$orgauth2;
      $orgauth1="";
   }
   if ($setauthmain=="org") {
      $auth2="$auth1".$newline.$auth2;
      $auth1="";
   }
}

$dat[publocate]=trim($dat[publocate]);
if ($dat[publocate]=="") {
	$dat[publocate]=localgetlang("ม.ป.ท.::l::n.p.",$langprocess);;
} 
$pos = strpos($dat[publocate], "^b");
if ($pos === false) {
	$dat[publocate]="^b$dat[publocate]";
}
if ($dat[publisher]!="") {
	$dat[publocate]=":".$dat[publocate];
} 
//echo "$dat[pub]/$langprocess";
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
$bibphysicaldescr=arr_filter_remnull($dat[bibphysicaldescr]);
$bibphysicaldescr="^b".implode($bibphysicaldescr,", ");
if ($bibphysicaldescr=="^b") {
   $bibphysicaldescr="";
}
//echo "[$bibphysicaldescr]";
if ($dat[page]!="") {
	$dat[page]=localgetlang("$dat[page] หน้า::l::$dat[page] pages",$langprocess);
	if ($bibphysicaldescr!="" && trim($dat[height])!="") {
	  $dat[page]=$dat[page]." :";
	}
}
$dat[height]=trim($dat[height]);
if ($dat[height]!="") {
	$dat[height]="$dat[height] ".localgetlang("ซม.::l::cm",$langprocess);
	$pos = strpos($dat[height], "^c");
	if ($pos === false) {
		$dat[height]="^c$dat[height]";
	}
	if ($dat[page]!="") {
		$dat[height]=" ;$dat[height]";
	}
}
$data=($dat[subj]);
//printr($data);
//$data=arr_filter_remnull($data);
@reset($data);
$datr="";
for ($i=0;$i<=20;$i++) {
	$datr="$datr"."  ".$dat[subj][$i];
	if (trim($dat[subj2][$i])!="") {
		$datr="$datr"."^x".$dat[subj2][$i];
	}
	if (trim($dat[subj3][$i])!="") {
		$datr="$datr"."^y".$dat[subj3][$i];
	}
	if (trim($dat[subj4][$i])!="") {
		$datr="$datr"."^z".$dat[subj4][$i];
	}
	if (trim($dat[subj][$i].$dat[subj2][$i].$dat[subj3][$i].$dat[subj4][$i])!="") {
		$datr="$datr".$newline;
	}
	//echo "$i<pre>[$datr]<hr></pre>";
}
$datr=rtrim($datr);
//die;
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
ispublish='".($ispublish)."',
tag020='".($tag020)."',
tag022='".($tag022)."',
tag245='  ".($dat[title])."',
tag100='".($auth1)."',
tag700='".($auth2)."',
tag110='".($orgauth1)."',
tag710='".($orgauth2)."',
tag082='  ".($dat[callcdc])."',
tag050='  ".($dat[callnlc])."',
tag060='  ".($dat[callnnlm])."',
tag099='  ".($dat[callnlocal])."',
tag260='  ".($dat[publisher])." ".($dat[publocate]).",".($dat[pub])."',
tag300='  ".($dat[page])."".$bibphysicaldescr."".($dat[height])."',
tag250='  ".($dat[edition])."',
tag650='".($subj)."',
tag500='  ".($note)."'
";
//echo "<pre>".$sql."</pre>"; die ("[$langprocess]");

//echo "<pre>".$sql."</pre>";
tmq($sql,false);
$pid=tmq_insert_id();
//die;
		$now=time();
		media_updatelastdt($pid);

//printr($_POST);
//print_r($resultmap_fid);
//echo "<BR><BR><BR>";
		$dt=time();
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$dt',
		bibid='$pid',
		edittype='add new bib.'		");
	
	//echo "[$r[$name2]$name]";
$dt=time();
$dt_str=floor(date('d')).'-'.floor(date('m')).'-'.floor(date('Y'));


$price=$dat[price];
	@reset($bcode);
while (list($k,$v)=@each($bcode)) {
      if (trim($v)=="") continue;
     $sql ="insert into media_mid (pid,tabean,bcode,RESOURCE_TYPE,inumber,price,libsite,place,note,calln, dt,dt_str,adminnote,status_lastupdate,lastcheckin,status)";
     $sql.=" values ('$pid','".$tabean[$k]."','".$bcode[$k]."','$RESOURCE_TYPE','".$inumber[$k]."','$price','$FLIBSITE','$itemplace','$note','','$dt','$dt_str','$adminnote','$now','$timetoshelf','$status')";
  //echo $sql;
	//die;
    tmq($sql);
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$dt',
		bibid='$pid',
		edittype='add item bc=".$bcode[$k]."'		");
		media_updatelastdt($pid,"item");
}
/*PREDECATED
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
							status='$status' ,
							libsite='$libsite' ,
							
							place='$itemplace' ";
							if ($itemadded!=1) {
								$bitemsql.=",inumber='".getlang("ฉ.::l::c.",$langprocess).". $itemadded' ";
							}
							tmq($bitemsql,false);
							$itemadded++;
						}
					}
				}
			}*/
	index_reindex($pid);

$Etime=time();
//die;

?></CENTER>
<BR><CENTER><?php  echo getlang("บันทึกข้อมูลสำเร็จ::l::Success"); ?> </CENTER>

<?php 
//redir("easyadd.php?lastitem=$pid");
redir("DBbook.php?IDEDIT=$pid&startrow=0&linkfrom=$pid");
foot();
?>