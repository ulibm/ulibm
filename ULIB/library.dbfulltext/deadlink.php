<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 $_REQPERM="dbfulltext-deadlink";
	 mn_lib();
if ($clearid!='') {
	tmq("update media_ftitems set errorcount=0 where id='$clearid' ");
}

	 pagesection(getlang("แสดงลิงค์เสียทั้งหมด::l::View all dead link"));

 //dsp


$dsp[3][text]="Material - Filename/URL";
$dsp[3][field]="filename";
$dsp[3][filter]="module:locallinkoutbtn";
$dsp[3][width]="35%";

$dsp[4][text]="Contenttype";
$dsp[4][field]="fttype";
$dsp[4][filter]="foreign:-localdb-,media_fttype,code,name";
$dsp[4][width]="15%";



$dsp[5][text]="Text::l::Text";
$dsp[5][field]="text";
$dsp[5][width]="20%";
	
$o[addlink][] = "menu.php::".getlang("กลับ::l::Back")."::_self";

$o[undelete][field]="uploadtype";
$o[undelete][value]="upload";
//$o[unedit][field]="uploadtype";
//$o[unedit][value]="upload";

function locallinkoutbtn($wh) {
	global $dcrURL;
	//printr($wh);
	if (mb_strlen($wh[filename])>20) {
		$add='..';
	}
	$tt=marc_gettitle($wh[mid]);
	if (mb_strlen($tt)>30) {
		$tt=mb_substr($tt,0,30)."..";
	}

	 return"<A HREF='$dcrURL"."dublin.php?ID=$wh[mid]' target=_blank>$tt</A><BR>&nbsp;&nbsp;<a href=\"$dcrURL/_fulltext/$wh[fttype]/$wh[mid]/$wh[filename]\" target=_blank>".mb_substr($wh[filename],0,20)."$add</a> Error=<B style='color:darkred'>$wh[errorcount]</B> <A HREF='deadlink.php?startrow=$startrow&clearid=$wh[id]' class='smaller a_btn'>Clear</A>";
}

$tbname="media_ftitems";

fixform_tablelister($tbname," uploadtype='url' and errorcount>0 ",$dsp,"no","no","yes","FTCODE=$FTCODE&mid=$mid",$c,"errorcount desc",$o);
	 
	 foot();
?>