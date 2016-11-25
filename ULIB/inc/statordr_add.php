<?php  // พ
function statordr_add($tbl,$id) {
	global $_STATUID;
	if ( $_STATUID=="") {  $_STATUID=randid(); }
	stat_statuid($_STATUID);

$tbl=addslashes($tbl);
$id=addslashes($id);

 $tbl="statordr_$tbl";
 
 $now=time();
 $yea=date("Y");
 $mon=date("m");

 $c=tmq("select id from $tbl where head='$id' and yea='$yea' and mon='$mon'  ");
  if (tmq_num_rows($c)==0) {
 		tmq("insert into $tbl set 
			 head='$id' ,
			  cc=1 ,
			 statuid='$_STATUID' ,
			  yea=$yea ,
			  mon=$mon ,
				lastdt='$now' 
		");
 } else {
   $c=tmq_fetch_array($c);
  	tmq("update $tbl set 
  			  cc=cc+1 ,
  				 lastdt='$now' ,
				 statuid='$_STATUID' ,
  				  yea='$yea' ,
				  mon='$mon'
					  where id='$c[id]'
  		");
 }
}
?>