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

	//chk amount
	$amount=floor($amount);
	if ($amount<1) {
		bresp("error","1");
		bresp("error_name",$er_dat);
		bresp("error_description","amount [$amount] unacceptable");
		resp();
	}
	if ($s[credit]<$amount) {
		bresp("error","1");
		bresp("error_name",$er_dat);
		bresp("error_description","not enough credit [need $amount] current balance ".number_format($s[credit])."");
		resp();
	}
	
	$note=trim($note);
	$note=addslashes($note);
	$note=trim($note);
	if ($note=="") {
		$note="-";
	}
	$tid=randid();
	$now=time();
	$dat=date("d");
	$mon=date("n");
	$yea=date("Y");
	tmq("insert into fine set
	idid='$tid' ,
	memberId='$PatronID' ,
	topic='add by API [$IPADDR]-[note:$note]' ,
	lib='api' ,
	fine='$amount' ,
	isdone='yes' ,
	dt='$now' 	
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

	tmq("update member set credit=credit-$amount where UserAdminID='$PatronID'  limit 1");
	$s=tmq("select * from member where UserAdminID='$PatronID' ");
	$s=tmq_fetch_array($s);
	bresp("credit",$s[credit]);
	bresp("refid",$tid);
	bresp("status","success");
	//fine= ค่าปรับ




	resp();

?>