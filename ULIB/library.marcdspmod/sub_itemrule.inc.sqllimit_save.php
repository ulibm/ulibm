<?php // พ
$sqllimit="select distinct pid from media_mid where 1 $sqllimit";
	$s=tmq("$sqllimit",false);
	$idlist="";
	$i=0;
	while ($r=tfa($s)) {
		$idlist.=",".$r[pid];
		$i++;
	}
	$idlist=trim($idlist,",");
	tmq("update marcdspmod_itemrule set idlist='$idlist' where pid='$main' ");
?>