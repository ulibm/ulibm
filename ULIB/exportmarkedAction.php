<?php ;
include("inc/config.inc.php");

//////////////////// พ
if ($viewtype=="view")  {
}
if ($viewtype=="download")  {
header("Content-type: application/ms-download\n\n");
header("Content-Disposition: attachment; filename=\"ulibm-exported.txt\"\n"); 
   header("Pragma: no-cache");
   header("Expires: 0");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
}

$resstr="";
foreach ($_SESSION['marked'] as $value) {
	if ($exptype=="full") {
		 $tmp= html_displaymarc($value);
		 $tmp = str_replace(" bgcolor="," nobgcolor=",$tmp);
		 $tmp = str_replace(" border="," noborder=",$tmp);
		 $resstr.= $tmp;
		 $resstr.= "<BR>";
	}
	if ($exptype=="brieve") {
		 $tmp = html_displaymedia($value,false);
		 $tmp = str_replace(" bgcolor="," nobgcolor=",$tmp);
		 $tmp = str_replace(" border="," noborder=",$tmp);
		 $resstr.= $tmp;
		 $resstr.= "<BR>";
	}
	if ($exptype=="shorted") {
		 $resstr.=res_brief_dsp($value,false,false,false);	
		 $resstr.= "$newline<BR><BR>
";
	}	
	if ($exptype=="marc") {
		statordr_add("sharemarc","$value");
		stat_add("sharemarc_type","marked");
		$resstr.= marc_export($value);
	}
}
if ($viewtype!="email")  {
	echo $resstr;
} else {

	include("$dcrs"."inc/email/ini.php");
	if (!umail_chk($emailto)) {
		html_dialog("","Invalid Email [$emailto]");
	} else {
	umail_mail("$emailto","Bibliography records","$resstr");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("E-mail Sent.");
	history.go(-1);
	//-->
	</SCRIPT><?php 
	}
}

die;
echo "<HR>";
$str="7 a 4527n";
 for ($i=0;$i<strlen($str);$i++) {
	$c=substr($str,$i,1);
	echo "$c=[".ord($c)."]<BR>";
 }

?>