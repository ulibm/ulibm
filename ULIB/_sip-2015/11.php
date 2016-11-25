<?php 
$resp="12";

$Fdat=floor(date("d"));
$Fmon=floor(date("n"));
$Fyea=floor(date("Y"));
	 
$memberbarcode=$dat["AA"];
$mediabarcode=$dat["AB"];

	$tmp="SELECT *  FROM media_mid where bcode = '$mediabarcode' ";
	$tmp=tmq($tmp);
	if (tmq_num_rows($tmp) == 0) {
		$mid_exist=false;;//not found media id
		 $mediatitle="Item not exists";
		 $printline="Item not exists";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			local_sput($resp);
	} else {
		$mid_exist=true;
		$mid_info=tmq_fetch_array($tmp);
		$mediatitleth=marc_gettitle($mid_info[pid]);
		$mediatitle=local_formattitle($mediatitleth);
	}

/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {
	
	$sqlchk="select * from member where UserAdminID='$memberbarcode' ";
	$resultchk=tmq($sqlchk);
	if (tmq_num_rows($resultchk) == 0) { //member not found
		 $printline="Cannot find your record";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			local_sput($resp);

		 //120YUU25521210    133338AO1901|AA0005ssss|AB19010000000043|AJXBook 43|AH12-10-52|AFCannot find your record.|AGCannot find your record.|AY3AZD6E2
	}


}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	 $memberrecord=tmq_fetch_array($resultchk);

	$tmpmbtype="SELECT *  FROM member_type where type ='$memberrecord[type]'"; 
	$tmpmbtype=tmq($tmpmbtype);
	if (tmq_num_rows($tmpmbtype) == 0) {
		 $printline="Member type not exists , $memberrecord[type]";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			local_sput($resp);
	}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {
	$mbtype=$memberrecord[type];
		$tmpmbtype=tmq_fetch_array($tmpmbtype);
		$limithold=$tmpmbtype[limithold];
		$maxfine=$tmpmbtype[maxfine];

	 $lastdatecheckoutin=barcodeval_get("lastdatecheckoutin");
	 $thischeckoutdt=ymd_mkdt($Fdat,$Fmon,($Fyea));	 	
	 if ($lastdatecheckoutin<=$thischeckoutdt) {
		 $printline="Pass the last day library allow to checkout";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			local_sput($resp);

		 //120YUU25521210    132524AO1901|AA0005|AB19010000000052|AJBook52|AH12-10-52|AFThis item is currently checked out.|AGThis item is currently checked out.|
			//localdisplayerror("ไม่สามารถให้ยืมได้ เกินวัสดุท้ายที่ห้องสมุดเปิดรับคืน:<br /> ".ymd_datestr($lastdatecheckoutin,'date')."::l::Cannot checkout, over the last day library allow to checkout:<br /> ".ymd_datestr($lastdatecheckoutin,'date')." ");
	 }

 }/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	if ($memberrecord[statusactive]!="normal") {
		 $printline="Your patron has been blocked, contact staff";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			local_sput($resp);
	}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

