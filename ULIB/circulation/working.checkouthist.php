<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

	//localloadmember($memberbarcode,"yes");
	pagesection("ประวัติการยืม::l::Checkout History");
//$tbname="stathist_checkout_member_media ";
$tbname="checkout_log ";


//dsp


$dsp[3][text]="วัสดุสารสนเทศ::l::Material";
$dsp[3][field]="foot";
$dsp[3][filter]="module:localmedia";
$dsp[3][width]="70%";
function localmedia($wh) {
    global $dcrURL;
		$pid=tmq("select * from media_mid where bcode='$wh[mediaId]' ",false);
		if (tmq_num_rows($pid)==0) {
			 return getlang("ไม่พบวัสดุสารสนเทศ รายการอาจถูกลบไปแล้ว::l::Material not found, deleted?")." <FONT class=smaller2>($wh[mediaId])</FONT>";
		}
		$pid=tmq_fetch_array($pid);
		$wh="<a href='$dcrURL/dublin.php?ID=$pid[pid]&item=$wh[foot]' target=_blank>".marc_gettitle($pid[pid])."</a> <FONT class=smaller2>($wh[mediaId])</FONT>";
		return $wh;
}


$dsp[7][text]="วันที่ยืม::l::Checkout date";
$dsp[7][field]="dt";
$dsp[7][filter]="module:localdt";
$dsp[7][width]="30%";
function localdt($wh) {
	$s.=ymd_datestr(ymd_mkdt($wh[sdat],$wh[smon],$wh[syea]-543),"date")."<br>";
	//printr($wh);
	$orig=tmq("select * from checkout_logorig where idorig='$wh[idorig]' ");
	if (tnr($orig)!=0) {
	  $orig=tfa($orig);
	  $s.=getlang("กำหนดส่ง  ::l::Due date ").ymd_datestr(ymd_mkdt($orig[edat],$orig[emon],$orig[eyea]-543),"date")."<BR>";
	}
	$stmp.=getlang("ส่งคืนเมื่อ  ::l::returned ") 
		.ymd_datestr(ymd_mkdt($wh[edat],$wh[emon],$wh[eyea]-543),"date")."<br>";
	$tmp=ddx($wh[sdat],$wh[smon],$wh[syea]-543,$wh[edat],$wh[emon],$wh[eyea]-543);
	//echo $tmp;
	if(floor($tmp)==0) {
      $s.=" $stmp คืนวันเดียวกัน ";
	} else {
	  $s.=$stmp." $tmp ".getlang("วัน::l::days");;
      
	}
   //$s.="<BR>". ymd_datestr($wh[edt]);
	return $s;
}


$_TBWIDTH="100%";

fixform_tablelister($tbname," hold='$memberbarcode' ",$dsp,"no","no","no","memberbarcode=$memberbarcode",$c," edt desc ");




?><a href="working.checkouthistd.php?memberbarcode=<?php echo $memberbarcode?>" class="smaller a_btn">Detailed</a>