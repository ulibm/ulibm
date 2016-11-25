<?php 
;
     include("../inc/config.inc.php");
	 html_start();
	 loginchk_lib();
	 
	 $tbname="checkout";

	 if ($cancel!="") {
	 		$cancel=floor($cancel);
			tmq("delete from checkout where id='$cancel' and request<>'' ");
	 }

//dsp


$dsp[6][text]="ข้อมูล::l::More Info.";
$dsp[6][field]="sdat";
$dsp[6][filter]="module:localinfo";
$dsp[6][width]="30%";

$dsp[2][text]="ชื่อวัสดุ::l::Media Name";
$dsp[2][field]="mediaId";
$dsp[2][filter]="module:localmedianame";
$dsp[2][width]="25%";

$dsp[3][text]="ผู้ยืม::l::Holder";
$dsp[3][field]="hold";
$dsp[3][filter]="memberbarcode";
$dsp[3][width]="20%";

$dsp[4][text]="ผู้จอง::l::Requester";
$dsp[4][field]="request";
$dsp[4][filter]="module:localmemberbarcode";
$dsp[4][width]="20%";

function localmemberbarcode($wh) {
	return get_member_name($wh[request]);
}


$dsp[12][text]="คืนแล้ว::l::Returned";
$dsp[12][field]="returned";
$dsp[12][filter]="yesno";
$dsp[12][width]="10%";



$dsp[19][text]="สาขา::l::Campus";
$dsp[19][field]="libsite";
$dsp[19][filter]="foreign:-localdb-,library_site,code,name";
$dsp[19][width]="30%";

function localmedianame($wh) {
  global $dcrURL;
	$res="<a href='$dcrURL/dublin.php?ID=$wh[pid]&item=$wh[mediaId]' target=_blank><b>$wh[mediaName]</b></a> [bc=$wh[mediaId]]<BR>";
if ($wh[edt]!=0) {	
   $res.="<font class=smaller2>".getlang("คืนเมื่อ::l::Return date").":".ymd_datestr($wh[edt],"shortd")."</font>";

$ts1 = $wh[edt];
$ts2 = time();

$seconds_diff = $ts2 - $ts1;

$daydiff= floor($seconds_diff/3600/24);
//echo "[$daydiff]";

   if ($daydiff>=getval("config","timetowarnlongholdrequest")) {
      $res.="<font class=smaller2 style='font-weight: bold; color:red;'>";
   } else {
      $res.="<font class=smaller2>";
   }
	$res.="<BR> (".ymd_ago($wh[edt]).")</font>";
}
	return $res;
}


function localinfo($wh) {
global $thaimonstr;
//printr($wh);
  global $cfrm;
  global $LIBSITE;
  global $filter;
  $s="";
	$s.= "<b>".getlang("วันยืม::l::Due date")."</b> $wh[sdat] ".$thaimonstr[$wh[smon]] . " $wh[syea]<br />";
		$s.= "<b>".getlang("วันส่ง::l::return date")."</b> $wh[edat] ".$thaimonstr[$wh[emon]] . " $wh[eyea]";
		if (floor($wh[renewcount])>0) {
   		$membertype=tmq("select * from member where UserAdminID='$wh[hold]' ");
   		$membertype=tfa($membertype);		
			$maxrenew=tmq("select * from checkout_rule where member_type='$membertype[type]' and media_type='$wh[RESOURCE_TYPE]'   and libsite='$LIBSITE'  ");
   		$maxrenew=tfa($maxrenew);

			 $s.=" (<u>Renewed $wh[renewcount]/".$maxrenew[renew]."</u>)";
		}
		$s.= "<br><b>".getlang("ประเภทวัสดุ::l::Resource type")."</b> ";
		$s.=get_media_type($wh[RESOURCE_TYPE]);
		$s.="<br /><nobr>";
		if ($wh[returned]=='yes') {
			 $s.= "		[<a href='main.checkout.php?memberbarcode=$wh[request]&mediabarcode=$wh[mediaId]' target=main>".getlang("ให้ยืม::l::Checkout")."</a>]";
		} else {
			$s.= " [".getlang("ให้ยืม::l::Checkout")."] ";
		} 
		$s.= "		[<a href='working.rq.php?filter=$filter&cancel=$wh[id]' onclick=\"return confirm('$cfrm')\">".getlang("ยกเลิก::l::Cancel")."</a>] 
		[<a href='working.rq.print.php?rqid=$wh[id]' target=_blank>".getlang("พิมพ์ใบจอง::l::Print req. slip")."</a>]
		</nobr> 
";
	return $s;
}

$limit="  request<>'' ";
if ($filter=="yes") {
	 $limit.=" and returned='yes' ";
}
$_TBWIDTH="100%";
fixform_tablelister($tbname,"$limit ",$dsp,"no","no","no","filter=$filter",$c);

?>