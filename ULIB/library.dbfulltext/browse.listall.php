<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 include("_REQPERM.php");
	 mn_lib();

	 if ($FTCODE=="") {
	 		die("no FTCODE");
	 }

	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	$s= getlang($s[name]);

	 pagesection(getlang("Content ประเภท $s::l::Contents type '$s'"));

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

$dsp[6][text]="<font color=red>ลบ</font>::l::<font color=red>Del</font>";
$dsp[6][field]="id";
$dsp[6][align]="center";
$dsp[6][filter]="module:localdelbtn";
$dsp[6][width]="10%";


	
$o[addlink][] = "listall.php::".getlang("กลับ::l::Back")."::_self";

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
	if (mb_strlen($tt)>20) {
		$tt=mb_substr($tt,0,20)."..";
	}
   $tmpsourcefttype=$wh[fttype];
	 return"<A HREF='$dcrURL"."dublin.php?ID=$wh[mid]' target=_blank>$tt</A><BR>&nbsp;&nbsp;<a href=\"$dcrURL/_fulltext/$wh[fttype]/$wh[mid]/$wh[filename]\" target=_blank>".mb_substr($wh[filename],0,20)."$add</a>
	 ".html_photofilter("_fulltext/$tmpsourcefttype/$wh[mid]/$wh[filename]","",false);
}

function localdelbtn($wh) {
    global $FTCODE;
    global $mid;
    global $cfrm;
				if ($wh[uploadtype]=="upload") {
				 				 return "<a href='./mediacontent.php?deleteid=$wh[id]&FTCODE=$FTCODE&mid=$mid' onclick=\"return confirm('$cfrm')\">".getlang("ลบ::l::Del")."</a>";
				} else {
							  return "-";
				}
}
$tbname="media_ftitems";

fixform_tablelister($tbname,"1 ",$dsp,"no","no","yes","FTCODE=$FTCODE&mid=$mid",$c,"",$o);
	 
	 foot();
?>