<?php 
    ;
	include ("../inc/config.inc.php");// พ
	loginchk_lib();

       

     $sql ="delete from acq_acq where id='$ID'" ;  

  tmq("delete from acq_mediasent where acq='$ID' ");
    
	 tmq($sql);
	 redir("media_type.php");
?>