$sqlchk="select * from fine where memberId='$memberbarcode' and isdone='no'";
$resultchk=tmq($sqlchk);
if (tmq_num_rows($resultchk) != 0) { 
	$countfinec=0;
	while ($countfiner=tmq_fetch_array($resultchk)) {
		$countfinec=$countfinec+$countfiner[fine];
	}
	if ($countfinec<=floor($maxfine)) { 
		
	} else {
		 $printline="You own too much fine, $countfinec THB";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			local_sput($resp);
	}
}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	//check mediaexists
$tmp="SELECT *  FROM media_mid where bcode = '$mediabarcode' ";
$tmp=tmq($tmp);
	if (tmq_num_rows($tmp) == 0) {
	 $printline="Bib not found";
	 $resp="12".
		"0NNN$siptime".
		"AO".barcodeval_get("sipsetting-institutionID").$limiter.
		"AA".$dat["AA"].$limiter.
		"AA".$dat["AB"].$limiter.
		"AJ".$mediatitle.$limiter.
		"AF".$printline.$limiter.
		"AG".$printline.$limiter;
		local_sput($resp);
	}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	$tmp=tmq_fetch_array($tmp);
	$media_primary=$tmp[id];
	$RESOURCE_TYPE=$tmp[RESOURCE_TYPE];
	//อาจมีการเปลี่ยนสถานะเป็ฯหนังสือสำรองโดยเช็คจากสถานะวัสดุ
	$media_pid=$tmp[pid];
	if ($tmp[status]!="") {
		$tmp2=tmq("select * from media_mid_status where code='$tmp[status]' ");
		if (tmq_num_rows($tmp2)!=1) {
			 $printline="Cannot checkout Bib status $tmp[status]";
			 $resp="12".
				"0NNN$siptime".
				"AO".barcodeval_get("sipsetting-institutionID").$limiter.
				"AA".$dat["AA"].$limiter.
				"AA".$dat["AB"].$limiter.
				"AJ".$mediatitle.$limiter.
				"AF".$printline.$limiter.
				"AG".$printline.$limiter;
				local_sput($resp);
		}

		/////////////////////////////////////////////////////////////////sub
		if ($SIPSENTthisround!=true) {

				$tmp2=tmq_fetch_array($tmp2);
				if ($tmp2[iscancheckout]!='yes') {
					 $printline="Cannot checkout this item has special status $row3[status]";
					 $resp="12".
						"0NNN$siptime".
						"AO".barcodeval_get("sipsetting-institutionID").$limiter.
						"AA".$dat["AA"].$limiter.
						"AA".$dat["AB"].$limiter.
						"AJ".$mediatitle.$limiter.
						"AF".$printline.$limiter.
						"AG".$printline.$limiter;
						local_sput($resp);
				}
				if ($tmp2[code]=='reservmat') {
					$RESOURCE_TYPE=$tmp2[code];
				}
		}
	}
			//libsite related
			/*
			if ("$tmp[libsite]"!="$LIBSITE") {
				$decis=getlibsiterule("$LIBSITE","$tmp[libsite]","addhold-thislibsiteitem");
				if ("$decis"=="no") {
					localdisplayerror("กรุณาตรวจสอบวัสดุ ไม่สามารถให้ยืมได้เนื่องจากเป็นวัสดุของ <U>".get_libsite_name($tmp[libsite])."</U>::l::Cannot checkout, this items is own by <U>".get_libsite_name($tmp[libsite])."</U>");
					die;
				}
			}
			*/

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

			//overdue check
			$decis=member_isoverduing($memberbarcode);
			if ($decis!="PASS") {
				 $printline="Patron got some overdue item";
				 $resp="12".
					"0NNN$siptime".
					"AO".barcodeval_get("sipsetting-institutionID").$limiter.
					"AA".$dat["AA"].$limiter.
					"AA".$dat["AB"].$limiter.
					"AJ".$mediatitle.$limiter.
					"AF".$printline.$limiter.
					"AG".$printline.$limiter;
				 local_sput($resp);
			}			

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	//ตรวจสอบว่าหนังสือถูกยืมอยู่รึเปล่า
	$tmp2="select * from checkout where mediaId='$mediabarcode' and request<>'$memberbarcode' ";
	$tmp2=tmq($tmp2);
	if (tmq_num_rows($tmp2) != 0) {
			 $printline="This item currently checked out";
			 $resp="12".
				"0NNN$siptime".
				"AO".barcodeval_get("sipsetting-institutionID").$limiter.
				"AA".$dat["AA"].$limiter.
				"AA".$dat["AB"].$limiter.
				"AJ".$mediatitle.$limiter.
				"AF".$printline.$limiter.
				"AG".$printline.$limiter;
			 local_sput($resp);
	}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

		//ตรวจสอบว่าหนังสือ bib เดียวกันถูกยืมอยู่หรือเปล่า
		$mediatypes="SELECT *  FROM media_type where code ='$RESOURCE_TYPE' ";
		$mediatypes=tmq($mediatypes);
		$mediatypes=tmq_fetch_array($mediatypes);
		
			if ($mediatype[ismagnetic]=="YES") {
				$ismagnetic="Y";
			} else {
				$ismagnetic.="N";
			}
		if ($mediatypes[canduphold]!="yes") {
			$tmp2="select * from checkout where pid='$media_pid' and hold='$memberbarcode' and RESOURCE_TYPE='$RESOURCE_TYPE' and returned='no' ";
			$tmp2=tmq($tmp2);
			if (tmq_num_rows($tmp2) != 0) {
				//localdisplayerror("เคยยืมวัสดุสารสนเทศชื่อเรื่องเดียวกัน ประเภทวัสดุเดียวกันไปแล้ว::l:: were checked out same material title and material type before.");
			 $printline="checked out same material title and material type";
			 $resp="12".
				"0NNN$siptime".
				"AO".barcodeval_get("sipsetting-institutionID").$limiter.
				"AA".$dat["AA"].$limiter.
				"AA".$dat["AB"].$limiter.
				"AJ".$mediatitle.$limiter.
				"AF".$printline.$limiter.
				"AG".$printline.$limiter;
				 local_sput($resp);
			}
		}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

		///////วันหมดอายุสมาชิก
		//print_r($memberrecord);
		if ($memberrecord[dat] != 0) {
			$todate=GregorianToJD2($Fmon, $Fdat, $Fyea+543);
			$mbdate=GregorianToJD2($memberrecord[mon], $memberrecord[dat], $memberrecord[yea]);
			if ($mbdate >= $todate) {
				//echo "สมาชิกยังไม่หมดอายุ";
			} else {
			 $printline="Your membership expired";
			 $resp="12".
				"0NNN$siptime".
				"AO".barcodeval_get("sipsetting-institutionID").$limiter.
				"AA".$dat["AA"].$limiter.
				"AA".$dat["AB"].$limiter.
				"AJ".$mediatitle.$limiter.
				"AF".$printline.$limiter.
				"AG".$printline.$limiter;
				 local_sput($resp);
			}
		} else {
			//echo "ไม่มีการกำหนดวันหมดอายุสมาชิก";
		}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	//find media bib
	$tmp2="SELECT *  FROM media where ID ='$media_pid'"; 
	$tmp2=tmq($tmp2);
	if (tmq_num_rows($tmp2) == 0) {
		 $printline="Bib not found";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			 local_sput($resp);
	}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

		$tmp2=tmq_fetch_array($tmp2);
		//print_r($tmp2);
		$mediatitleth=addslashes(marc_gettitle($tmp2[ID]));
		$mediatitle=local_formattitle($mediatitleth);
		
		/*
		if ($RESOURCE_TYPE=="serial") {
			$mediatitle.= " [" . serial_get_volstr($media_pid) . "]";
		}
		*/
	//ดูว่ายืมไปกี่รายการแล้ว
	$sql3="SELECT *  FROM checkout where hold ='$memberbarcode' and allow='yes' and returned='no' ";
	$result3=tmq($sql3);
	$row3=tmq_fetch_array($result3);
	$holded=tmq_num_rows($result3);
	if ($limithold > $holded) {
		//echo "ยืมได้อีก " . ($limithold - $holded) . " รายการ";
	}
	else {
		 $printline="Maximum checkout exeeded";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			 local_sput($resp);
	 }

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	/*
	 $sql3="SELECT *  FROM checkout where hold ='$memberbarcode' and allow='yes' and libsite='$LIBSITE' and returned='no'  ";
	$result3=tmq($sql3);
	$row3=tmq_fetch_array($result3);
	$holded=tmq_num_rows($result3);
	$libsitemaxhold=getlibsitevars("$LIBSITE","maxholditeminthislib");
	 if ($libsitemaxhold!=-1) {
		 if ($libsitemaxhold > $holded) {
			//echo "ยืมได้อีก " . ($libsitemaxhold - $holded) . " รายการ";
		} else {
			localdisplayerror("ไม่สามารถยืมได้อีกแล้ว ".get_libsite_name($LIBSITE)." ให้ยืมวัสดุได้มากทีสุด $libsitemaxhold รายการต่อสมาชิก 1 ท่าน::l::Cannot checkout . ".get_libsite_name($LIBSITE)." allow maximum checkout $libsitemaxhold items to 1 member");
			die();
		}
	 }
	 */

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

	 //ยืมได้ถึงวันที่เท่าไหร
		$sql3="SELECT *  FROM checkout_rule where media_type ='$RESOURCE_TYPE' and member_type='$mbtype'";
		$result3=tmq($sql3);
		$row3=tmq_fetch_array($result3);
		//print_r($row3);
		$dayallow=$row3[day];
		$xfine=$row3[fine];
		$Numchk=tmq_num_rows($result3);
		if ($Numchk == 0) {
		 $printline="Checkout rule not found [$RESOURCE_TYPE/$mbtype]";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
		 //localdisplayerror("ไม่พบกฏการยืม [$RESOURCE_TYPE/$mbtype]::l::Checkout rule not found [$RESOURCE_TYPE/$mbtype]");
			local_sput($resp);
		}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

		// is can checkout for mbtype
		if ($row3[cancheckout] != "yes") {
			 $printline="Cannot checkout  $RESOURCE_TYPE for $mbtype";
		 $resp="12".
			"0NNN$siptime".
			"AO".barcodeval_get("sipsetting-institutionID").$limiter.
			"AA".$dat["AA"].$limiter.
			"AA".$dat["AB"].$limiter.
			"AJ".$mediatitle.$limiter.
			"AF".$printline.$limiter.
			"AG".$printline.$limiter;
			local_sput($resp);
		}

}/////////////////////////////////////////////////////////////////
if ($SIPSENTthisround!=true) {

		$targetreturn1=ddl(intval($Fdat), intval($Fmon), intval($Fyea+543), $dayallow);
		$tmp2=explode(" ", $targetreturn1);
		$targetreturn1 = walkbackweekclose($tmp2[0],$tmp2[1],$tmp2[2]);
		$tmp2=explode(" ", $targetreturn1);

	 $thischeckoutdt=ymd_mkdt($tmp2[0],$tmp2[1],($tmp2[2]-543));	 	
	 if ($lastdatecheckoutin<=$thischeckoutdt) {
	    $tmp2=ymd_mkymd($lastdatecheckoutin);
			$tmp2[2]=$tmp2[2]+543;
    	//localdisplayerror("มีการปรับวันส่งอัตโนมัติ <br />เกินวัสดุท้ายที่ห้องสมุดเปิดรับคืน:<br /> ".ymd_datestr($lastdatecheckoutin,'date')."::l::Checkin date changes<br />, over the last day library allow to checkout:<br /> ".ymd_datestr($lastdatecheckoutin,'date')." ");
	 }
	 
	 	//check for returndate again
		$targetreturn1 = walkbackweekclose($tmp2[0],$tmp2[1],$tmp2[2]);
		$tmp2=explode(" ", $targetreturn1);
		//end check again
				
		statordr_add("checkout_book","$media_pid");
		statordr_add("checkout_member",$memberbarcode);	
		stat_add("checkout_byhrs",date("G"));
		stat_add("checkout_librarian",$sipuserid);
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

		$mediareldc =getdcnum($mediareldc);
		if ($mediareldc!="") {
			 stat_add("checkout_callndc",$mediareldc);		
		}
		$mediarellc =getlcnum($mediarellc);
		if ($mediarellc!="") {
			 stat_add("checkout_callnlc",$mediarellc);		
		}
		
	$sql2="update checkout set request='' where mediaId='$mediabarcode'";
	tmq($sql2);
	 
	 //fee to checkout
	//printr($row3);
	if ($row3[fee]!=0) {
		 $sqlfee ="insert into fine (memberId,topic,fine,dt,lib)"; 
			$feeyea=date("Y"); //XXX
			$feemon=date("m");
			$feedat=date("d");
			$now=time();
			$mdtitle=addslashes($mdtitle);
		 $sqlfee.=" values ('$memberbarcode','FEE: $mediatitle [$mediabarcode] ','$row3[fee]',$now,'$sipuserid')"; 
		 tmq($sqlfee);
	}
	///die;

	 //operate checkout
	 tmq("delete from request_list where itemid='$mediabarcode' ");
	 tmq("delete from checkout where mediaId='$mediabarcode' ");
	$sql="insert into checkout (mediaId,hold,sdat,smon,syea,allow,mediaName,fine,edat,emon,eyea,pid,RESOURCE_TYPE,libsite)";
	$sql.=" values ('$mediabarcode','$memberbarcode','$Fdat','$Fmon','".($Fyea+543)."','yes','$mediatitleth','$xfine','$tmp2[0]','$tmp2[1]','$tmp2[2]','$media_pid','$RESOURCE_TYPE','$LIBSITE')";
	tmq($sql);
	$duedatestr="$tmp2[0]-$tmp2[1]-$tmp2[2]";
	$printline="";
	$resp="12".
	"1N$ismagnetic$ismagnetic$siptime".
	"AO".barcodeval_get("sipsetting-institutionID").$limiter.
	"AA".$dat["AA"].$limiter.
	"AA".$dat["AB"].$limiter.
	"AJ".$mediatitle.$limiter.
	"AF".$printline.$limiter.
	"AF".$printline.$limiter.
	"AH".$duedatestr.$limiter.
	"AG".$printline.$limiter;

local_sput($resp);

} // SIPSENTthisround
?>