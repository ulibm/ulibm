<?php 
 $sqllimit="";// พ
	if ($status!="") {
		$sqllimit=" and status='$status' ";
	}
	$limitdate=floor(form_pickdt_get("limitdate"));
	if ($limitdate>20) {
	$sqllimit="$sqllimit and dt_str='$limitdate_dat-$limitdate_mon-$limitdate_yea' ";
	}
	$limitdatelastxday=floor(form_pickdt_get("limitdatelastxday"));
	$limitdatelastxdayend=floor(form_pickdt_get("limitdatelastxdayend"));
	$limitdatestatuschanges=floor(form_pickdt_get("limitdatestatuschanges"));
	$limitdatestatuschangee=floor(form_pickdt_get("limitdatestatuschangee"));
	if ($limitdatelastxday>20) {
		$sqllimit="$sqllimit and dt>='$limitdatelastxday' ";
	}
	if ($limitdatelastxdayend>20) {
		$sqllimit="$sqllimit and dt<='$limitdatelastxdayend' ";
	}
	if ($limitdatestatuschanges>20) {
		$sqllimit="$sqllimit and status_lastupdate>='$limitdatestatuschanges' ";
	}
	if ($limitdatestatuschangee>20) {
		$sqllimit="$sqllimit and status_lastupdate<='$limitdatestatuschangee' ";
	}

	if ($note!="") { $note=addslashes($note);
	$sqllimit="$sqllimit and note like '%$note%' ";
	}
	if ($adminnote!="") { $adminnote=addslashes($adminnote);
	$sqllimit="$sqllimit and adminnote like '%$adminnote%' ";
	}
	if ($siteoflib!="") {
	$sqllimit="$sqllimit and libsite='$siteoflib' ";
	}
	if ($mdtype!="") {
	$sqllimit="$sqllimit and RESOURCE_TYPE='$mdtype' ";
	}
	if ($itemplace!="" && $itemplace!="null") {
	$sqllimit="$sqllimit and place='$itemplace' ";
	}
?>