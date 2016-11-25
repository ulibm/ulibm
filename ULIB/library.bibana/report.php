<?php 
	; 
		
        include ("../inc/config.inc.php");// พ
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
	//pagesection(getlang("ดึงข้อมูลผู้ใช้::l::Re generate data"));
$_TBWIDTH="100%";
$tbname="bibana";


//dsp




$dsp[2][text]="ทรัพยากร::l::Title";
$dsp[2][field]="id";
$dsp[2][filter]="module:localmem";
$dsp[2][width]="20%";
function localmem($wh) {
	global $dcrURL;
	return "<a href='$dcrURL"."dublin.php?ID=$wh[bibid]' target=_blank>".marc_gettitle($wh[bibid])."</a>";
}

$dsp[3][text]="Checkout";
$dsp[3][field]="id";
$dsp[3][filter]="module:localco";
$dsp[3][width]="20%";
function localco($wh) {
	if ($wh[checkoutcount]==0) {
		return "-";
	}
	$s="";
	$s=number_format($wh[checkoutcount]).getlang(" ครั้ง::l::checkout")."<br>".number_format($wh[checkoutperiod]/$wh[checkoutcount],2)." ".getlang("วัน/รายการ::l::day/item");
	return $s;
}

$dsp[5][text]="ใช้ในห้องสมุด::l::Use Inside Lib";
$dsp[5][field]="id";
$dsp[5][filter]="module:localinside";
$dsp[5][width]="20%";
function localinside($wh) {
	$s="";
	$s=number_format($wh[usedbook]).getlang(" ครั้ง::l::records");
	return $s;
}

$dsp[4][text]="กิจกรรม::l::Activity";
$dsp[4][field]="id";
$dsp[4][filter]="module:localact";
$dsp[4][width]="30%";
$membertypedb=tmq_dump("member_type","type","descr");
function localact($wh) {
	global $membertypedb;
	$s="";
	$s="Web ".number_format($wh[webactivity]).getlang(" ครั้ง::l::records")."";
	$md=unserialize($wh[membertype]);
	//printr($md);
	@reset($md);
	$s.="<br>Member Type: ";
	while (list($k,$v)=each($md)) {
		$s.=" ".getlang($membertypedb[$k]).": ".$v."; ";
	}
	return $s;
}
$ordrdb=Array();
$ordrdb[neveruse][name]=getlang("รายการไม่เคยถูกยืมออก::l::No Checkout");
$ordrdb[neveruse][limit]=" webactivity desc";
$ordrdb[checkoutcount][name]=getlang("จำนวนการยืมออก::l::Checkout count");
$ordrdb[checkoutcount][limit]=" checkoutcount desc";
$ordrdb[checkoutperiod][name]=getlang("จำนวนวันต่อการยืมออก::l::Checkout period count");
$ordrdb[checkoutperiod][limit]=" (checkoutperiod/checkoutcount) desc ";
$ordrdb[finecount][name]=getlang("การยืมใช้ในห้องสมุด::l::use inside lib");
$ordrdb[finecount][limit]=" usedbook desc";
$ordrdb[webactivity][name]=getlang("Web activity");
$ordrdb[webactivity][limit]=" webactivity desc";
echo getlang("เรียงลำดับตาม::l::Order by").":" ;
@reset($ordrdb);
if ($ordr=="") {
	$ordr="checkoutcount";
}
while (list($k,$v)=each($ordrdb)) {
	?><a href="<?php  echo $PHP_SELF?>?ordr=<?php  echo $k?>" class="smaller <?php 
	if ($k==$ordr) {
		echo "a_btn";
	}	
	?>"><?php  echo getlang($v[name]);?></a> <?php 
}

$limit=" 1 ";
if ($ordr=="neveruse") {
   $limit.=" and checkoutcount=0";
}
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mi=$mi&ordr=$ordr",$c," ".$ordrdb[$ordr][limit],$o);
?><center><b><a href="export.php" target=_blank><?php  echo getlang("ดาวน์โหลด CSV::l::Download CSV"); ?></a></b></center><?php 
?>