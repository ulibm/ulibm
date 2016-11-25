<?php  
;
include("../inc/config.inc.php");
loginchk_lib();// พ

     $sql ="insert into closeservice (dat,mon,yea,descr,libsite)";

     $sql.=" values ('$Fdat','$Fmon','$Fyea','$descr','$managing')";

       //echo $sql;
tmq($sql);
redir("closeservice.php?managing=$managing");

?>