<?php 
	; 
        include ("../inc/config.inc.php");
		$_REQPERM="webbox";
        include ("../inc/config.inc.php");
		/*if (barcodeval_get("webpage-indexphotonews_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}*/
		html_start();
		if (loginchk_lib("check")) {
			mn_lib();
		} 
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD><?php 
	pagesection($catenamedb[$cate],"article");
$tbname="webbox_photoframesingle";
$c=Array();


$c[3][text]="";
$c[3][field]="pid";
$c[3][fieldtype]="addcontrol";
$c[3][descr]="";
$c[3][defval]=$pid;

$c[8][text]="ชื่อภาพ::l::Title";
$c[8][field]="title";
$c[8][fieldtype]="text";
$c[8][descr]="";
$c[8][defval]="";

$c[7][text]="รูปภาพ::l::Photo";
$c[7][field]="photo";
$c[7][fieldtype]="singlefile";
$c[7][descr]=" ";
$c[7][defval]="";



///////////

$dsp[2][text]="รูปภาพ::l::Photo";
$dsp[2][field]="memid";
$dsp[2][filter]="module:local_display";
$dsp[2][align]="left";

function local_display($wh) {
	global $tbname;
	global $cate;
	$img=fft_upload_get($tbname,"photo",$wh[id]);
	//printr($img);
	$s="<img src='$img[url]' align=left width=100>";
	$wh[title]=trim($wh[title]);
	if ($wh[title]=="") {
		$wh[title]="<I>- no title -</I>";
	}
	$s.=" $wh[title]";
	return $s;
}


$o[tablewidth]="100%";

if ($fftmode=="delete") {
	@unlink("./attatch/$fftdeleteid-1.jpg");
	@unlink("./attatch/$fftdeleteid-2.jpg");
}
$addsql=" 1 "; 
if ($cate=="news") {
	$addsql=" 1 ";
}



$chkexist=tmq("select * from $tbname where pid='$pid' ");
if (tmq_num_rows($chkexist)==0) {
	tmq("insert into $tbname set pid='$pid'");
	$existid=tmq_insert_id();
}  else {
	$chkexist=tmq_fetch_array($chkexist);
	$existid=$chkexist[id];
}
$fftmode="edit";
$ffteditid=$existid;
	$permm="no";

$html_htmlarea_width=610;
fixform_tablelister($tbname," pid=$pid ",$dsp,"$permm","yes","$permm","pid=$pid",$c,"",$o);

	?></TD>
</TR>
</TABLE> <A HREF="javascript:void(null)" onclick="top.location.reload();"><CENTER><B><?php  echo getlang("กลับ::l::Back");?></B></CENTER></A>