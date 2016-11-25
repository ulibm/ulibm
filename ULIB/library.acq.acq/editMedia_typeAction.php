<?php 
    ;
	include ("../inc/config.inc.php");// พ
	loginchk_lib();

        $sql="update acq_acq 
	 set
company='$company',
status='$status',
note='$note'
		where id='$mid'";

        //         echo $sql;

	 tmq($sql);
	 redir("media_type.php");
			?>