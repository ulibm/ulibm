<?php 

    ;

     include("../inc/config.inc.php");// พ
        loginchk_lib();

$calln=addslashes($calln);
$note=addslashes($note);
$now=time();
$adminnote=addslashes($adminnote);
$inumber=addslashes($inumber);
        $sql="update media_mid set tabean='$tabean',status='$status',libsite='$FLIBSITE',place='$itemplace' 
,bcode='$bcode',RESOURCE_TYPE='$RESOURCE_TYPE',inumber='$inumber' ,note='$note' ,calln='$calln', adminnote='$adminnote',status_lastupdate='$now' 
		,price='$price' where 
ID='$mid'";
   media_updatelastdt($mid,"item");

       //echo $sql;
	$now=time();
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$MID',
		edittype='update item bc=$bcode'		");

        echo tmq_error();
tmq($sql);
index_reindex($MID);
redir("media_type.php?MID=$MID&remotes_row=$remotes_row");
?>