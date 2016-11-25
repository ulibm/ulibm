<?php  //พ
function index_indexft($wh,$indexchild=false,$forceskipchain=false) {
$marc856=getval("MARC","ulibeconnecttag");
global $newline;
global $dcrURL;
	$s=tmq("select * from media_ftitems where mid ='$wh' order by text,id desc");
	$midlist=Array();
	$mlist=Array();
	$fttype=tmq_dump("media_fttype","code","name");
	while ($mdtsr=tmq_fetch_array($s)) {
		$midlist[]="$mdtsr[fttype]";
		if ($mdtsr[fttype]!="cover") {
			if ($mdtsr[uploadtype]=="upload") {
				$mlist[]="  ^z$mdtsr[text] (".getlang($fttype[$mdtsr[fttype]]).")^u$dcrURL/_fulltext/$mdtsr[fttype]/$mdtsr[mid]/$mdtsr[filename]";
			} else {
				$mlist[]="  ^z$mdtsr[text] (".getlang($fttype[$mdtsr[fttype]]).")^u$mdtsr[filename]";
			}
		}
	}
	$midlist = array_unique($midlist);
	$mlist = implode($newline, $mlist);
	//printr($mlist);
	
	$midlist = implode(",", $midlist);
	$midlist=str_replace(',,',',',$midlist);
	$midlist=str_replace(',,',',',$midlist);
	$midlist=str_replace(',,',',',$midlist);
	$midlist=str_replace(',,',',',$midlist);
	$midlist=str_replace(',,',',',$midlist);
	$midlist=str_replace(',,',',',$midlist);
	$midlist=",$midlist,";
	
	tmq("update index_db set ulibnote='$midlist' where mid='$wh' ");
	tmq("update media set ulibnote='$midlist',$marc856='$mlist' where id='$wh' ",false);


	//////////////index for chainer - master

	if ($indexchild==true) {
		$s=tmq("select * from chainerlink where fromid ='$wh' ",false);
		$chndb=tmq_dump2("chainer","code","name,isgenecon,fromtxt,fromtag,usemid");
	} else {
		$s=tmq("select * from chainerlink where destid ='$wh' ",false);
		$chndb=tmq_dump2("chainer","code","name,isgenecon,desttxt,desttag,usemid");
	}
//	die;
	$mlist=Array();
	$destlist=Array();
	while ($mdtsr=tmq_fetch_array($s)) {
		$usetag=trim($chndb[$mdtsr[chain]][3]);
		if ($usetag!="") {
			tmq("update media set $usetag='' where id='$wh' ",false);
		}

		$destlist[$mdtsr[chain]][]=$mdtsr[destid];
		if ($chndb[$mdtsr[chain]][1]=="yes") {
			if ($indexchild==true) {
				$targetid=$mdtsr[destid];
				$addtitle=marc_gettitle($targetid);
			} else {
				$targetid=$mdtsr[fromid];
				$addtitle=marc_gettitle($mdtsr[fromid]);
			}
			if ($chndb[$mdtsr[chain]][4]=="yes") {
				$callnadd="[".trim(marc_getserialcalln($mdtsr[frommid]))."]";
				if ($callnadd=="[]") {
					$callnadd="";
				} else {
					$midbcinfo=tmq("select * from media_mid where id='$mdtsr[frommid]' ");
					$midbcinfo=tmq_fetch_array($midbcinfo);
					$midbcinfo=$midbcinfo[bcode];
				}
			} else {
				$midbcinfo="";
				$callnadd="";
			}
			$mlist[$mdtsr[chain]][]="  ^z".getlang($chndb[$mdtsr[chain]][2])." $addtitle $callnadd^u$dcrURL/dublin.php?ID=$targetid&item=$midbcinfo";
		}
	}
	@reset($mlist);
	@reset($destlist);
	///echo "<HR>";
	//printr($mlist);
	///echo "<HR>";
	//printr($destlist);
	//printr($chndb);
	if (count($mlist)==0 && count($destlist)==0) {
	  //no chain set tag to empty
	  $usetag=trim($chndb[journalindex][3]);
	  tmq("update media set $usetag='' where id='$wh' ",false);
	}
	while (list($mlistk,$mlistv)=@each($mlist)) {
		$usetag=trim($chndb[$mlistk][3]);
		if ($usetag=="") {
		 //die("continue");
			continue;
		}

		$gatherbefor=tmq("select * from media where ID ='$wh' ");
		$gatherbefor=tmq_fetch_array($gatherbefor);
		$gatherbefor=$gatherbefor[$usetag];
		//echo "<PRE>[$gatherbefor][$newline]</PRE>";
		$mliststr=implode($newline, $mlist[$mlistk]);
		$mliststr="$mliststr$newline$gatherbefor";
		$mliststr=explodenewline($mliststr);
		$mliststr=arr_filter_remnull($mliststr);
		//printr($mliststr);

		$mliststr= array_unique($mliststr);
		$mliststr = implode($newline, $mliststr);
      $mliststr=addslashes($mliststr);
	tmq("update media set $usetag='$mliststr' where id='$wh' ",false);

		if ($indexchild==true && $forceskipchain==false) {
			//$destlist[$mlistk] = array_unique($destlist[$mlistk]);
			@reset($destlist[$mlistk]);
			while (list($k,$v)=each($destlist[$mlistk])) {
				index_indexft($v,false);
			}
		}
	}
	//////////////index for chainer - child

}
?>