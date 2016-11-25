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
	//printr($s);
	//chk_member=  ตรวจสอบว่าเป็นสมาชิกหรือไม่ 
	bresp("chk_member","true");
	//name= ชื่อ นามสกุล
	bresp("name",$s[UserAdminName]);
	bresp("credit",$s[credit]);

	//fine= ค่าปรับ
	$sf=tmq("select sum(fine) as cc from fine where memberId='$PatronID' and isdone<>'yes' ");
	$sf=tmq_fetch_array($sf);
	bresp("fine",$sf[cc]);
	$sf[cc]=floor($sf[cc]);
	//printr($sf);
	//num_cir= ยืมได้กี่เล่ม
	$smemtype=tmq("select * from member_type where type='$s[type]' ");
	if (tmq_num_rows($smemtype)<>1) {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","PatronID [$PatronID] is type [$s[type]] not exist.");
	resp();
	}
	$smemtype=tmq_fetch_array($smemtype); 
	$smemtype[maxfine]=floor($smemtype[maxfine]);
	//printr($smemtype);
	bresp("fine",$sf[cc]);
	$sql33="SELECT *  FROM fine where memberId='$PatronID' and isdone='no'";
	$result33=tmq($sql33);
	$NRow33=tmq_num_rows($result33);
	//echo "$NRow33";
	$i=0;
	$allfine=0;
	$fine_list=Array();
	while ($row33=tmq_fetch_array($result33))
		{
			//printr($row33);
		$i++;
		$fine_list[$i]=Array();
		$fine_list[$i][bibid]=$row2[pid];
		$fine_list[$i][fine]=$row33[fine];
		$fine_list[$i][title]=$row33[topic];
		$fine_list[$i][date]=date("Y-m-d",$row33[dt]);
	}
	//printr($fine_list);
	bresp("fine_list",$fine_list);
	bresp("maxfine",$smemtype[maxfine]);
	//chk_permit= มีสิทธิยืมหรือไม่
	bresp("chk_permit","true");
	//echo "($smemtype[maxfine]>=$sf[cc]) ";
	if ($smemtype[maxfine]<$sf[cc]) { 
		//echo "$smemtype[maxfine]>=$sf[cc]) disable checkout";
		bresp("chk_permit","false");
	}


	resp();

?>