<?php 
	if ($PatronID=="") {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","PatronID is missing");
	resp();
	}
		$Fmon=date("n");
		$Fdat=date("j");
		$Fyea=date("Y")+543;
      $_coengine="api";
		$rqres=cir_checkout($PatronID,$Barcode,$Fdat,$Fmon,$Fyea); 
		//printr($rqres);
		$eventarray=array_merge($rqres[error],$rqres[msg],$rqres[success]);
		@reset($eventarray);
		while (list($eventarrayk,$eventarrayv)=each($eventarray)) {
			$eventarray[$eventarrayk]=getlang($eventarrayv,"en");
		}
		if ($rqres[status]=="error") {
			bresp("error","1");
			bresp("error_name",$er_dat);
			bresp("error_description","Cannot Checkout");
			bresp("media_name",marc_gettitle($rqres[media_pid]));
			bresp("media_callnumber",marc_getmidcalln($Barcode));
			res_cov_dsp($rqres[media_pid]);
			bresp("media_cover",$res_cov_dsp_resulturl);
			bresp("error_description","Cannot Checkout");
			bresp("description",$eventarray);
			bresp("event",$eventarray);
			resp();
		} else {
			res_cov_dsp($rqres[media_pid]);
			bresp("media_cover",$res_cov_dsp_resulturl);
			bresp("media_name",marc_gettitle($rqres[media_pid]));
			bresp("media_callnumber",marc_getmidcalln($Barcode));
			bresp("description",$eventarray);
			bresp("event",$eventarray);
			bresp("due",$rqres[due]);
			bresp("status","success");
			resp();
		}
	/*
	chk_mem_chkout= ตรวจสอบ Barcodeนี้มีคนยืมแล้วหรือไม่ 
	chk_status_chkout= member นี้สามารถยืมได้หรือไม่
	media_name = ชื่อหนังสือ
	media_callnumber = Call number
	due=วันกำหนดคืนหนังสือ
	status = การยืมสำเร็จหรือไม่
*/

	resp();

?>