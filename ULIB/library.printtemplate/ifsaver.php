<?php 
include("../inc/config.inc.php");
$data=addslashes($data);
$managingID=floor($managingID);
tmq("update printtemplate_sub_i set 
pos='$data'
where id='$managingID'  ",true);// พ
?>