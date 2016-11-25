<?php  // พ
function stat_add($tbl,$id) {
	global $_STATUID;
	if ( $_STATUID=="") {  $_STATUID=randid(); }
	stat_statuid($_STATUID);

	$tbl=addslashes($tbl);
	$id=addslashes($id);

 $tbl="stat_$tbl";
 $dat=date("j");
 $mon=date("n");
 $yea=date("Y");
 
 $c=tmq("select id from $tbl where dat='$dat' and mon='$mon' and yea='$yea' and head='$id'  ",false);
 $now=time();
 if (tmq_num_rows($c)==0) {
 		tmq("insert into $tbl set 
		dat='$dat' ,
		 mon='$mon' ,
		  yea='$yea' ,
			 head='$id' ,
			 statuid='$_STATUID' ,
			  cc=1 ,
				 lastdt='$now' 
		",false);
 } else {
   $c=tmq_fetch_array($c);
  	tmq("update $tbl set 
  			  cc=cc+1 ,
			 statuid='$_STATUID' ,
  				 lastdt='$now' 
					 where id='$c[id]'
  		",false);
 }
  		tmq("insert into $tbl"."_log set 
		dat='$dat' ,
		 mon='$mon' ,
		  yea='$yea' ,
			 head='$id' ,
				 lastdt='$now' ,
				 statuid='$_STATUID' 
		",false);
}
?>