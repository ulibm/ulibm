<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

	//localloadmember($memberbarcode,"yes");
	pagesection("ประวัติการยืม (การบันทึกการยืม)::l::Checkout History (Checkout log)");
//$tbname="stathist_checkout_member_media ";
$tbname="stathist_checkout_member_media ";


//dsp


$dsp[3][text]="วัสดุสารสนเทศ::l::Material";
$dsp[3][field]="foot";
$dsp[3][filter]="module:localmedia";
$dsp[3][width]="70%";
function localmedia($wh) {
    global $dcrURL;
		$pid=tmq("select * from media_mid where bcode='$wh[foot]' ",false);
		if (tmq_num_rows($pid)==0) {
			 return getlang("ไม่พบวัสดุสารสนเทศ รายการอาจถูกลบไปแล้ว::l::Material not found, deleted?")." <FONT class=smaller2>($wh[mediaId])</FONT>";
		}
		$pid=tmq_fetch_array($pid);
		//printr($wh);
		$f=tmq("select * from stathist_checkout_media_librarian where statuid='$wh[statuid]' ");
		if (tnr($f)==0) {
		 $fstr=" - ";
		} else {
		 $ff=tfa($f);
		 $fstr=$ff[foot];
		}
		//printr($f);
		$wh="<a href='$dcrURL/dublin.php?ID=$pid[pid]&item=$wh[foot]' target=_blank>".marc_gettitle($pid[pid])."</a> <FONT class=smaller2>($wh[foot] by $fstr)</FONT>";
		// fetch statuid

		return $wh;
}


$dsp[7][text]="วันที่ยืม::l::Checkout date";
$dsp[7][field]="dt";
$dsp[7][filter]="module:localdt";
$dsp[7][width]="30%";
function localdt($wh) {
	$s.=ymd_datestr($wh[dt])."<br>";
	
	//$stmp.=getlang("ถึง ::l::to ") 
		//.ymd_datestr(ymd_mkdt($wh[edat],$wh[emon],$wh[eyea]-543),"date")."<br>";
	/*$tmp=ddx($wh[sdat],$wh[smon],$wh[syea]-543,$wh[edat],$wh[emon],$wh[eyea]-543);
	if(floor($tmp)==0) {
      $s.=" - ";
	} else {
	  $s.=$stmp." $tmp ".getlang("วัน::l::days");;
      
	}*/

	return $s;
}


$_TBWIDTH="100%";

fixform_tablelister($tbname," head='$memberbarcode' ",$dsp,"no","no","no","memberbarcode=$memberbarcode",$c," dt desc ");




?><a href="working.checkouthist.php?memberbarcode=<?php echo $memberbarcode?>"  class="smaller a_btn">Normal</a>