<?php 
	$bibid=floor($bibid);
	if ($bibid==0) {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","bibid is missing [$bibid]");
	resp();
	}// พ 
	if ($bibresulttype=="") {
	$bibresulttype="marc";
	}
	$chkindex=tmq("select * from media where ID='$bibid' ");
	if (tnr($chkindex)==0) {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","bibid not found [$bibid]");
	resp();
	}
	if ($bibresulttype=="html") {
		$resultstr=html_displaymedia($bibid);
	}
	if ($bibresulttype=="marc") {
		$resultstr=html_displaymarc($bibid);
	}
	if ($bibresulttype=="marciso") {
		$resultstr=marc_export($bibid);
	}
	bresp("resultstr",$resultstr);
	bresp("bibid",$bibid);
			res_cov_dsp($bibid);
			bresp("media_cover",$res_cov_dsp_resulturl);		

	bresp("biburl",$dcrURL."dublin.php?ID=".($bibid));
	$thisresult=tmq("select * from media_mid where pid='$bibid'",false);
	$thisresulta=Array();
	$thisresulti=0;
	while ($thisresultr=tfa($thisresult)) {
		$thisresulti++;
		//printr($thisresultr);
		$thisresulta[$thisresulti]=Array();
		$thisresulta[$thisresulti][barcode]=$thisresultr[bcode];
		$thisresulta[$thisresulti][media_type]=$thisresultr[RESOURCE_TYPE];
		$thisresulta[$thisresulti][media_type_name]=get_media_type($thisresultr[RESOURCE_TYPE]);
		$thisresulta[$thisresulti][place]=$thisresultr[place];
		$thisresulta[$thisresulti][place_name]=get_itemplace_name($thisresultr[place]);
		$thisresulta[$thisresulti][calln]=marc_getmidcalln($thisresultr[bcode]);
		$thisresulta[$thisresulti][libsite]=$thisresultr[libsite];
		$thisresulta[$thisresulti][status]=$thisresultr[status];
	}
	bresp("itemlist",$thisresulta);
	//printr($kw); echo $_GET[keyword];
	//echo $sql;	


	resp();

?>