<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
$tmp=mn_lib();
pagesection($tmp);

$tbname="oai_repo";

$deletedata=floor($deletedata);
if ($deletedata!=0) {
   $deletedatas=tmq("select * from oai_repo where id='$deletedata' ");
   $deletedatas=tfa($deletedatas);
	tmq("delete from oai_repo_i where code='$deletedatas[code]' ");
	tmq("delete from index_db where remoteindex='oai-$deletedatas[code]' ");
}

$c[1][text]="ชื่อแหล่งข้อมูล::l::Repository name";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[5][text]="หมวดหมู่::l::Category";
$c[5][field]="cate";
$c[5][fieldtype]="foreign:-localdb-,oai_repocate,code,name";
$c[5][descr]="";
$c[5][defval]="";

$c[3][text]="Identify Code";
$c[3][field]="code";
$c[3][fieldtype]="text";
$c[3][descr]="*";
$c[3][defval]="";

$c[2][text]="URL";
$c[2][field]="url";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[4][text]="เปิดใช้งาน::l::is active";
$c[4][field]="isactive";
$c[4][fieldtype]="list:yes,no";
$c[4][descr]="";
$c[4][defval]="yes";

//dsp

$dsp[20][text]="-";
$dsp[20][field]="name";
$dsp[20][filter]="module:local_upload";
$dsp[20][width]="5%";

function local_upload($wh) {
	global $dcrs;
	global $dcrURL;
	$s="<A HREF='upload.php?oaiimgmanage=$wh[code]'><img border=0 width=48 height=48 src='";
	if (file_exists("$dcrs/_tmp/oaiimg/$wh[code].png")==true) {
		$s.= "$dcrURL/_tmp/oaiimg/$wh[code].png";
	} else {
		$s.=  "$dcrURL/_tmp/oaiimg/default.png";
	}
	$s.="'></A>";
	return $s;
	//
}

$dsp[2][text]="ชื่อแหล่งข้อมูล::l::Repository name";
$dsp[2][field]="name";
$dsp[2][filter]="module:localdsp";
$dsp[2][width]="50%";
$catedb=tmq_dump2("oai_repocate","code","name");

function localdsp($w) {
	$s="";
	global $catedb;
	global $dcrURL;
	//printr($w);
	$c=tmq("select count(id) as cc from oai_repo_i where code='$w[code]' ");
	$c=tfa($c);
	$cn=number_format($c[cc]);
	$s.="$w[name] <br>
	<font class=smaller> $cn :(".$catedb[$w[cate]].") $w[url]</font><br>
	<a href=\"run.php?repid=$w[id]\" class='a_btn' target=_blank>Get Identifier</a>
	<a href=\"fetch.php?repid=$w[id]\" class='a_btn' target=_blank>Fetch Record data</a>
	<a href=\"index.php?deletedata=$w[id]\" class='a_btn smaller2' style='color:darkred;' onclick=\"return confirm('delete all fetched data?');\">Delete Record data</a>
	
	<a href='javascript:void(null);' onclick=\"prompt('URL for cronjob ping','$dcrURL"."urlwalker.php?url=".urlencode($dcrURL."library.oai/run.php?repid=$w[id]")."');\"><img border=0 src='$dcrURL"."neoimg/cron.jpg'></a>
	";

	return $s;
}
/*
$dsp[3][text]="URL";
$dsp[3][field]="url";
$dsp[3][width]="30%";*/

/*
$dsp[5][text]="เปิดใช้งาน::l::is active";
$dsp[5][field]="isactive";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="10%";

$o[undelete][field]="type";
$o[undelete][value]="onlineregist";
$o[undeletearr][type]="temp";
//$o[unedit][field]="type";
//$o[unedit][value]="onlineregist";
*/
$o[addlink][] = "category.php::".getlang("จัดการหมวดหมู่::l::Manage category")."::";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>