<?php 
    ;
	include ("../inc/config.inc.php");// พ
	loginchk_lib();

	$refcode=rand(10000,99999);
     

     $sql ="insert into acq_acq 
	 set
company='$company',
status='$status',
ymd='".time()."',
note='$note'
	 ";

	 tmq($sql);
	 redir("media_type.php");

?>