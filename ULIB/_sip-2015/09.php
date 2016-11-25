<?php 
$resp="";

$Fdat=floor(date("d"));
$Fmon=floor(date("n"));
$Fyea=floor(date("Y"));

$mediabarcode=$dat["AB"];

	$sqlchk = "select * from checkout where mediaId='$mediabarcode' and returned='no' ";
	$sqlchk = tmq($sqlchk,true);
	if (tmq_num_rows($sqlchk)==0) {
		$resp="100Y";
		$checkoutexist=false;
	} else {
		$resp="101Y";
		$checkoutexist=true;
	}
	$sqlchk=tmq_fetch_array($sqlchk);
	$xfine=$sqlchk[fine];
	$checkoutid=$sqlchk[id];
	$mdtitle=$sqlchk[mediaName];
	$requestid=$sqlchk[request];
	$gbisrq=$sqlchk[request];
	$memberbarcode=$sqlchk[hold];


	//mid exists
	$tmp="SELECT *  FROM media_mid where bcode = '$mediabarcode' ";
	$tmp=tmq($tmp);
	if (tmq_num_rows($tmp) == 0) {
		$mid_exist=false;;//not found media id
		$resp="100N";
	} else {
		$mid_exist=true;
	}
	 $mid_info=tmq_fetch_array($tmp);

	//libsite
	/*
	if ("$mid_info[libsite]"!="$LIBSITE" && $mid_exist==true) {
		$decis=getlibsiterule("$LIBSITE","$mid_info[libsite]","return-fromthis");

		if ("$decis"=="no") {
			localdisplayerror("ไม่สามารถรับคืนได้ เนื่องจากเป็นวัสดุของ <U>".get_libsite_name($mid_info[libsite])."</U>::l::Cannot checkin, its item of <U>".get_libsite_name($mid_info[libsite])."</U>");
			die;
		}
	}
	*/
	$mediatype=tmq("select * from media_type where code='$mid_info[RESOURCE_TYPE]' ");
	$mediatype=tmq_fetch_array($mediatype);
	if ($mediatype[ismagnetic]=="YES") {
		$resp.="Y";
	} else {
		$resp.="N";
	}

	if ($checkoutexist==true) {
		$tmpdecis=getduedecis($mediabarcode,$Fdat, $Fmon, $Fyea);

		if ($tmpdecis<=0) {   
			//$appendmsg[]= getlang("ยืมได้อีก $tmpdecis วัน::l::Can hold more $tmpdecis days");
			$resp.="N";
			$printline="Normal Checkin";
		} else {
			$resp.="Y";
			$tmpfine =  ($tmpdecis*$xfine);
			 $sql ="insert into fine (memberId,topic,fine,dt,lib)"; 
				$rfyea=date("Y"); 
				$rfmon=date("m");
				$rfdat=date("d");
				$now=time();
				$mdtitle=addslashes($mdtitle);
			 $sql.=" values ('$memberbarcode','OVER DUE: $mdtitle [$mediabarcode] ','$tmpfine',$now,'$useradminid')"; 
			tmq($sql);
			$printline="Overdue, Fine $tmpfine THB";
		}
	} else {
		$resp.="Y";
		$printline="Item not checked out";
	}

	if ($mid_exist==true) {
		$mediatitle=local_formattitle(marc_gettitle($mid_info[pid]));
	} else {
		$mediatitle="Item not exists";
		$printline="Item not exists";
	}

	$resp.="$siptime".
	"AO".barcodeval_get("sipsetting-institutionID").$limiter.
	"AB".$dat["AB"].$limiter.
	"AQ".$mid_info["place"].$limiter.
	"AJ".$mediatitle.$limiter.
	"AA".$memberbarcode.$limiter. //optional
	"AF".$printline.$limiter.
	"AG".$printline.$limiter;

	if ($requestid=="") { //หากไม่มีคนยืม ลบทิ้ง
		$sqlchst ="delete from checkout where mediaId ='$mediabarcode'";
		//echo "$sqlchst";
		tmq($sqlchst);
	} else {///มีการจอง ปรับสถานะ
	  $now=time();
		$sqlchst ="update checkout set returned='yes',edt=$now where mediaId='$mediabarcode'";
		tmq($sqlchst);
	}

	$now=time();
	//for at cir status
	tmq("update media_mid set lastcheckin='$now' where bcode = '$mediabarcode' ");

	local_sput($resp);

?>