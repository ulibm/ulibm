<?php  //พ

function local_compilevar($raw) {
	global $_ROOMWORD;
	global $_FACULTYWORD;
	global $fine;
	global $thaimonstrbrief;
	global $useradminid;
	global $fineid;
	global $bcode;
	global $dts;
	global $dte;
	global $spot;

	global $rqid;
	global $finedoneinfo;
	global $member;
	global $memberbarcode;
	$now=time();
	$res="";
   //die("[$raw]");
switch ($raw) {
    case "sspot_catename":
        $s=tmq("select * from servicespot_client where id='$spot' ",false);
        $s=tfa($s);
        $s2=tmq("select * from servicespot_room where id='$s[pid]' ",false);
        $s2=tfa($s2);
        //printr($s2); die;
        $res=trim($s2[name]);
        break;
    case "sspot_spotname":
        $s=tmq("select * from servicespot_client where id='$spot' ",false);
        $s=tfa($s);
        //printr($s);
        $res=trim($s[name]);
        break;
    case "sspot_memberlist":
        $s=tmq("select * from servicespot_client_i where spotid='$spot' order by id asc ",false);
        $res="";
        while ($r=tfa($s)) {
         $memtypes=tmq("select * from member where UserAdminID='$r[member]' ");
         $memtypesr=tfa($memtypes);
         $memtypesn=tmq("select * from member_type where type='$memtypesr[type]' ");
         $memtypesrn=tfa($memtypesn);
         $res.=strip_tags(get_member_name($r[member]))."
   Barcode: $r[member]
   ".getlang($memtypesrn[descr])."
";
        }
        //printr($s);
        //die($res);
        $res=trim($res);
        break;
    case "sspot_time":
        $s=tmq("select * from servicespot_client where id='$spot' ",false);
        $s=tfa($s);
        $s2=tmq("select * from servicespot_room where id='$s[pid]' ",false);
        $s2=tfa($s2);
        if (floor($s[addtime])!=0) {
         $s2[minutesallow]=$s2[minutesallow]+($s[addtime]);
        }
        //printr($s);
        $res=date("H:i",$s[cu_regis]). " - ".date("H:i",$s[cu_regis]+($s2[minutesallow]*60));
        break;
    case "member_name":
        $res=trim($member[UserAdminName] );
        break;
    case "misc_librarian":
        $res=trim(strip_tags(get_library_name($useradminid)));
        break;
    case "misc_librarian_brace":
        $res="(".trim(strip_tags(get_library_name($useradminid))).")";
        break;
    case "member_prefix":
        $res=$member[prefi] ;
        break;
    case "rapairslip_item_calln":
         $res=marc_getmidcalln($bcode);
        break;
    case "boundslip_calln":
         $s=tmq("select * from media_mid where bcode='$bcode' ");
         $s=tfa($s);
         $res=serial_get_volstr($s[id]);
        break;
    case "rapairslip_item_bcode":
         $res=$bcode;
        break;
    case "rapairslip_medianame":
		$s=tmq("select * from media_mid where bcode='$bcode' ");
		$s=tfa($s);
		//printr($s);
         $res=marc_gettitle($s[pid]);
        break;
    case "member_type":
		$s=tmq("select * from member_type where type='$member[type]' ");
		$s=tfa($s);
        $res=getlang($s[descr]);
        break;
    case "member_room":
		$s=tmq("select * from room where id='$member[room]' ");
		$s=tfa($s);
        //$res=getlang($s[name] );
        $res=strip_tags(get_room_name($member[room]));
        break;
    case "request_media":
		$s=tmq("select * from checkout where id='$rqid' ",false);
		$s=tfa($s);
        $res=marc_gettitle($s[pid]) ." (barcode $s[mediaId])";
        break;
    case "request_requester":
		$s=tmq("select * from checkout where id='$rqid' ",false);
		$s=tfa($s);
		$requester=tmq("select * from member where UserAdminID='$s[request]' ");
		$requester=tfa($requester);
        $res=trim($requester[prefi]." ".$requester[UserAdminName]);
        break;
    case "member_major":
		$s=tmq("select * from major where id='$member[major]' ");
		$s=tfa($s);
        $res=getlang($s[name] );
        break;
    case "member_bc":
        $res=$member[UserAdminID] ;
        break;
    case "sumfine_date":
		if ($dts==$dte) {
			$res=ymd_datestr($dts,"date");
		} else {
			$res=ymd_datestr($dts,"date")."-".ymd_datestr($dte,"date");
		}
		$res=strip_tags($res);
        break;
    case "sumfine_number":
		$dtsql=" and (
			dt>=$dts and dt<=".($dte+(60*60*24))."
		)";
		$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
		where 1 $dtsql ",false);
		$c=tfa($c);
        $res=number_format($c[c1],2);
        break;
    case "sumfine_numberword":
		$dtsql=" and (
			dt>=$dts and dt<=".($dte+(60*60*24))."
		)";
		$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
		where 1 $dtsql ",false);
		$c=tfa($c);
        $res=numbertoword($c[c1]);
        break;
    case "member_fullname":
        $res=trim($member[prefi]." ".$member[UserAdminName]);
        break;
    case "misc_datetime":
        $res=strip_tags(ymd_datestr($now));  ;
        break;
     case "fine_idid":
        $res=$fine[idid];  ;//printr($fine);
        break;
     case "fine_date":
        $res=strip_tags(ymd_datestr($fine[dt],"date"));  ;
        break;
     case "fine_library_name":
        $res=strip_tags(get_library_name($finedoneinfo[lib]));
        break;
     case "coslip_list":
		 $res=getlang("รายการยืมทรัพยากรสารสนเทศ::l::Checkout list")."
