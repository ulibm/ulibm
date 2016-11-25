<?php 
    ;
	include ("../inc/config.inc.php");
	loginchk_lib();// พ

     $sql ="delete from acq_media where id='$ID'" ;  

    
tmq($sql);
redir("media_type.php");
?>