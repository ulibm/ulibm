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
	bresp("name",$s[UserAdminName]);
	$credit=floor($s[credit]);

	if (trim(strtolower($mergecredit))!="false") {
		$mergecredit="true";
	}

	//fine= ค่าปรับ
	$sf=tmq("select sum(fine) as cc from fine where memberId='$PatronID' and isdone<>'yes' ");
	$sf=tmq_fetch_array($sf);
	bresp("fine",floor($sf[cc]));
	$sf[cc]=floor($sf[cc]);
	$totalfine=floor($sf[cc]);
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
	$amount=floor($amount);
	if ($amount<1) {
		bresp("error","1");
		bresp("error_name",$er_dat);
		bresp("error_description","amount [$amount] unacceptable");
		resp();
	}
	$note=trim($note);
	$note=addslashes($note);
	$note=trim($note);
	if ($note=="") {
		$note="-";
	}	
	$now=time();
	$dat=date("d");
	$mon=date("n");
	$yea=date("Y");

	// eq
	if ($totalfine==$amount) {
		$tid=randid();
		tmq("update fine set
		idid='$tid' ,
		lib='api' ,
		isdone='yes'
		where memberId='$PatronID'  and isdone='no'
		");
		tmq("insert into finedone set
		idid='$tid' ,
		cach='0' ,
		credit='$amount' ,
		lib='api' ,
		member='$PatronID' ,
		dt='$now' ,
		dat='$dat' ,
		mon='$mon' ,
		yea='$yea' 
		");
			bresp("credit_prev",$s[credit]);
			bresp("credit",$s[credit]);
			bresp("fine_prev",$totalfine);
			bresp("fine",0);
			bresp("refid",$tid);
			bresp("status","success");
			resp();
	}
	// too much
	if ($totalfine<$amount) {
		if ($mergecredit=="false") {
			bresp("error","1");
			bresp("error_name",$er_dat);
			bresp("error_description","amount of payment [$amount] too much , totalfine is [$totalfine]");
			resp();
		} else { // add the rest to credits
			$tid=randid();
			$amountleft=floor($amount-$totalfine);
			tmq("insert into fine set
			idid='$tid' ,
			memberId='$PatronID' ,
			topic='add by API [$IPADDR]-[pay too much]-[note:$note]' ,
			lib='api' ,
			fine='$amountleft' ,
			isdone='yes' ,
			dt='$now' 	
			");
			tmq("insert into finedone set
			idid='$tid' ,
			cach='$amountleft' ,
			lib='api' ,
			member='$PatronID' ,
			dt='$now' ,
			dat='$dat' ,
			mon='$mon' ,
			yea='$yea' 

			");	
			tmq("update member set credit=credit+$amountleft where UserAdminID='$PatronID'  limit 1");
			$s=tmq("select * from member where UserAdminID='$PatronID' ");
			$s=tmq_fetch_array($s);
			//pay fines
			$tid=randid();
			tmq("update fine set
			isdone='yes',
			idid='$tid'
			where memberId='$PatronID'  and isdone='no'
			");
			tmq("insert into finedone set
			idid='$tid' ,
			cach='$totalfine' ,
			lib='api' ,
			member='$PatronID' ,
			dt='$now' ,
			dat='$dat' ,
			mon='$mon' ,
			yea='$yea' 

			");	
			bresp("credit_prev",$credit);
			$s=tmq("select * from member where UserAdminID='$PatronID' ");
			$s=tmq_fetch_array($s);
			bresp("credit",$s[credit]);
			bresp("fine_prev",$totalfine);
			bresp("fine",0);
			bresp("refid",$tid);
			bresp("status","success");
			resp();

		}
	}
	//too low
	if ($totalfine>$amount) {
		$needmore=floor($totalfine-$amount);
		if ($mergecredit=="false") {
			bresp("error","1");
			bresp("error_name",$er_dat);
			bresp("error_description","amount of payment [$amount] not enough , totalfine is [$totalfine]");
			resp();
		}  else {
			if ($totalfine<=($amount+$credit)) {
				$creditleft=floor($credit-$needmore);
				tmq("update member set credit=$creditleft where UserAdminID='$PatronID'  limit 1");
				$s=tmq("select * from member where UserAdminID='$PatronID' ");
				$s=tmq_fetch_array($s);
				//pay fines
				$tid=randid();
				tmq("update fine set
				isdone='yes',
				idid='$tid'
				where memberId='$PatronID' and isdone='no'
				");
				tmq("insert into finedone set
				idid='$tid' ,
				cach='$amount' ,
				credit='$needmore' ,
				lib='api' ,
				member='$PatronID' ,
				dt='$now' ,
				dat='$dat' ,
				mon='$mon' ,
				yea='$yea' 

				");	
				bresp("credit_prev",$credit);
				bresp("credit",$s[credit]);
				bresp("fine_prev",$totalfine);
				bresp("fine",0);
				bresp("refid",$tid);
				bresp("status","success");
				resp();
			} else { //combined, still not enough
				bresp("error","1");
				bresp("error_name",$er_dat);
				bresp("error_description","amount of payment [$amount] plus credit [$credit] not enough , totalfine is [$totalfine]");
				resp();
			}
		}
	}
	


?>