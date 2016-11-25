<?php  //พ
include("../inc/config.inc.php");
html_start();
include("../library.oss/inc.php");


$tbname="oss_req";



//dsp

$dsp[4][text]="Date / Time";
$dsp[4][field]="dt";
$dsp[4][filter]="module:localdt";
$dsp[4][width]="15%";
function localdt($wh) {
	return ymd_datestr($wh[dt],"datetime");//."<br>".ymd_ago($wh[dt]);
}


$dsp[2][text]="Title : Information";
$dsp[2][field]="mat_info";
$dsp[2][filter]="module:local_mat_info";
$dsp[2][width]="40%";

function local_mat_info($wh) {
	$wh[mat_info]=str_replace("Title:","Title:<font  color=blue>",$wh[mat_info]);
	$wh[mat_info]=str_replace("Author:","</font>Author:",$wh[mat_info]);

	$wh[mat_info]=str_replace("Title:","<font  color=darkblue>Title:</font>",$wh[mat_info]);
	$wh[mat_info]=str_replace("Detail:","<font  color=darkblue>Detail:</font>",$wh[mat_info]);
	$wh[mat_info]=str_replace("Author:","<font  color=darkblue>Author:</font>",$wh[mat_info]);
	$wh=dspmarc($wh[mat_info]);
	$wh="<div style='overflow: hidden; text-overflow: ellipsis; display:block;border:0px solid red;width:480px ; height: 57px;;' title=\"".addslashes(strip_tags($wh))."\">
	<nobr>
		$wh
		</nobr>
	</div>";
	return $wh;
}

$dsp[5][text]="Status";
$dsp[5][field]="ordr";
$dsp[5][align]="center";
$dsp[5][width]="10%";
$dsp[5][filter]="module:local_stat";

$dsp[3][text]="Requestor";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_name";
$dsp[3][width]="20%";
$dsp[3][align]="center";


function local_name($wh) {
	$res.=get_member_name($wh[cardid]);
	return $res;
}
//
function local_stat($wh) {
	$s="";
	global $statusdb;//printr($statusdb);
	if ($wh[stat]=="waitpayment") {
		$s.= "<font color=red>";
		$s.= $statusdb[$wh[stat]];
	} elseif ($wh[stat]=="new") {
		$s.= "<img src=new.gif border=0><br><font color=darkgreen>";
		//$s.= $statusdb[$wh[stat]];
	} else {
		$s.= $statusdb[$wh[stat]];
	}
	return "$s";//.$wh[stat];
}


$limit=" 1 ";
$kw=trim($kw);
if ($kw!="") {
	$limit=" 1 and mat_info like '%$kw%'";
}
?>
<style>
div,font,td,span,b,a,i {
	font-size:14px;
}
</style>
<?php 
fixform_tablelister($tbname,$limit,$dsp,"no","no","no","kw=$kw",$c,"id desc");


//foot();
?>New = New request, waiting Librarian to operate<br>
Wait Payment = Wait requestor to complete payment to continue<br>
Wait Pickup = Material is ready for pickup<br>
Mat.Not found = Material requested is not available<br>
<br><br><br>
