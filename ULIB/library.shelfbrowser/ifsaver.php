<?php 
include("../inc/config.inc.php");
$data=addslashes($data);
$managingID=floor($managingID);
tmq("update media_place_shelf set 
mappos2='$data'
where id='$managingID'  ",true);// พ
?>