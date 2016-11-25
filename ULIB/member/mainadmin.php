<?php 
    ;
	include ("../inc/config.inc.php");
	if ($_memid=="") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("ส่วนนี้เฉพาะสมาชิก กรุณาล็อกอิน");
		self.location='<?php  echo $dcrURL?>';
	//-->
	</SCRIPT><?php 
		redir($dcrURL);
	die;
	}
	head();
mn_web("webpage");
   //                 include ("menuadmin.php");


		//			echo "<BR>";

					$sql="select * from member where UserAdminID='$_memid'";
                    $result=tmq($sql);
                    if (!$result)
                        {
                        die ("SELECT มีข้อผิดพลาด" . tmq_error());
                        }
                    $row=tmq_fetch_array($result);
                    $UserAdminName=$row[UserAdminName];
                    $email=$row[email];
                    $LIBSITE=$row[libsite];
                    if (trim($LIBSITE)=="") {
                     $LIBSITE="main";
                    }
                    $descr=$row[descr];
                    $statusactive=$row[statusactive];
                    $address=$row[address];
                    $tel=$row[tel];
                    $lib=$row[library];
                    $prefi=$row[prefi];
                    $mdat=$row[dat];
                    $mmon=$row[mon];
                    $myea=$row[yea];
                    $mpic=$row[picture];
                    $membertype=$row[type];

echo str_webpagereplacer(stripslashes(barcodeval_get("webpage-o-memberloggedin")));
	
$tmp[personalinfo]="1";
$tmp[hist]="2";
$tmp[msglog]="3";
$tmp[ulibmconnect]="4";
$tmp[ulibecard]="6";
$tmp[ulibecard2]="6";
$tmp[brlane]="5";
$tmp[brlaneaction]="5";

$tmpsub[checkouthist]="1";
$tmpsub[favbook]="2";
$tmpsub[tagged]="3";
$tmpsub[bookcomment]="4";
$tmpsub[histsuggest]="1";

if ($mempagemode=="") {
	$mempagemode="personalinfo";
}
if ($mempagemode=="favbook") {
	$mempagemode="hist";
	$submempagemode="favbook";
}
//maintabs
$tabstr=$tmp[$mempagemode]."::g::".getlang("รายละเอียดส่วนตัว::l::Personal Info").",mainadmin.php?mempagemode=personalinfo&,,,$dcrURL"."neoimg/gicons/action/ic_accessibility_white_24dp.png";
$tabstr.="::".getlang("ประวัติ::l::History").",mainadmin.php?mempagemode=hist,,,$dcrURL"."neoimg/gicons/action/ic_history_white_24dp.png";
$tabstr.="::".getlang("ข้อความ::l::Message").",mainadmin.php?mempagemode=msglog,,,$dcrURL"."neoimg/gicons/action/ic_info_white_24dp.png";
if ( getval("_SETTING","useulibmconnect") == "yes" && barcodeval_get("activateulib-refcode")!="") {
		$tabstr.="::".getlang("เชื่อมโยงข้อมูลการล็อกอิน::l::Login Connect").",mainadmin.php?mempagemode=ulibmconnect,,,$dcrURL"."neoimg/gicons/action/ic_account_circle_white_24dp.png";
}
if ( barcodeval_get("brlane-isenable") == "yes") {
	$tabstr.="::".getlang(barcodeval_get("brlane-linktext")).",mainadmin.php?mempagemode=brlane,,,$dcrURL"."neoimg/gicons/av/ic_recent_actors_white_24dp.png";
}

if ( strtolower(barcodeval_get("ulibecard-isenable")) == "yes" ) {
		$tabstr.="::".getlang(barcodeval_get("ulibecard-systemname")).",mainadmin.php?mempagemode=ulibecard,,_top,$dcrURL"."neoimg/gicons/action/ic_credit_card_white_24dp.png";
}
if ( barcodeval_get("oss-o-isopen") == "yes" ) {
		$tabstr.="::".getlang("One Stop Service").",$dcrURL"."OSS/myrequest.php,,_top,$dcrURL"."neoimg/gicons/image/ic_center_focus_weak_white_24dp.png";
}

if (barcodeval_get("webpage-o-mem_menustyle")=="Classic") {
   html_xptab($tabstr);
} else {
   html_flattab($tabstr);
}
?>
<table border=0 cellspacing=0 cellpadding=0 align=center width="<?php echo $_TBWIDTH?>"><tr><td></td></tr></table>
<?php
// subtabs
if ($mempagemode=="hist") {
	if ($submempagemode=="") {
		$submempagemode="checkouthist";
	}
	$tabstr=$tmpsub[$submempagemode]."::g";
	$tabstr.="::".getlang("ประวัติการยืม::l::Checkout History").",mainadmin.php?mempagemode=hist&submempagemode=checkouthist";
	if ( barcodeval_get("webmenu_memfavbook-o-enable") == "yes") {
		$tabstr.="::".getlang("หนังสือเล่มโปรด::l::Favourite books").",mainadmin.php?mempagemode=hist&submempagemode=favbook";
	}
	if ( barcodeval_get("bibtag-o-enable") == "yes") {
		$tabstr.="::".getlang("หนักสือที่เคยแท็ก::l::Tagged Items").",mainadmin.php?mempagemode=hist&submempagemode=tagged";
	}
	if ( barcodeval_get("bookcomment_isenable") == "yes") {
		$tabstr.="::".getlang("หนังสือที่คอมเมนท์::l::Commented Items").",mainadmin.php?mempagemode=hist&submempagemode=bookcomment";
	}
	?><table cellpadding=0 cellspacing=0 border=0 align=center width=<?php  echo $_TBWIDTH?>>
	<tr>
		<td width=20 style="background-image: url(<?php  echo $dcrURL?>neoimg/mediatab/menug_hover_left.gif);background-position: right;">&nbsp;<?php  ?></td>
		<td width=220 style="background-image: url(<?php  echo $dcrURL?>neoimg/mediatab/menug_hover_right.gif);background-position: right;"><?php  echo getlang("คลิกดูประวัติ::l::Click to view history") ?> &gt;&gt;&gt;</td>
		<td style="width: 780px!important;;"><?php 
	html_xptab($tabstr,780);
	?></td>
	</tr>
	</table><?php 
}
$limitdatee+=(60*60*24);

if ($mempagemode=="personalinfo") {
	include("mainadmin.personalinfo.php");
}
if ($mempagemode=="ulibecard") {
	include("mainadmin.ulibecard.php");
}
if ($mempagemode=="ulibecard2") {
	include("mainadmin.ulibecard2.php");
}
if ($mempagemode=="brlane") {
	include("mainadmin.brlane.php");
}
if ($mempagemode=="msglog") {
	include("mainadmin.msglog.php");
}
if ($mempagemode=="brlaneaction") {
	include("mainadmin.brlaneaction.php");
}
if ($submempagemode=="checkouthist") {
	include("mainadmin.checkouthist.php");
}
if ($submempagemode=="favbook") {
	include("mainadmin.favbook.php");
}
if ($submempagemode=="tagged") {
	include("mainadmin.tagged.php");
}
if ($submempagemode=="bookcomment") {
	include("mainadmin.bookcomment.php");
}
if ($submempagemode=="histsuggest") {
	include("mainadmin.histsuggest.php");
}
if ($mempagemode=="ulibmconnect") {
	include("mainadmin.ulibmconnect.php");
}

			foot();
?>