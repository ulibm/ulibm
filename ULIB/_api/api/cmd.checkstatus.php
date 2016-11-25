<?php  

		$Barcode=trim($Barcode);
		$Barcode=trim($Barcode);
		if ($Barcode=="") {
				bresp("error","1");
				bresp("error_name",$er_dat);
				bresp("error_description","invalid Barcode [$Barcode]");
				resp();
		}
// พ 
	$tmp=tmq("select * from media_mid where bcode='$Barcode' ");
	if (tmq_num_rows($tmp)!=1) {
		bresp("error","1");
		bresp("error_name",$er_dat);
		bresp("error_description","Barcode not found [$Barcode]");
		resp();
	}
	$tmp=tmq_fetch_array($tmp);

	$s=tmq("select * from media_type where code='$tmp[RESOURCE_TYPE]' ");	
	$s=tmq_fetch_array($s);
	bresp("resource_type",getlang($s[name]));
	bresp("resource_typecode",$tmp[RESOURCE_TYPE]);
	bresp("tabean",$tmp[tabean]);
	bresp("note",$tmp[note]);

	bresp("chk_checkout","true");
	bresp("reserv_status","false");
	bresp("reserv_patronID","");

	if ($tmp[status]=='') {
		bresp("status","normal");
	} else {
		$s=tmq("select * from media_mid_status  where code='$tmp[status]' ");	
		$s=tmq_fetch_array($s);
		bresp("status",$s[name]);
		bresp("status_code",$tmp[name]);
		if ($s[iscancheckout]=="no") {
			bresp("chk_checkout","false");
			bresp("event_checkout ","Status:".$s[name]);
		} else {
			bresp("chk_checkout","true");
		}
	}
	$s=tmq("select * from media_place where code='$tmp[place]' ");	
	$s=tmq_fetch_array($s);
	bresp("place",getlang($s[name]));
	bresp("campus",$tmp[libsite]);
	bresp("campus_name",get_libsite_name($tmp[libsite]));

	$s=tmq("select * from checkout where mediaId='$tmp[bcode]' ");	
	if (tmq_num_rows($s)!=0) {
		$s=tmq_fetch_array($s);
		bresp("chk_checkout","false");
		bresp("event_checkout","Checked out by:".$s[hold]);
		bresp("event_checkout_start","$s[sdat]-$s[smon]-$s[syea]");
		bresp("event_checkout_end","$s[edat]-$s[emon]-$s[eyea]");
		if ($s[request]=="") {
			bresp("reserv_status","false");
		} else {
			bresp("reserv_status","true");
			bresp("reserv_patronID",$s[request]);
		}
		$mbtype=tmq("select * from member where UserAdminID='$s[hold]' ");
		$mbtype=tmq_fetch_array($mbtype);
		$chkrenew="SELECT *  FROM checkout_rule where media_type ='$s[RESOURCE_TYPE]' and member_type='$mbtype[type]'  and libsite='$LIBSITE' ";
		$chkrenew=tmq($chkrenew);
		$chkrenewr=tmq_fetch_array($chkrenew);
		bresp("renew_status","$s[renewcount]/$chkrenewr[renew]");
	}
	bresp("media_name",marc_gettitle($tmp[pid]));
			res_cov_dsp($tmp[pid]);
			bresp("media_cover",$res_cov_dsp_resulturl);
	bresp("callnumber",marc_getmidcalln($Barcode));
	bresp("copy",$tmp[inumber]);
	bresp("price",$tmp[price]);
	bresp("bibid",$tmp[pid]);
	resp();

?>