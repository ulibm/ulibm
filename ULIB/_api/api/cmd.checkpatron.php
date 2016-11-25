<?php 
	if ($PatronID=="") {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","PatronID is missing");
	resp();
	}
	$s=tmq("select * from member where UserAdminID='$PatronID' ");
	if (tmq_num_rows($s)<1) {
	bresp("error","1");
	bresp("chk_member","false");
	bresp("error_name",$er_dat);
	bresp("error_description","PatronID [$PatronID] not found");
	resp();
	}
	$s=tmq_fetch_array($s);
	//chk_member=  ตรวจสอบว่าเป็นสมาชิกหรือไม่ 
	bresp("chk_member","true");
	//name= ชื่อ นามสกุล
	bresp("picurl",member_pic_url($PatronID));
	bresp("name",$s[UserAdminName]);
	bresp("credit",$s[credit]);
	bresp("room_word",getlang(getval("_SETTING","room_word")));
	bresp("faculty_word",getlang(getval("_SETTING","faculty_word")));
	$sf=tmq("select * from room where id='$s[room]'");
	$sf=tmq_fetch_array($sf);
	bresp("room",get_room_name($s[room]));
	bresp("room_name",getlang($sf[name]));
	$sf=tmq("select * from major where id='$s[major]'");
	$sf=tmq_fetch_array($sf);
	bresp("major",getlang($sf[name]));

   //printr($s);
   if (floor($s[yea])==0 || ymd_mkdt($s[dat],$s[mon],($s[yea]-543))<0) {
   	bresp("expiredate","0-0-0");
   	bresp("expiredate_timestamp","0");
   } else {
   	bresp("expiredate",$s[dat]."-".$s[mon]."-".$s[yea]);
   	bresp("expiredate_timestamp",ymd_mkdt($s[dat],$s[mon],($s[yea]-543)));
   }
   //echo ymd_datestr(ymd_mkdt($s[dat],$s[mon],($s[yea]-543)));
//printr($s);

	//fine= ค่าปรับ
	$sf=tmq("select sum(fine) as cc from fine where memberId='$PatronID' and isdone<>'yes' ");
	$sf=tmq_fetch_array($sf);
	bresp("fine",$sf[cc]);
	//num_cir= ยืมได้กี่เล่ม
	$smemtype=tmq("select * from member_type where type='$s[type]' ");
	if (tmq_num_rows($smemtype)<>1) {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","PatronID [$PatronID] is type [$s[type]] not exist.");
	resp();
	}
	$smemtype=tmq_fetch_array($smemtype); //printr($smemtype);
	bresp("maxcheckout",$smemtype[limithold]);
	bresp("password",$s[Password]);
	bresp("member_type",$smemtype[type]);
	bresp("member_type_name",getlang($smemtype[descr]));
	$sql33="SELECT *  FROM fine where memberId='$PatronID' and isdone='no'";
	$result33=tmq($sql33);
	$NRow33=tmq_num_rows($result33);
	//echo "$NRow33";
	$i=0;
	$allfine=0;
	$fine_list=Array();
	while ($row33=tmq_fetch_array($result33))
		{
		$i++;
		$fine_list[$i]=Array();
		$fine_list[$i][bibid]=$row2[pid];
		$fine_list[$i][fine]=$row33[fine];
		$fine_list[$i][title]=$row33[topic];
	}
	//printr($fine_list);
	bresp("fine_list",$fine_list);
	bresp("maxfine",$smemtype[maxfine]);
	//chk_permit= มีสิทธิยืมหรือไม่
	bresp("chk_permit","true");
	if ($smemtype[maxfine]<$sf[cc]) {
		bresp("chk_permit","false");
	}
	//num_overdue= จำนวนหนังสือเกินกำหนดส่ง
	$sql="select * from checkout where hold='$PatronID' and allow='yes' and returned='no' order by id asc";
	$result=tmq($sql);
	$Num=tmq_num_rows($result);
	$okcount=0;
	$overcount=0;
	$checkout_list=Array();
	$i=0;
	$tmpfine=0;
	while ($row2=tmq_fetch_array($result)) {
		$i++;
		$checkout_list[$i]=Array();
		res_cov_dsp($row2[pid]);
		$checkout_list[$i][media_cover]=$res_cov_dsp_resulturl;
		$checkout_list[$i][bibid]=$row2[pid];
		$checkout_list[$i][barcode]=$row2[mediaId];
		$mediaId=$row2[mediaId];
		$mediapid=$row2[pid];

		$checkout_list[$i][title]=mb_substr(marc_gettitle(strip_tags($mediapid)),0,40);
		
		$checkout_list[$i][start]=$row2[sdat]."-".$row2[smon]."-".$row2[syea];
		$checkout_list[$i][end]=$row2[edat]."-".$row2[emon]."-".$row2[eyea];

		$RESOURCE_TYPE=$row2[RESOURCE_TYPE];
		$sdat=$row2[sdat];
		$smon=$row2[smon];
		$syea=$row2[syea];
		$edat=$row2[edat];
		$emon=$row2[emon];
		$eyea=$row2[eyea];

		$xfine=$row2[fine];

		$tmpdecis=getduedecis($mediaId, date("j"), date("n"), date("Y"));//xxxxx
		//echo date("Y");
		$daydiff=ddx(date("j"),date("n"),date("Y"),$edat,$emon,$eyea-543);
		$daydiff=round($daydiff);
		//echo $tmpdecis;
		if ($tmpdecis > 0) {
			$tmpfine=($tmpdecis * $xfine);
			$allfine+=$tmpfine;
			$overcount++;
		} else {
			$okcount++;
		}
	} 
	//printr($checkout_list);
	bresp("checkout_list",$checkout_list);
	bresp("num_overdue",floor($overcount));
	bresp("num_checkedout",floor($Num));
	bresp("fine_expected",floor($allfine));

	resp();

?>