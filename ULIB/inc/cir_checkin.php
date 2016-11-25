<?php  //à¸
function cir_checkin($mediabarcode,$Fdat,$Fmon,$Fyea,$overrideall="no") {
	//echo "cir_checkin($mediabarcode,$Fdat,$Fmon,$Fyea)";
	global $dcrURL;
	global $_coengine;
	if ($_coengine=="") {
		$_coengine="cir";
	}
	global $LIBSITE;
	global $useradminid;
	if (!function_exists("cir_checkin_resp")) {
		function cir_checkin_resp($wh) {
			//printr($wh);
			return $wh;
		}
	}
	$res=Array();
	$res[success]=Array();
	$res[error]=Array();
	$res[msg]=Array();
	$res[status]="";

	
	if ($overrideall!="yes") {

		$tmp="SELECT *  FROM media_mid where bcode = '$mediabarcode' ";
		$tmp=tmq($tmp);
		if (tmq_num_rows($tmp) == 0) {
			$res[error][]=("mediaid_notexist");
		}
		$tmp=tmq_fetch_array($tmp);
		$media_primary=$tmp[id];
		$RESOURCE_TYPE=$tmp[RESOURCE_TYPE];
		//à¸­à¸²à¸à¸¡à¸µà¸à¸²à¸£à¹à¸à¸¥à¸µà¹à¸¢à¸à¸ªà¸à¸²à¸à¸°à¹à¸à¹à¸¯à¸«à¸à¸±à¸à¸ªà¸·à¸­à¸ªà¸³à¸£à¸­à¸à¹à¸à¸¢à¹à¸à¹à¸à¸à¸²à¸à¸ªà¸à¸²à¸à¸°à¸§à¸±à¸ªà¸à¸¸
		$media_pid=$tmp[pid];
		$res[media_pid]=$media_pid;
   	$res[mediabarcode]="$mediabarcode";



		$Fyea=$Fyea-543;
		if ( checkdate(intval($Fmon),intval($Fdat),intval($Fyea))!=true) {
			$res[error][]=("ระบุวันที่ไม่ถูกต้อง กรุณาระบุใหม่::l::Incorrect date, please try again");
		}

		$sqlchk = "select * from checkout where mediaId='$mediabarcode' and returned='no' ";    
		$sqlchk = tmq($sqlchk);
		if (tmq_num_rows($sqlchk)==0) {
			$res[error][]=("ไม่พบทรัพยากรนี้ในข้อมูลการยืมคืน<nobr>กรุณาแยกวัสดุนี้เพื่อการลงทะเบียน</nobr>::l::This item was not checked-out from library, please register this item first");
			$res[status]="error";
			//printr($res);
			return cir_checkin_resp($res);
		}
		$sqlchk=tmq_fetch_array($sqlchk);
		$xfine=$sqlchk[fine];
		$checkoutid=$sqlchk[id];
		$mdtitle=$sqlchk[mediaName];
		$requestid=$sqlchk[request];
		$gbisrq=$sqlchk[request];
		$memberbarcode=$sqlchk[hold];
		$res[memberbarcode]=$memberbarcode;

		//mid exists
		$tmp="SELECT *  FROM media_mid where bcode = '$mediabarcode' ";
		$tmp=tmq($tmp);
		if (tmq_num_rows($tmp) == 0) {
			$res[error][]=getlang("กรุณาตรวจสอบบาร์โค้ด &quot;$mediabarcode&quot; ไม่พบบาร์โค้ดนี้ในฐานข้อมูลทรัพยากร::l::Please recheck barcode &quot;$mediabarcode&quot; barcode not found in database");
			$mid_exist=false;
		 } else {
			$mid_exist=true;
		 }
		 $mid_info=tmq_fetch_array($tmp);

		//libsite
		if ("$mid_info[libsite]"!="$LIBSITE" && $mid_exist==true) {
			$res[msg][]=getlang("กรุณาแยกทรัพยากรนี้ เนื่องจากเป็นของสาขา <U>".get_libsite_name($mid_info[libsite])."</U>  กรุณานำส่งสาขาห้องสมุด::l::Please keep this item seperately, its item of  <U>".get_libsite_name($mid_info[libsite])."</U>  please send it back.");
			$decis=getlibsiterule("$LIBSITE","$mid_info[libsite]","return-fromthis");

			if ("$decis"=="no") {
				$res[error][]=getlang("ไม่สามารถรับคืนได้ เป็นทรัพยากรของ <U>".get_libsite_name($mid_info[libsite])."</U>::l::Cannot checkin, its item of <U>".get_libsite_name($mid_info[libsite])."</U>");
			}
		}


		$tmpdecis=getduedecis($mediabarcode,$Fdat, $Fmon, $Fyea);

		if ($tmpdecis<=0) {   
			//$res[msg][]=getlang("à¸¢à¸·à¸¡à¹à¸à¹à¸­à¸µà¸ $tmpdecis à¸§à¸±à¸::l::Can hold more $tmpdecis days"); 
		} else {
			$res[msg][]=getlang("เกินกำหนดส่ง $tmpdecis วัน ::l::overdued $tmpdecis day(s)");
			//$res[msg][]=getlang("มีการเกินกำหนดส่ง  ::l::Overdued");
			$tmpfine =  ($tmpdecis*$xfine);
			 $sql ="insert into fine (memberId,topic,fine,dt,lib)"; 
				$rfyea=date("Y"); //XXX
				$rfmon=date("m");
				$rfdat=date("d");
				$now=time();
				$mdtitle=addslashes($mdtitle);
			 $sql.=" values ('$memberbarcode','OVER DUE: $mdtitle [$mediabarcode] ','$tmpfine',$now,'$useradminid')"; 
			if(tmq($sql)) {
			} else {
				$res[error][]=("ผิดพลาด ไม่สามารถทำการเพิ่มค่าปรับ::l::Cannot add fine");
			}
		}

		$res[msg][]=getlang("รับคืนทรัพยากร :::l::Checkin:").$mdtitle.'';

		$res[media_pid]=$mid_info[pid];
		//check if error
		if (count($res[error])>0 && $overrideall!="yes") {
			$res[status]="error";
			return cir_checkin_resp($res);
		}

	} else {
		$res[success][]=getlang("Force Checkin");
	}  // end overrideall

	//add to checkout_log
	$logorig=tmq("select * from checkout where id='$sqlchk[id]'");
	$logorigr=tfa($logorig);
	$insertlogsql="
idorig='".addslashes($logorigr[id])."',
mediaId='".addslashes($logorigr[mediaId])."',
hold='".addslashes($logorigr[hold])."',
request='".addslashes($logorigr[request])."',
sdat='".addslashes($logorigr[sdat])."',
smon='".addslashes($logorigr[smon])."',
syea='".addslashes($logorigr[syea])."',
edat='".addslashes($logorigr[edat])."',
emon='".addslashes($logorigr[emon])."',
eyea='".addslashes($logorigr[eyea])."',
allow='".addslashes($logorigr[allow])."',
returned='".addslashes($logorigr[returned])."',
mediaIdr='".addslashes($logorigr[mediaIdr])."',
isrenew='".addslashes($logorigr[isrenew])."',
renewcount='".addslashes($logorigr[renewcount])."',
mediaName='".addslashes($logorigr[mediaName])."',
fine='".addslashes($logorigr[fine])."',
pid='".addslashes($logorigr[pid])."',
RESOURCE_TYPE='".addslashes($logorigr[RESOURCE_TYPE])."',
libsite='".addslashes($logorigr[libsite])."',
edt='".addslashes($logorigr[edt])."',
coengine='".addslashes($logorigr[coengine])."'";

	tmq("insert into checkout_logorig set  $insertlogsql ");
	tmq("insert into checkout_log set  $insertlogsql");
	$newlogid=tmq_insert_id();
	tmq("update checkout_log set edat='$Fdat', emon='$Fmon',eyea='".($Fyea+543)."' ,edt='".time()."' where id='$newlogid' ");


	if ($requestid=="") { 
		
		//à¸«à¸²à¸à¹à¸¡à¹à¸¡à¸µà¸à¸à¸¢à¸·à¸¡ à¸¥à¸à¸à¸´à¹à¸
		$sqlchst ="delete from checkout where mediaId ='$mediabarcode'";
		//echo "$sqlchst";
		if(tmq($sqlchst)) {
			//à¹à¸à¸¥à¸µà¹à¸¢à¸à¸ªà¸à¸²à¸à¸°à¸ªà¸³à¹à¸£à¹à¸
		} else {
			$res[error][]=("Cannot delete old checkout record");
		}
	} else {
	  $now=time();
		$sqlchst ="update checkout set returned='yes',edt=$now where mediaId='$mediabarcode'";  
		if(tmq($sqlchst)) {
			//à¹à¸à¸¥à¸µà¹à¸¢à¸à¸ªà¸à¸²à¸à¸°à¸ªà¸³à¹à¸£à¹à¸
			$res[msg][]=getlang("เป็นรายการจอง กรุณาแยกไว้ที่ชั้นจอง::l::This is request item, please place this book at pick-up shelf");
			if ($_coengine=="cir") {
			   $res[msg][]="<a href='working.rq.print.php?rqid=$checkoutid' target=_blank>".getlang("พิมพ์ใบจอง::l::Print req. slip")."</a>";
			}

		} else {
			$res[error][]=getlang("Cannot update old checkout record, (with request)");
		}    
	}

	if ($_coengine=="cir") {
		localloadmember($memberbarcode,"yes");
	}

	$now=time();
	//for at cir status
$hrs=getval("config","timetocirputtoshelf");
$hrsod=trim(getval("config","timeofdaytocirputtoshelf"),", ");
if ("$hrs"=="-1" && $hrsod!="") {
   $hrsoda=explode(",",$hrsod);
   sort($hrsoda);
   $hrsoda=arr_filter_remnull($hrsoda);
   @reset($hrsoda);
   $plusaday=0;
   $nowhrs=date("H.i");
   $usehrs="";
   while (list($hrsodk,$hrsodv)=each($hrsoda)) {
      //echo "[$nowhrs--$hrsodv]<BR>";
      if ($nowhrs<$hrsodv) {
         $usehrs=$hrsodv;
         break;
      }
   }
   if ($usehrs=="") {
      //first on next day
      $plusaday=1;
      @reset($hrsoda);
      list($hrsodk,$hrsodv)=each($hrsoda);
      $usehrs=$hrsodv;
   }
   $timetoshelf=ymd_mkdt(date("d")+$plusaday,date("m"),date("Y"));
   $usehrsa=explode(".",$usehrs);
   $timetoshelf=$timetoshelf+(($usehrsa[0])*60*60)+(($usehrsa[1])*60);
   
      //echo "got $usehrs - ".ymd_datestr($timetoshelf);; die;

} else {
   $timetoshelf=time()+(60*60*$hrs);
}

	tmq("update media_mid set lastcheckin='$timetoshelf' where bcode = '$mediabarcode' ");

	//stathist_add("checkout_member_libsite",$LIBSITE,$memberbarcode);	
		stat_add("checkin_librarian",$useradminid);
		stathist_add("checkin_member_libsite",$memberbarcode,$LIBSITE);	
	   stathist_add("checkin_member_media",$memberbarcode,$mediabarcode);	
   	stathist_add("checkin_media_librarian",$mediabarcode,$useradminid);	

	if (count($res[success])>0) {
		$res[status]="success";
		return cir_checkin_resp($res);
	}
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$IDEDIT',
		edittype='checkin'
		");
	if (($Fyea)!=(date("Y")) || floor($Fmon)!=floor(date("n")) || floor($Fdat)!=floor(date("j"))) {
		tmq("insert into backdate_log set loginid='$useradminid',
		dt='".time()."' ,
		type1='checkin',
		bcode='$mediabarcode',
		memberid='$memberbarcode',
		from1='".(date("Y")+543)."-".date("n")."-".date("j")."',
		to1='".($Fyea+543)."-$Fmon-$Fdat'
		",false);	
	}
	$res[member_barcode]=$memberbarcode;
	$res[member_name]=strip_tags(get_member_name($memberbarcode));

	return cir_checkin_resp($res);


}
?>