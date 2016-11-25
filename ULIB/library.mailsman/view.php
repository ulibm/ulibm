<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="mailsman";
mn_lib();
$tbname="umail_que";

$c=Array();

//dsp


$dsp[3][text]="ส่งถึง::l::Mail to";
$dsp[3][field]="email";
$dsp[3][width]="20%";

$dsp[4][text]="Subject::l::Subject";
$dsp[4][field]="tagid";
$dsp[4][filter]="module:local_read";
$dsp[4][width]="50%";

function local_read($wh) {
	$s="<B class=smaller>$wh[mail_title]</B><BR>";
	$s.="".str_preformat($wh[mail_body]);;
	return "<FONT class=smaller2>$s</FONT>";
}

$dsp[5][text]="สถานะ::l::Status";
$dsp[5][field]="status";
$dsp[5][filter]="module:local_status";
$dsp[5][width]="10%";

function local_status($wh) {
	$s="<B class=smaller>$wh[status]</B><BR>";
	if ($wh[sent_dt]!=0) {
		$s.="".ymd_datestr($wh[sent_dt]);;
	}
	return "<FONT class=smaller2>$s</FONT>";

}

$o[addlink][] = "index.php::".getlang("กลับ::l::Back");;
?><BR><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td><B><?php  echo getlang("ชุดการส่ง::l::Set name");
	?></B> <?php 
	echo urldecode($setid);;
		$c=tmq("select * from umail_que where setid='$setid' ");
		$c=tmq_num_rows($c);
echo " (".number_format($c)." emails)";
	?></TD>
</TR>
</TABLE><?php 

fixform_tablelister($tbname," setid='$setid' ",$dsp,"no","no","yes","setid=$setid",$c," id ",$o);

foot();
?>