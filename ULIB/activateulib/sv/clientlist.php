<?php  //พ
include("../../inc/config.inc.php");
include("./_conf.php");
head();
        mn_root("activateulib");
$tbname="ulibsv";


$c[2][text]="Orgname_thai::l::Orgname_thai";
$c[2][field]="orgname_thai";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Orgname_eng::l::Orgname_eng";
$c[3][field]="orgname_eng";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Url::l::Url";
$c[4][field]="url";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Address::l::Address";
$c[5][field]="address";
$c[5][fieldtype]="longtext";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="Refcode::l::Refcode";
$c[6][field]="refcode";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="Refordr::l::Refordr";
$c[7][field]="refordr";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="";

$c[8][text]="Contact::l::Contact";
$c[8][field]="contact";
$c[8][fieldtype]="text";
$c[8][descr]="";
$c[8][defval]="";

$c[9][text]="Dt::l::Dt";
$c[9][field]="dt";
$c[9][fieldtype]="date";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="Alwayson::l::Alwayson";
$c[10][field]="alwayson";
$c[10][fieldtype]="list:no,yes";
$c[10][descr]="";
$c[10][defval]="";

$c[11][text]="Ishide::l::Ishide";
$c[11][field]="ishide";
$c[11][fieldtype]="list:no,yes";
$c[11][descr]="";
$c[11][defval]="no";

$c[12][text]="Isallowed::l::Isallowed";
$c[12][field]="isallowed";
$c[12][fieldtype]="list:no,yes";
$c[12][descr]="";
$c[12][defval]="no";

$c[14][text]="is data mine::l::is data mine";
$c[14][field]="ismine";
$c[14][fieldtype]="list:no,yes";
$c[14][descr]="";
$c[14][defval]="no";

$c[15][text]="is a miner::l::is a miner";
$c[15][field]="iscanminer";
$c[15][fieldtype]="list:no,yes";
$c[15][descr]="";
$c[15][defval]="no";

$c[16][text]="is on usis::l::is on usis";
$c[16][field]="isonusis";
$c[16][fieldtype]="list:no,yes";
$c[16][descr]="";
$c[16][defval]="no";

//dsp

$dsp[3][text]="Orgname_eng::l::Orgname_eng";
$dsp[3][field]="orgname_eng";
$dsp[3][filter]="module:local_dsp";
$dsp[3][width]="30%";
function local_dsp($wh) {
	return $wh[orgname_eng]."<BR>&nbsp;&nbsp;&nbsp;<A HREF='$wh[url]root.backup/index.php?command=viewinfo' target=_blank>Backup Info</A>";
}
/*
$dsp[4][text]="Url::l::Url";
$dsp[4][field]="url";
$dsp[4][width]="30%";
*/
$dsp[6][text]="Refcode::l::Refcode";
$dsp[6][field]="refcode";
$dsp[6][width]="30%";

$dsp[7][text]="Refordr::l::Refordr";
$dsp[7][field]="refordr";
$dsp[7][width]="30%";



$dsp[10][text]="Alwayson::l::Alwayson";
$dsp[10][field]="alwayson";
$dsp[10][filter]="switchsingle";
$dsp[10][width]="30%";


$dsp[12][text]="Isallowed::l::Isallowed";
$dsp[12][field]="isallowed";
$dsp[12][filter]="switchsingle";
$dsp[12][width]="30%";

$dsp[14][text]="ismine::l::ismine";
$dsp[14][field]="ismine";
$dsp[14][filter]="switchsingle";
$dsp[14][width]="30%";

$dsp[15][text]="is a miner::l::is a miner";
$dsp[15][field]="iscanminer";
$dsp[15][filter]="switchsingle";
$dsp[15][width]="30%";

$dsp[16][text]="is on usis::l::is on usis";
$dsp[16][field]="isonusis";
$dsp[16][filter]="switchsingle";
$dsp[16][width]="30%";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);
?>
<TABLE width=780 align=center>
<TR>
	<TD style='color:fefefe'>$dcrURL/root.backup/?command=remotebackup<BR>
	$dcrURL/root.backup/?command=viewinfo</TD>
</TR>
</TABLE>


<?php 
foot();
?>