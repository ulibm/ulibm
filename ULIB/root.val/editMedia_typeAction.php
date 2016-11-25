<?php 
    ;
    include ("../inc/config.inc.php");
    mn_root("val");
		
// พ

        include ("../inc/config.inc.php");
        $sql="update val set val='$name',descr='$descr' where id='$mid'";
				tmq($sql);
				redir("media_type.php",1);
				
?>