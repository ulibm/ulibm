<?php 
    ;
	include ("../inc/config.inc.php");

	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);
	$s=tmq("select * from setreturndate where id='$ID' ");
	$s=tfa($s);
	html_dialog("Information","Librarian: ".get_library_name($s[loginid])." <br>Date: ".ymd_datestr($s[dt])." <br>Note: ".$s[note]);



$tbname="setreturndate_sub";



//dsp


$dsp[1][text]="Item Barcode";
$dsp[1][field]="bcode";
$dsp[1][width]="20%";

$dsp[3][text]="Member";
$dsp[3][field]="note";
$dsp[3][filter]="module:localmem";
$dsp[3][width]="20%";
function localmem($wh) {
	return get_member_name($wh[member]);
}

$dsp[2][text]="วันส่งดั้งเดิม::l::Original Due date";
$dsp[2][field]="dat";
$dsp[2][filter]="module:localorigdd";
$dsp[2][width]="20%";
function localorigdd($wh) {
	return "$wh[dat]/$wh[mon]/$wh[yea]";
}

fixform_tablelister($tbname," pid='$ID' ",$dsp,"no","no","no","mi=$mi",$c,"id desc",$o);
?><b><center><a href="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a></center></b><?php 
	foot();
?>