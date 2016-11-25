<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("sessionbrowser");
if ($destroyid!="") {
	$destroyid=str_remspecialsign($destroyid);
	tmq("delete from sessionval where sessionid='$destroyid' ");
	html_dialog("warning","Destroyed $destroyid");
	//session_start();
	//ulibses_destroy($destroyid);
	//echo("$sess_save_path/sess_$destroyid");
	@unlink("$sess_save_path/sess_$destroyid");
}

if ($TRUNCTSESSION=="yes") {
	tmq("delete from sessionval where 1 ");
	html_dialog("warning","Destroyed ALL");
	foreach (glob("$sess_save_path/sess_*") as $filename) {
			//echo ($filename);
			@unlink($filename);
	}
}


$tbname="sessionval";

$c[2][text]="Word1::l::Word1";
$c[2][field]="word1";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="off";

/*$c[3][text]="Usoundex::l::Usoundex";
$c[3][field]="usoundex";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";
*/

/*$c[4][text]="Mid::l::Mid";
$c[4][field]="mid";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="-1";
*/

/*$c[5][text]="Importdt::l::Importdt";
$c[5][field]="importdt";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="0";

$c[6][text]="Importid::l::Importid";
$c[6][field]="importid";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";
*/
//dsp


$dsp[2][text]="Session ID";
$dsp[2][field]="sessionid";
$dsp[2][width]="30%";

$dsp[3][text]="Last Access";
$dsp[3][field]="dt";
$dsp[3][filter]="datetime";
$dsp[3][width]="30%";

$dsp[4][text]="Last IP";
$dsp[4][field]="ipset";
$dsp[4][width]="15%";


$dsp[5][text]="destroy";
$dsp[5][field]="id";
$dsp[5][align]="center";
$dsp[5][filter]="module:local_destroy";
$dsp[5][width]="15%";

$dsp[6][text]="SessInfo";
$dsp[6][field]="descr";
$dsp[6][filter]="module:local_descr";
$dsp[6][width]="16%";

function local_descr($wh) {
	$wh[descr]=str_replace(',','<BR>',$wh[descr]);
	return "<FONT class=smaller2>$wh[descr]</FONT>";
}

function local_destroy($wh) {
	global $startrow;
	if ($wh[sessionid]==session_id()) {
		return "you, ";
	}

	$s.="<A HREF='index.php?destroyid=$wh[sessionid]&startrow=$startrow' style='color:darkred'>Destroy</A>";

	return $s;
}

$o[addlink][] = "index.php?startrow=$startrow::Refresh::";
$o[addlink][] = "index.php?TRUNCTSESSION=yes::<FONT COLOR=darkred>Destroy All Session</FONT>::";

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c," length(descr) desc, dt desc ",$o,"distinct sessionid,dt,ipset,descr",""," group by sessionid");

html_dialog("warning","Destroy command work only on session-controled by ULibM");

foot();
?>