";
		$sql="select * from checkout where hold='$memberbarcode' and allow='yes' and returned='no' order by id asc";
		$result=tmq($sql,false);
		$Num=tmq_num_rows($result);
		$s=tmq("select * from member where UserAdminID='$memberbarcode' ");
		if (tmq_num_rows($s)!=1) {
			echo("member where UserAdminID='$memberbarcode' not found");
		}
		$s=tmq_fetch_array($s);
		$tmpmbtype="SELECT *  FROM member_type where type ='$s[type]' "; 
		$tmpmbtype=tmq($tmpmbtype,false);
		if (tmq_num_rows($tmpmbtype) == 0) {
			$res.=("ไม่พบ ประเภทสมาชิก $mbtype ::l:: member type not found $mbtype");
		//die;
		}
		$tmpmbtype=tmq_fetch_array($tmpmbtype);
		$limithold=$tmpmbtype[limithold];
		$count=1;
		$allfine=0;
		while ($row2=tmq_fetch_array($result)) {
			$idhandler = $row2[id];
			$mediaId=$row2[mediaId];
			$mediapid=$row2[pid];
			$RESOURCE_TYPE=$row2[RESOURCE_TYPE];
			$sdat=$row2[sdat];
			$smon=$row2[smon];
			$syea=$row2[syea];
			$edat=$row2[edat];
			$emon=$row2[emon];
			$eyea=$row2[eyea];
			//echo "[[[end=$eyea start=$syea]]]";   
			$xfine=$row2[fine];
			$res.=$count.". ".(trim(marc_gettitle($mediapid)))." (barcode $row2[mediaId])".$newline;
			if (floor($sdat)==floor(date("j")) &&floor($smon)==floor(date("m")) &&floor($syea)==floor(date("Y")+543)) {
			   $res.="*ยืมวันนี้".$newline;
			}
			$res.="
     (".getlang("วันยืม::l::ChkOut.")." $sdat " . $thaimonstrbrief[$smon] . " $syea /".getlang("วันส่ง::l::due.")." $edat " . $thaimonstrbrief[$emon] . " $eyea)"."" ;
			$tmpdecis=getduedecis($mediaId, date("j"), date("n"), date("Y"));
			$daydiff=ddx(date("j"),date("n"),date("Y"),$edat,$emon,$eyea-543);
			$daydiff=round($daydiff);
			if ($tmpdecis < 0) {
				$tmpdeci2=-($tmpdecis);
			} else {
				$tmpdeci2=$tmpdecis;
			 }
			$tmpfine=($tmpdecis * $xfine);
			$allfine+=$tmpfine;
			$res.="
     ".getlang("ค่าปรับ::l::Fine")." :". number_format($tmpfine)."
";
			$count++;
		}
		$sql3="SELECT *  FROM checkout where hold ='$member[UserAdminID]' and allow='yes' and returned='no' ";
		$result3=tmq($sql3);
		$row3=tmq_fetch_array($result3);
		$holded=tmq_num_rows($result3);
		if ($limithold > $holded) {
			$res.= getlang("ยืมได้อีก " . ($limithold - $holded) . " รายการ::l::Can checkout  " . ($limithold - $holded) . " item more");
		} else {
			$res.=getlang("ไม่สามารถยืมวัสดุสารสนเทศเพิ่มได้::l::Cannot checkout more items");
		}

	break;
      case "fine_summary":
		$finelist ="select * from fine where memberId='$member[UserAdminID]' and idid='$fineid'";
		$finelist = tmq($finelist,false);
		$allfine=0;
		while ($row = tmq_fetch_array($finelist)) {
			$allfine=$allfine+$row[fine];
		}
		$res=" ".getlang("รวม::l::Total")." " . number_format($allfine) . " ".getlang(" บาท  (".numbertoword($allfine).")
 ชำระโดยเงิน::l:: Bah
 , paid")." " . number_format($finedoneinfo[cach]) ." ".getlang("บาท 
 และ::l::Baht 
 and")." $finedoneinfo[credit] ".getlang("credit") ;
        break;
    case "fine_list":
		$finelist ="select * from fine where memberId='$member[UserAdminID]' and idid='$fineid'";
		$finelist = tmq($finelist,false);
		$res="";
		$i=0;
		$Num = tmq_num_rows($finelist); 
		if ($Num==0) {
			$res=getlang("ไม่มีค่าปรับสำหรับสมาชิก::l::No fine for")." $member[UserAdminID]-$member[UserAdminName]";
		} else {
			while ($finelistr=tfa($finelist)) {
				$i++;
				$res.="$i) ".(strip_tags(ymd_datestr($finelistr[dt],"shortd"))."-$finelistr[topic]     ")." \n         ".number_format($finelistr[fine]) ." ".getlang("บาท::l::baht")."\n";
			}
		}
		$finenote=tmq("select * from finedone where idid='$fineid' ",false);
		$finenote=tfa($finenote);
		if ($finenote[note]=="") {
			$finenote[note]="-";
		}
		$res.="\nNote: ".$finenote[note]."\n";
        break;
   case 2:
        echo "i equals 2";
        break;
}

	return "".$res;
	$res=str_replace("[ROOMWORD]",$_ROOMWORD,$res);
	$res=str_replace("[FACULTYWORD]",$_FACULTYWORD,$res);

	return ".$raw=".$res;
}
?>