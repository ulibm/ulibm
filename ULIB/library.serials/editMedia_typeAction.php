<?php  //พ

    ;

     include("../inc/config.inc.php");
        loginchk_lib();

$now=time();
$calln=addslashes($calln);
        $sql="update media_mid set tabean='$tabean',
				status='$status',
				libsite='$FLIBSITE',
				place='$itemplace',
				bcode='$bcode',
RESOURCE_TYPE='$RESOURCE_TYPE',
inumber='$inumber' ,
status_lastupdate='$now' ,
note='$note' 
		,price='$price' 
		,calln='$vcalln' ,
		
	jenum_1='$vjenum_1' ,
	jenum_2='$vjenum_2' ,
	jenum_3='$vjenum_3' ,
	jenum_4='$vjenum_4' ,
	jenum_5='$vjenum_5' ,
	jenum_6='$vjenum_6' ,
	jchrono_1='$jchrono_1' ,
	jchrono_2='$jchrono_2' ,
	jchrono_3='$jchrono_3' ,
	jnonpublicnote='$jnonpublicnote' ,
	javaistatusnote='$javaistatusnote' ,
	jpublicnote='$jpublicnote'
		
		
		where 
ID='$IDEDIT'";

	$now=time();
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$MID',
		edittype='update item bc=$bcode'		");
       //echo $sql;die;

        echo tmq_error();
        
//man attatchec s
   $sql2="select * from media_mid where ID='$IDEDIT'";
   $row=tmq($sql2);
   $row=tfa($row);
	$oldkeyid="SERIAL-$row[pid]-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[calln]";
	$newkeyid="SERIAL-$row[pid]-attatch-$jenum_1-$jenum_2-$jenum_3-$jenum_4-$jenum_5-$jenum_6-$vcalln";
	globalupload_changekeyid($oldkeyid,$newkeyid);
	//tmq("update globalupload set keyid='$newkeyid' where keyid='$oldkeyid' ",true);
//man attatchec e

tmq($sql,false);


if ($framemode=="yes") {
	redir("itemlist.php?MID=$MID&jenum_1=$jenum_1&jenum_2=$jenum_2&jenum_3=$jenum_3&jenum_4=$jenum_4&jenum_5=$jenum_5&jenum_6=$jenum_6&calln=".urlencode($calln));
} elseif ($editboxinfo=="yes") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location=top.location
	//-->
	</SCRIPT><?php 
} else {
	redir("serial-items.php?USESMOD=$USESMOD&MID=$MID&MIDpage=$MIDpage");
}
?>