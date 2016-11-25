<?php  // พ
function stathist_add($tbl,$id,$det) {
	global $_STATUID;
	if ( $_STATUID=="") {  $_STATUID=randid(); }
	stat_statuid($_STATUID);

$tbl=addslashes($tbl);
$id=addslashes($id);
$det=addslashes($det);

 $tbl="stathist_$tbl";
 $dat=date("d");
 $mon=date("m");
 $yea=date("Y");
 $now=time();

 		tmq("insert into $tbl set 
		dat='$dat' ,
		 mon='$mon' ,
		  yea='$yea' ,
			 statuid='$_STATUID' ,
			 head='$id' ,
			 foot='$det' ,
			 dt='$now' 
		");
}
?>