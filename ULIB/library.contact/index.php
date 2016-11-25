<?php 
;
     include("../inc/config.inc.php");
	 head();
	 $_REQPERM="Contactinfomation";
	 mn_lib();
                 
         $tbname="contact";


$c[2][text]="Topic::l::Topic";
$c[2][field]="topic";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Body::l::Body";
$c[3][field]="body";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Email::l::Email";
$c[4][field]="email";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

//dsp

function localct($wh) {
	$s="";
	$s.="<TABLE width=100% class=table_border>
	<TR>
		<TD class=table_head width=30%>Topic</TD>
		<TD class=table_td>$wh[topic]</TD>
	</TR>
	<TR>
		<TD class=table_head>Email</TD>
		<TD class=table_td>$wh[email]</TD>
	</TR>
	<TR>
		<TD class=table_head>".getlang("เมื่อ::l::Time")."</TD>
		<TD class=table_td>".ymd_datestr($wh[dt])." (".ymd_ago($wh[dt]).")</TD>
	</TR>
	<TR>
		<TD class=table_td colspan=2>$wh[body]</TD>
	</TR>
	</TABLE>";
	tmq("update contact set isread='yes' where id='$wh[id]' ");
	return $s;
}

$dsp[2][text]="Contacts::l::Contacts";
$dsp[2][field]="topic";
$dsp[2][filter]="module:localct";
$dsp[2][width]="100%";


fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mi=$mi",$c," id desc ");
$tmpurl=$dcrURL."contact.php";
html_dialog("",getlang("ข้อมูลจาก <a target=_blank  href='$tmpurl'>$tmpurl</a>::l::records from  <a target=_blank href='$tmpurl'>$tmpurl</a>"));

foot();
?>