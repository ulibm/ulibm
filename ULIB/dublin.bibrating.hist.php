<?php  //พ
include("./inc/config.inc.php");
$_REQPERM="webmenu_bibrating-list";
head();
mn_lib();

include("./dublin.bibrating.inc.php");

$tbname="webpage_bibrating_log";
?><TABLE width=500 align=center>
<TR>
	<TD><?php 
			res_brief_dsp($ID);
?></TD>
</TR>
</TABLE><?php 

$c[2][text]="Bibid::l::Bibid";
$c[2][field]="bibid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$ID;

$c[3][text]="Member";
$c[3][field]="memid";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Score::l::Score";
$c[4][field]="score";
$c[4][fieldtype]="list:5,4,3,2,1";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Date";
$c[5][field]="dt";
$c[5][fieldtype]="date";
$c[5][descr]="";
$c[5][defval]="";

//dsp



$dsp[3][text]="Member";
$dsp[3][field]="memid";
$dsp[3][filter]="module:local_member";
$dsp[3][width]="30%";

$dsp[4][text]="Score::l::Score";
$dsp[4][field]="score";
$dsp[4][width]="30%";

$dsp[5][text]="Dt::l::Dt";
$dsp[5][filter]="datetime";
$dsp[5][field]="dt";
$dsp[5][width]="30%";

function local_member($wh) {
	return get_member_name($wh[memid]);
}

fixform_tablelister($tbname," bibid='$ID' ",$dsp,"yes","yes","yes","ID=$ID",$c);
	bibrating_recal($ID);

foot();
?>