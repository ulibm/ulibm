<?php  
;
     include("../inc/config.inc.php"); 
	 include("_REQPERM.php");// พ
	mn_lib();

       
     $sql ="delete from xpbcbook " ;  
    tmq($sql);
	redir("media_type.php");
?> 