<?php 
;
     include("../inc/config.inc.php"); 
loginchk_lib();
// พ
 if(!empty($ID))  
    {  
       
     $sql ="delete from media_mid where id='$ID'" ;  
    tmq($sql);
	redir("serial-items.php?USESMOD=$USESMOD&MID=$MID&MIDpage=$MIDpage");

	$now=time();
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$MID',
		edittype='delete item id=$ID barcode=$barcodeforlog'		");
}
?> 