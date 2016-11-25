<?php 
//พ
$Barcode=trim($Barcode);
		$Barcode=trim($Barcode);
		if ($Barcode=="") {
				bresp("error","1");
				bresp("error_name",$er_dat);
				bresp("error_description","invalid Barcode [$Barcode]");
				resp();
		}
		
		$Fmon=date("n");
		$Fdat=date("j");
		$Fyea=date("Y");

if ( checkdate(intval($Fmon),intval($Fdat),intval($Fyea))!=true) {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","invalid date ");
	resp();
}
		$Fmon=date("n");
		$Fdat=date("j");
		$Fyea=date("Y")+543;
      $_coengine="api";
		$rqres=cir_checkin($Barcode,$Fdat,$Fmon,$Fyea);
		$eventarray=array_merge($rqres[error],$rqres[msg],$rqres[success]);
		@reset($eventarray);
		while (list($eventarrayk,$eventarrayv)=each($eventarray)) {
			$eventarray[$eventarrayk]=getlang($eventarrayv,"en");
		}
		if ($rqres[status]=="error") {
			@reset($rqres);
			bresp("error","1");
			bresp("error_name",$er_dat);
			bresp("error_description","Cannot Checkin");
			//echo implode("\n",$res[error]);;
			//printr($rqres[error]);
			$tmpstatus=implode("\n",$rqres[error]);
			bresp("member_barcode",trim($rqres[member_barcode]));
			bresp("member_name",trim($rqres[member_name]));
			bresp("media_name",marc_gettitle($rqres[media_pid]));
			res_cov_dsp($rqres[media_pid]);
			bresp("media_cover",$res_cov_dsp_resulturl);

			bresp("media_callnumber",marc_getmidcalln($Barcode));
			bresp("error_description",trim("Cannot Checkin"));
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
			//bresp("due",$rqres[due]);
			bresp("status","success");
			resp();
		}


?>