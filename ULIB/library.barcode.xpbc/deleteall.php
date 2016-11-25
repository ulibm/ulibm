<?php 
;

     include("../inc/config.inc.php"); // พ
include("_REQPERM.php");
mn_lib();
       
     $sql ="delete from xpbc " ;  
    tmq($sql);
	redir("media_type.php");
?> 