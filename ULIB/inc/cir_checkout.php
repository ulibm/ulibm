<?php 
function cir_checkout($memberbarcode,$mediabarcode,$Fdat,$Fmon,$Fyea,$overrideall="no",$forcedt_dat=0,$forcedt_mon=0,$forcedt_yea=0) {
	//echo "cir_checkout($memberbarcode,$mediabarcode,$Fdat,$Fmon,$Fyea) ";
	global $_coengine;
	global $LIBSITE;
	if ($_coengine=="") {
		$_coengine="cir";
	}
	global $confirm_forautorenew;
	global $cir_checkout_memrenew;
	global $dcrURL;
	global $_REQUEST;
	global $LIBSITE;
	global $useradminid;
	if (!function_exists("cir_checkout_resp")) {
		function cir_checkout_resp($wh) {
			//printr($wh);	die;
			return $wh;
		}
	}
	$res=Array();
	$res[success]=Array();
	$res[error]=Array();
	$res[msg]=Array();
	$res[status]="";
	$res[memid]=$memberbarcode;

	//check mediaexists
	$tmp="SELECT *  FROM media_mid where bcode = '$mediabarcode' ";
	$tmp=tmq($tmp);
	if (tmq_num_rows($tmp) == 0) {
		$res[error][]=("mediaid_notexist");
	}
	$tmp=tmq_fetch_array($tmp);
	$media_primary=$tmp[id];
	$RESOURCE_TYPE=$tmp[RESOURCE_TYPE];
	//อาจมีการเปลี่ยนสถานะเป็ฯหนังสือสำรองโดยเช็คจากสถานะวัสดุ
	$media_pid=$tmp[pid];
	$res[media_pid]=$media_pid;


	 $s=tmq("select * from member where UserAdminID='$memberbarcode' ");
	 if (tmq_num_rows($s)!=1) {
		$res[error][]=("ไม่พบ สมาชิก $memberbarcode ::l:: member not found $memberbarcode");
		$res[status]="error";
		return cir_checkout_resp($res);
		//error will display in display iframe
	 }

	$s=tmq_fetch_array($s);
	$member_room=floor($s[room]);
	$member_major=floor($s[major]);

	$mbtype=$s[type];
	$mbdat=$s[dat];
	$mbmon=$s[mon];
	$mbyea=$s[yea];


	//ยืมได้กี่รายการ+max fine
	$tmpmbtype="SELECT *  FROM member_type where type ='$mbtype'"; 
	$tmpmbtype=tmq($tmpmbtype);
	if (tmq_num_rows($tmpmbtype) == 0) {
		$res[error][]=("ไม่พบ ประเภทสมาชิก $mbtype ::l:: member type not found $mbtype");
		$res[status]="error";
		return cir_checkout_resp($res);
		die;
	}
	$tmpmbtype=tmq_fetch_array($tmpmbtype);
	$limithold=$tmpmbtype[limithold];
	$maxfine=$tmpmbtype[maxfine];


	if (!checkdate ($Fmon,$Fdat,$Fyea)) {
		$res[error][]=getlang("วันที่ไม่ถูกต้อง::l::Date is incorrect");
	}
	$lastdatecheckoutin=barcodeval_get("lastdatecheckoutin");
	$thischeckoutdt=ymd_mkdt($Fdat,$Fmon,($Fyea-543));	 	
	if ($lastdatecheckoutin<=$thischeckoutdt) {
		$res[error][]=("ไม่สามารถให้ยืมได้ เกินวัสดุท้ายที่ห้องสมุดเปิดรับคืน:<br /> ".ymd_datestr($lastdatecheckoutin,'date')."::l::Cannot checkout, over the last day library allow to checkout:<br /> ".ymd_datestr($lastdatecheckoutin,'date')." ");
	}

	$sqlchk="select * from fine where memberId='$memberbarcode' and isdone='no'";
	$resultchk=tmq($sqlchk);
	if (tmq_num_rows($resultchk) != 0) { 
		$countfinec=0;
		while ($countfiner=tmq_fetch_array($resultchk)) {
			$countfinec=$countfinec+$countfiner[fine];
		}
		if ($countfinec<=floor($maxfine)) { 
			//ok
		} else {
			$res[error][]=("ยืมไม่ได้ สมาชิกคนนี้มีค้างค่าปรับมากกว่าที่กำหนด ($countfinec/$maxfine)::l::Cannot checkout this member have too many unpaid fine ($countfinec/$maxfine)");
		}
	}



	if ($tmp[status]!="") {
		$tmp2=tmq("select * from media_mid_status where code='$tmp[status]' ");
		if (tmq_num_rows($tmp2)!=1) {
			$res[msg][]=("วัสดุนี้ติดสถานะ $tmp[status]::l::Media with status $tmp[status]");
		}
		$tmp2=tmq_fetch_array($tmp2);
		if ($tmp2[iscancheckout]!='yes') {
			$res[error][]=("ไม่สามารถให้ยืมได้ เนื่องจากมีการระบุสถานะ $tmp[status] ".getlang($tmp2[name])."::l::Cannot checkout this item has special status $row3[status] ".getlang($tmp2[name])." ");
		}
		if ($tmp2[code]=='reservmat') {
			$RESOURCE_TYPE=$tmp2[code];
			$res[msg][]=("สถานะเป็น ".getlang($tmp2[name])."::l::Material is ".getlang($tmp2[name])." ");
		}

	}

	//libsite related
	if ($cir_checkout_memrenew!="yes") {
		if ("$tmp[libsite]"!="$LIBSITE") {
			$decis=getlibsiterule("$LIBSITE","$tmp[libsite]","addhold-thislibsiteitem");
			if ("$decis"=="no") {
				$res[error][]=("กรุณาตรวจสอบวัสดุ ไม่สามารถให้ยืมได้เนื่องจากเป็นวัสดุของ <U>".get_libsite_name($tmp[libsite])."</U>::l::Cannot checkout, this items is own by <U>".get_libsite_name($tmp[libsite])."</U>");
			}
		}
	}

	//overdue check
	$decis=member_isoverduing($memberbarcode);
	if ($decis!="PASS") {
		$res[error][]=("ไม่สามารถให้ยืมได้ มีวัสดุสารสนเทศที่เกินกำหนดส่ง::l::Cannot checkout, Member got some overdue item");
	}

	if ($cir_checkout_memrenew=="yes") {
		$confirm_forautorenew="yes";
	}
	//ตรวจสอบว่าหนังสือถูกยืมอยู่รึเปล่า
	$tmp2="select * from checkout where mediaId='$mediabarcode' ";
	$tmp2=tmq($tmp2);
	$tmp2_num=tmq_num_rows($tmp2);
	$tmp2=tmq_fetch_array($tmp2);
	if ($tmp2_num != 0 && $tmp2[hold]!=$memberbarcode) {
		if ($tmp2[request]==$memberbarcode) {
			$res[msg][]=("รับหนังสือจอง::l::Pick up request");
		} else {
			$res[error][]=("วัสดุสารสนเทศชิ้นนี้ถูกยืมออกไปแล้ว::l::This item was checked out");
		}
	} elseif ($tmp2_num != 0 && $tmp2[hold]==$memberbarcode) {
		if ($tmp2[request]!="") {
			$res[error][]=("คุณยืมวัสดุสารสนเทศชิ้นนี้แล้ว, แต่ไม่สามารถยืมต่อได้ เพราะมีการจองไว้::l::This member borrowed this item. but cannot renew because this item in on request.");
		} else {
			if (floor($tmp2[sdat])==floor($Fdat) && floor($tmp2[smon])==floor($Fmon)&& floor($tmp2[syea])==floor($Fyea) ) {
				$res[error][]=("คุณยืมวัสดุสารสนเทศชิ้นนี้แล้ว, แต่ไม่สามารถยืมต่อได้ เพราะเพิ่งยืมไปวันนี้::l::This member borrowed this item. but cannot renew because this member just borrow it today.");
			} else {
				$sql3="SELECT *  FROM checkout_rule where media_type ='$RESOURCE_TYPE' and member_type='$mbtype'  and libsite='$LIBSITE' ";
				$result3=tmq($sql3,false);
				$row3=tmq_fetch_array($result3);

				if (floor($tmp2[renewcount])>floor($row3[renew])) {
					$res[error][]=("คุณยืมวัสดุสารสนเทศชิ้นนี้แล้ว, แต่ไม่สามารถยืมต่อได้ เพราะเคยยืมต่อรายการนี้ไปแล้วเกินจำนวนครั้งที่กำหนด::l::This member borrowed this item. but cannot renew because this member renew it to max allowed time before.");
				} elseif ($confirm_forautorenew=="") {
				  if ($_coengine=="cir") {
					 $res[msg][]=("คุณยืมวัสดุสารสนเทศชิ้นนี้แล้ว, บรรณารักษ์ต้องการให้ยืมต่อเลยหรือไม่?::l::This member borrowed this item. Renew now?.");
					 //printr($_POST);
					 $res[msg][]="<a href=\"working.viewmember.php?cirmode=checkout&memberbarcode=$memberbarcode&mediabarcode=".$_REQUEST[mediabarcode]."&Fdat=$Fdat&Fmon=$Fmon&Fyea=$Fyea&confirm_forautorenew=yes\"class=a_btn>". getlang("ใช่::l::Yes")."</a> ". getlang("หรือทำการสแกนบาร์โค้ดทรัพยากรอื่น ๆ เพื่อทำรายการต่อไป")."";
					} else {
					 $res[msg][]=("คุณยืมวัสดุสารสนเทศชิ้นนี้แล้ว::l::You borrowed this item.");
					}
					$res[status]="error";
					return cir_checkout_resp($res);
				} else {
					$res[msg][]=("การยืมต่อ::l::Renewing");
				}
			}
		}
	}

	//ตรวจสอบว่าหนังสือ bib เดียวกันถูกยืมอยู่หรือเปล่า
	$mediatypes="SELECT *  FROM media_type where code ='$RESOURCE_TYPE' ";
	$mediatypes=tmq($mediatypes);
	$mediatypes=tmq_fetch_array($mediatypes);
	
	if ($mediatypes[canduphold]!="yes") {
		$tmp2="select * from checkout where pid='$media_pid' and hold='$memberbarcode' and RESOURCE_TYPE='$RESOURCE_TYPE' and returned='no' && mediaId<>'$mediabarcode' ";
		$tmp2=tmq($tmp2);
		if (tmq_num_rows($tmp2) != 0) {
			$res[error][]=("เคยยืมวัสดุสารสนเทศชื่อเรื่องเดียวกัน ประเภทวัสดุเดียวกันไปแล้ว::l:: were checked out same material title and material type before.");
		}
	}

	///////วันหมดอายุสมาชิก
	if ($s[dat] != 0) {
		$todate=GregorianToJD2($Fmon, $Fdat, $Fyea);
		$mbdate=GregorianToJD2($s[mon], $s[dat], $s[yea]);
		if ($mbdate >= $todate) {
			//echo "สมาชิกยังไม่หมดอายุ";
		} else {
			$res[error][]=("สมาชิกคนนี้หมดอายุสมาชิกแล้ว เมื่อ $mbdat/$mbmon/$mbyea ::l::This member were expired $mbdat/$mbmon/$mbyea");
		}
	} else {
		//echo "ไม่มีการกำหนดวันหมดอายุสมาชิก";
	}

	//find media bib
	$tmp2="SELECT *  FROM media where ID ='$media_pid'"; 
	$tmp2=tmq($tmp2);
	if (tmq_num_rows($tmp2) == 0) {
		$res[error][]=("ไม่พบ Bib ของวัสดุ ::l::Bib of media not found");
	}		
	$tmp2=tmq_fetch_array($tmp2);
	$mediatitle=addslashes(marc_gettitle($media_pid));
	
	if ($RESOURCE_TYPE=="serial") {
		$mediatitle.= " [" . serial_get_volstr($media_pid) . "]";
	}
	$mediareldc=$tmp2[getval("stat","dc_tagname")];
	$mediarellc=$tmp2[getval("stat","lc_tagname")];
	$mediarelnlm=$tmp2[getval("stat","nlm_tagname")];
	$mediarellocal=$tmp2[getval("MARC","def_local_callnum")];

	//ดูว่ายืมไปกี่รายการแล้ว
	$sql3="SELECT *  FROM checkout where hold ='$memberbarcode' and mediaId<>'$mediabarcode' and allow='yes' and returned='no' ";
	$result3=tmq($sql3);
	$row3=tmq_fetch_array($result3);
	$holded=tmq_num_rows($result3);

	if ($cir_checkout_memrenew=="yes") {
		if ($limithold >= $holded) { //echo "ยืมได้อีก " . ($limithold - $holded) . " รายการ";
		} else {
			$res[error][]=("ไม่สามารถยืมได้อีกแล้ว เกิน $limithold รายการสำหรับ $mbtype::l::Cannot checkout more than $limithold items for $mbtype");
		}
	} else {
		if ($limithold > $holded) { //echo "ยืมได้อีก " . ($limithold - $holded) . " รายการ";
		} else {
			$res[error][]=("ไม่สามารถยืมได้อีกแล้ว เกิน $limithold รายการสำหรับ $mbtype::l::Cannot checkout more than $limithold items for $mbtype");
		}
	}


	$sql3="SELECT *  FROM checkout where hold ='$memberbarcode' and allow='yes' and libsite='$LIBSITE' and returned='no'  ";
	$result3=tmq($sql3);
	$row3=tmq_fetch_array($result3);
	$holded=tmq_num_rows($result3);
	$libsitemaxhold=getlibsitevars("$LIBSITE","maxholditeminthislib");
	 if ($libsitemaxhold!=-1) {
		 if ($libsitemaxhold > $holded) {
			//echo "ยืมได้อีก " . ($libsitemaxhold - $holded) . " รายการ";
		} else {
			$res[error][]=("ไม่สามารถยืมได้อีกแล้ว ".get_libsite_name($LIBSITE)." ให้ยืมวัสดุได้มากทีสุด $libsitemaxhold รายการต่อสมาชิก 1 ท่าน::l::Cannot checkout . ".get_libsite_name($LIBSITE)." allow maximum checkout $libsitemaxhold items to 1 member");
		}
	 }


	//ยืมได้ถึงวันที่เท่าไหร
	$sql3="SELECT *  FROM checkout_rule where media_type ='$RESOURCE_TYPE' and member_type='$mbtype'  and libsite='$LIBSITE' ";
	$result3=tmq($sql3,false);
	$row3=tmq_fetch_array($result3);
	$dayallow=$row3[day];
	$xfine=$row3[fine];
	$Numchk=tmq_num_rows($result3);
	$useFdat=$Fdat;
	$useFmon=$Fmon;
	$useFyea=$Fyea;
	if ($Numchk == 0) {
		$res[error][]=("ไม่พบกฏการยืม [$RESOURCE_TYPE/$mbtype]::l::Checkout rule not found [$RESOURCE_TYPE/$mbtype]");
	} else {
	  //ยืมจากวันสุดท้ายที่เป็นกำหนดคืน
	  if ($confirm_forautorenew=="yes" && getval("_SETTING","circulation_renewdateusedt")=="Due_date") {
	     //
	     $oldcheckout=tmq("select * from checkout where mediaId='$mediabarcode' ",false);
	     if (tnr($oldcheckout)==1) {
	        $oldcheckoutr=tfa($oldcheckout);
   	     //printr($oldcheckoutr);
            $useFdat=$oldcheckoutr[sdat];;
            $useFmon=$oldcheckoutr[smon];;
            $useFyea=$oldcheckoutr[syea];;
            $Fdat=$oldcheckoutr[edat];
            $Fmon=$oldcheckoutr[emon];
            $Fyea=$oldcheckoutr[eyea];
   	     //echo "[$Fdat/$Fmon/$Fyea]"; die;
	     }
	  }
	}
	//
	if ($row3[cancheckout] != "yes") {
		$res[error][]=("ไม่สามารถอนุญาติให้ยืมวัสดุประเภท $RESOURCE_TYPE ได้ สำหรับ $mbtype::l::Cannot checkout  $RESOURCE_TYPE for $mbtype");
	}

	$targetreturn1=ddl(intval($Fdat), intval($Fmon), intval($Fyea), $dayallow);
	$tmp2=explode(" ", $targetreturn1);
	$targetreturn1 = walkbackweekclose($tmp2[0],$tmp2[1],$tmp2[2]);
	$tmp2=explode(" ", $targetreturn1);
			

	 $thischeckoutdt=ymd_mkdt($tmp2[0],$tmp2[1],($tmp2[2]-543));	 	
	 if ($lastdatecheckoutin<=$thischeckoutdt) {
	    $tmp2=ymd_mkymd($lastdatecheckoutin);
		$tmp2[2]=$tmp2[2]+543;
    	$res[msg][]=("มีการปรับวันส่งอัตโนมัติ <br />เกินวัสดุท้ายที่ห้องสมุดเปิดรับคืน:<br /> ".ymd_datestr($lastdatecheckoutin,'date')."::l::Checkin date changes<br />, over the last day library allow to checkout:<br /> ".ymd_datestr($lastdatecheckoutin,'date')." ");
	 }
	 

	//check for returndate again
	$targetreturn1 = walkbackweekclose($tmp2[0],$tmp2[1],$tmp2[2]);
	$tmp2=explode(" ", $targetreturn1);
	//end check again
			


	//check if error
	if (count($res[error])>0 && $overrideall!="yes") {
		$res[status]="error";
		return cir_checkout_resp($res);
	} else {
		$res[status]="success";
	}
	if ($overrideall=="yes") {
		//printr($tmp2);//die;
		$res[status]="success";
		if (ymd_mkdt($tmp2[0],$tmp2[1],($tmp2[2]-543))<time()) {
			$tmp2[0]=$forcedt_dat;
			$tmp2[1]=$forcedt_mon;
			$tmp2[2]=$forcedt_yea;
		}
	}

	statordr_add("checkout_book","$media_pid");
	statordr_add("checkout_member",$memberbarcode);	
	stat_add("checkout_byhrs",date("G"));
	if ($_coengine=="webrenew") {
   	stat_add("checkout_librarian","webrenew"); //unused
   	stathist_add("checkout_media_librarian",$memberbarcode,"webrenew");	
	} elseif ($_coengine=="brlane") { 
   	stat_add("checkout_librarian","brland"); //unused
   	stathist_add("checkout_media_librarian",$memberbarcode,"brlane");	
	}  else {
   	stat_add("checkout_librarian",$useradminid); //unused
   	stathist_add("checkout_media_librarian",$memberbarcode,$useradminid);	
	}
	stat_add("checkout_libsite",$LIBSITE);	
	stat_add("checkout_restype",$RESOURCE_TYPE);	
	stat_add("checkout_mbtype",$mbtype);	
	if ($member_room!=0) {
		stat_add("checkout_mbroom",$member_room);	
	}
	if ($member_major!=0) {
		stat_add("checkout_mbmajor",$member_major);	
	}

	stathist_add("checkout_member_libsite",$memberbarcode,$LIBSITE);	
	stathist_add("checkout_member_media",$memberbarcode,$mediabarcode);	

	$mediareldc2 =getdcnum($mediareldc,2);
	if ($mediareldc2!="") {
		 stat_add("checkout_callndc2",$mediareldc2);		
	}
	$mediareldc =getdcnum($mediareldc);
	if ($mediareldc!="") {
		 stat_add("checkout_callndc",$mediareldc);		
	}
	$mediarellc2 =getlcnum($mediarellc,2);
	if ($mediarellc2!="") {
		 stat_add("checkout_callnlc2",$mediarellc2);		
	}
	$mediarellc =getlcnum($mediarellc);
	if ($mediarellc!="") {
		 stat_add("checkout_callnlc",$mediarellc);		
	}
	$mediarelnlm2 =getnlmnum($mediarelnlm,2);
	if ($mediarelnlm2!="") {
		 stat_add("checkout_callnnlm2",$mediarelnlm2);		
	}
	$mediarelnlm =getnlmnum($mediarelnlm);
	if ($mediarelnlm!="") {
		 stat_add("checkout_callnnlm",$mediarelnlm);		
	}

	$mediarellocal=trim(dspmarc(substr($mediarellocal,2)));
	$mediarellocal=str_replace(" ","|",$mediarellocal);
	$mediarellocal=str_replace("\t","|",$mediarellocal);
	$mediarellocal=str_replace(".","|",$mediarellocal);
	$mediarellocal=str_replace("-","|",$mediarellocal);
	$mediarellocal=str_replace("/","|",$mediarellocal);
	$mediarellocal=str_replace(":","|",$mediarellocal);
	$mediarellocal=explode("|",$mediarellocal);
	$mediarellocal=trim($mediarellocal[0]);
	if ($mediarellocal!="") {
		 stat_add("checkout_callnlocal",$mediarellocal);		
	}

	$sql2="update checkout set request='' where mediaId='$mediabarcode'";
	if (tmq($sql2)) {
	//พยายามลบค่า request เก่าสำเร็จ
	} else {
		$res[error][]=("ไม่สามารถลบค่า request เก่า::l::Cannot delete old request.");
	}

	 
	//fee to checkout
	//printr($row3);
	if ($row3[fee]!=0) {
		$sqlfee ="insert into fine (memberId,topic,fine,dt,lib)"; 
		$feeyea=date("Y"); //XXX
		$feemon=date("m");
		$feedat=date("d");
		$now=time();
		$mdtitle=addslashes($mdtitle);
		$sqlfee.=" values ('$memberbarcode','FEE: $mediatitle [$mediabarcode] ','$row3[fee]',$now,'$useradminid')"; 
		tmq($sqlfee);
	}
	///die;

	 //operate checkout
	 if ($confirm_forautorenew=="yes") {
		$tmp_renewedstat=tmq("select * from checkout where mediaId='$mediabarcode' ");
		$tmp_renewedstat=tmq_fetch_array($tmp_renewedstat);
		$tmp_renewedstat=floor($tmp_renewedstat[renewcount])+1;
		//echo "renewmark";
	   stathist_add("renew_member_media",$memberbarcode,$mediabarcode);	

	 } else {
		$tmp_renewedstat="0";
	 }
	 tmq("delete from request_list where itemid='$mediabarcode' ");
	 tmq("delete from checkout where mediaId='$mediabarcode' ");
	$sql="insert into checkout (mediaId,hold,sdat,smon,syea,allow,mediaName,fine,edat,emon,eyea,pid,RESOURCE_TYPE,libsite,renewcount,coengine)";
	$sql.=" values ('$mediabarcode','$memberbarcode','$useFdat','$useFmon','$useFyea','yes','$mediatitle','$xfine','$tmp2[0]','$tmp2[1]','$tmp2[2]','$media_pid','$RESOURCE_TYPE','$LIBSITE','$tmp_renewedstat','$_coengine')";
	if (tmq($sql)) {
		$res[success][]="ทำการยืมออกเรียบร้อย::l::Checked out";
	} else {
		echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";
   }
	$res["due"]="$tmp2[0]-$tmp2[1]-$tmp2[2]";
	$now=time();

	tmq("insert into media_edittrace set 
	login='$useradminid',
	dt='$now',
	bibid='$media_pid',
	edittype='checkout by $memberbarcode'
	");
	if (($Fyea)!=(date("Y")+543) || floor($Fmon)!=floor(date("n")) || floor($Fdat)!=floor(date("j"))) {
		tmq("insert into backdate_log set loginid='$useradminid',
		dt='".time()."' ,
		type1='checkout',
		bcode='$mediabarcode',
		memberid='$memberbarcode',
		from1='".(date("Y")+543)."-".date("n")."-".date("j")."',
		to1='$Fyea-$Fmon-$Fdat'
		",false);	
	}
	
	//check if success
	if (count($res[success])>0) {
		$res[status]="success";
		return cir_checkout_resp($res);
	}

	return cir_checkout_resp($res);
}
?>