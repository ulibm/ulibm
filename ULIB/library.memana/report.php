<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
	//pagesection(getlang("ดึงข้อมูลผู้ใช้::l::Re generate data"));
$_TBWIDTH="100%";
$tbname="memana";


//dsp




$dsp[2][text]="สมาชิก::l::Member";
$dsp[2][field]="id";
$dsp[2][filter]="module:localmem";
$dsp[2][width]="20%";
function localmem($wh) {
	return get_member_name($wh[memid]);
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

$dsp[5][text]="ค่าปรับ::l::Fines";
$dsp[5][field]="id";
$dsp[5][filter]="module:localfine";
$dsp[5][width]="20%";
function localfine($wh) {
	$s="";
	$s=number_format($wh[finecount]).getlang(" รายการ::l::records")."<br>".number_format($wh[fineamount],2)."฿ ";
	return $s;
}

$dsp[4][text]="กิจกรรม::l::Activity";
$dsp[4][field]="id";
$dsp[4][filter]="module:localact";
$dsp[4][width]="30%";
function localact($wh) {
	$s="";
	$s="Web ".number_format($wh[webactivity]).getlang(" ครั้ง::l::records")."<br>".getlang("ทางเข้า ::l::Entrance ").number_format($wh[mscount])." ".getlang(" ครั้ง::l::records");
	$md=unserialize($wh[mediatype]);
	//printr($md);
	@reset($md);
	$s.="<br>Resource Type: ";
	while (list($k,$v)=each($md)) {
		$s.=" ".get_media_type($k).": ".$v."; ";
	}
	return $s;
}
$ordrdb=Array();
$ordrdb[neveruse][name]=getlang("ผู้ไม่เคยยืมออก::l::No Checkout");
$ordrdb[neveruse][limit]=" webactivity desc";
$ordrdb[checkoutcount][name]=getlang("จำนวนการยืมออก::l::Checkout count");
$ordrdb[checkoutcount][limit]=" checkoutcount desc";
$ordrdb[checkoutperiod][name]=getlang("จำนวนวันต่อการยืมออก::l::Checkout period count");
$ordrdb[checkoutperiod][limit]=" (checkoutperiod/checkoutcount) desc ";
$ordrdb[finecount][name]=getlang("จำนวนครั้งที่มีค่าปรับ::l::Fine Records");
$ordrdb[finecount][limit]=" finecount desc";
$ordrdb[fineamount][name]=getlang("จำนวนค่าปรับรวม::l::Fine Amount");
$ordrdb[fineamount][limit]=" fineamount desc";
$ordrdb[webactivity][name]=getlang("Web activity");
$ordrdb[webactivity][limit]=" webactivity desc";
$ordrdb[mscount][name]=getlang("จำนวนครั้งการเข้าประตู::l::Entrance log");
$ordrdb[mscount][limit]=" mscount desc";
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