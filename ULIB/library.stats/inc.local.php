<?php 
function local_getsdb_thestathist() {
	global $sdbs;

		$sdb["checkout_member_libsite"][name]=getlang($sdbs[name]);
		$sdb["checkout_member_libsite"][footmode]="libsite";
		$sdb["checkout_member_libsite"][headmode]="memberbarcode";
		$sdb["checkin_member_libsite"][name]=getlang($sdbs[name]);
		$sdb["checkin_member_libsite"][footmode]="libsite";
		$sdb["checkin_member_libsite"][headmode]="memberbarcode";
		$sdb["librarian_login_ip"][name]=getlang($sdbs[name]);
		$sdb["librarian_login_ip"][footmode]="librarian";
		$sdb["librarian_login_ip"][nolimitfoot]="yes";		
		$sdb["servspot_member"][name]=getlang($sdbs[name]);
		$sdb["servspot_member"][footmode]="servspotitem";
		$sdb["servspot_member"][headmode]="memberbarcode";
		$sdb["servspoti_member"][name]=getlang($sdbs[name]);
		$sdb["servspoti_member"][footmode]="servspotitem";
		$sdb["servspoti_member"][headmode]="memberbarcode";
		$sdb["ttb_member"][headmode]="memberbarcode";
		$sdb["ttb_member"][name]=getlang($sdbs[name]);
		$sdb["ttb_member"][footmode]="ttbitem";
		//$sdb["servspot_member"][nolimitfoot]="yes";		
		$sdb["checkout_member_media"][name]=getlang($sdbs[name]);
		$sdb["checkout_member_media"][footmode]="mediamid";
		$sdb["checkout_member_media"][headmode]="memberbarcode";
		$sdb["checkout_member_media"][nolimitfoot]="yes";		
		$sdb["checkout_member_media"][notablemode]="yes";
		$sdb["renew_member_media"][name]=getlang($sdbs[name]);
		$sdb["renew_member_media"][footmode]="mediamid"; //
		$sdb["renew_member_media"][headmode]="memberbarcode";
		$sdb["renew_member_media"][nolimitfoot]="yes";		
		$sdb["renew_member_media"][notablemode]="yes";
		$sdb["checkout_media_librarian"][name]=getlang($sdbs[name]);
		$sdb["checkout_media_librarian"][footmode]="librarian";
		$sdb["checkout_media_librarian"][headmode]="mediamid";
		$sdb["checkout_media_librarian"][nolimitfoot]="no";		
		$sdb["checkout_media_librarian"][notablemode]="yes";
		$sdb["checkin_media_librarian"][name]=getlang($sdbs[name]);
		$sdb["checkin_media_librarian"][footmode]="librarian";
		$sdb["checkin_media_librarian"][headmode]="mediamid";
		$sdb["checkin_media_librarian"][nolimitfoot]="no";		
		$sdb["checkin_media_librarian"][notablemode]="yes";
		
		$sdb["checkin_member_media"][name]=getlang($sdbs[name]);
		$sdb["checkin_member_media"][footmode]="mediamid";
		$sdb["checkin_member_media"][headmode]="memberbarcode";
		$sdb["checkin_member_media"][nolimitfoot]="yes";		
		$sdb["checkin_member_media"][notablemode]="yes";		
		$sdb["used_shelf_book"][name]=getlang($sdbs[name]);
		$sdb["used_shelf_book"][footmode]="shelvesid";
		$sdb["insidelib_member"][name]=getlang($sdbs[name]);
		$sdb["insidelib_member"][footmode]="mediamid";
		$sdb["insidelib_member"][nolimitfoot]="yes";		
		$sdb["insidelib_member"][headmode]="memberbarcode";
		$sdb["insidelib_mid"][footmode]="memberbarcode";
		$sdb["insidelib_mid"][nolimitfoot]="yes";		
		$sdb["insidelib_mid"][headmode]="mediamid";
		//$sdb["insidelib_restype"][footmode]="mediamid";
		$sdb["insidelib_restype"][headmode]="mediamid";
		//$sdb["insidelib_mid"][notablemode]="yes";		
		//$sdb["used_shelf_book"][nolimitfoot]="yes";		
		return $sdb;
}
function local_getsdb_thestat() {
	global $sdbs;
		$sdb_thestat["checkout_mbmajor"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_mbmajor"][headmode]="mbmajor";
		$sdb_thestat["checkout_mbroom"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_mbroom"][headmode]="mbroom";				
		$sdb_thestat["checkout_restype"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_restype"][headmode]="restype";				
		$sdb_thestat["checkout_mbtype"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_mbtype"][headmode]="membertype";				
		$sdb_thestat["checkout_byhrs"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_byhrs"][headmode]="formattime";				
		$sdb_thestat["checkout_libsite"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_libsite"][headmode]="libsite";				
		$sdb_thestat["checkout_callnlocal"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_callnlocal"][headmode]="format_local";		
		$sdb_thestat["checkout_callnnlm"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_callnnlm"][headmode]="format_nlm";		
		$sdb_thestat["checkout_callndc"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_callndc"][headmode]="format_dc";		
		$sdb_thestat["checkout_callnlc"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_callnlc"][headmode]="format_lc";				
		$sdb_thestat["checkout_callnnlm2"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_callnnlm2"][headmode]="format_nlm";		
		$sdb_thestat["checkout_callndc2"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_callndc2"][headmode]="format_dc";		
		$sdb_thestat["checkout_callnlc2"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_callnlc2"][headmode]="format_lc";				
		$sdb_thestat["checkout_librarian"][name]=getlang($sdbs[name]);
		$sdb_thestat["checkout_librarian"][headmode]="librarian";						
		$sdb_thestat["ms_membertype"][name]=getlang($sdbs[name]);
		$sdb_thestat["ms_membertype"][headmode]="membertype";			
		$sdb_thestat["memberlogin_membertype"][name]=getlang($sdbs[name]);
		$sdb_thestat["memberlogin_membertype"][headmode]="membertype";				
		$sdb_thestat["ft_fttype"][name]=getlang($sdbs[name]);
		$sdb_thestat["ft_fttype"][headmode]="fulltexttype";				
		$sdb_thestat["sharemarc_type"][name]=getlang($sdbs[name]);
		$sdb_thestat["sharemarc_type"][headmode]="sharemarc_type";				
		$sdb_thestat["visithp_type"][name]=getlang($sdbs[name]);
		$sdb_thestat["visithp_type"][headmode]="visithp_type";			
		$sdb_thestat["ms_gatecode"][name]=getlang($sdbs[name]);
		$sdb_thestat["ms_gatecode"][headmode]="ms_gatecode";			
		$sdb_thestat["ms_byhrs"][name]=getlang($sdbs[name]);
		$sdb_thestat["ms_byhrs"][headmode]="formattime";		
		return $sdb_thestat;
}

if (!is_array($globalstatdescr)) {
   $globalstatdescrtemp=barcodeval_get("quickstat-descr");
   $globalstatdescrtemp=explodenewline($globalstatdescrtemp);
   $globalstatdescrtemp=arr_filter_remnull($globalstatdescrtemp);
   @reset($globalstatdescrtemp);
   $globalstatdescr=Array();
   while (list($dbk,$dbv)=each($globalstatdescrtemp)) {
   	$db1=explode("=",$dbv);
   	$globalstatdescr[trim($db1[0])]=trim(getlang($db1[1]));
   }
}
function local_getdspstr($wh,$mode) {
	//echo "local_getdspstr($wh,$mode)";
	global $dcrURL;
	if ($mode=="libsite") {
		$wh=get_libsite_name($wh)."[$wh]";
	}
	if ($mode=="librarian") {
		$wh=get_library_name($wh)."[$wh]";
	}
	if ($mode=="memberbarcode") {
		$tmpinfo=tmq("select * from member where UserAdminID='$wh' ");
		$tmpinfor=tfa($tmpinfo); 
		$wh=get_member_name($wh)."[$wh]" ;
		$wh=$wh." ".get_room_name($tmpinfor[room]);
	}
	if ($mode=="mediamid") {
		$pid=tmq("select * from media_mid where bcode='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="<a href='$dcrURL/dublin.php?ID=$pid[pid]&item=$wh' target=_blank>".marc_gettitle($pid[pid])."</a>"."[$wh]";
	}
	if ($mode=="mbmajor") {
		$pid=tmq("select * from major where id='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="".getlang($pid[name]).""."[$wh]";
	}	
	if ($mode=="shelvesid") {
		$pid=tmq("select * from media_place where code='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="".getlang($pid[name])."";
		$pidp=tmq("select * from library_site where code='$pid[main]' ",false);
		$pidp=tmq_fetch_array($pidp);
		$wh=getlang($pidp[name]).", ".getlang($pid[name]).""."[$wh]";
	}	
	if ($mode=="servspotitem") {
		$pid=tmq("select * from servicespot_client where id='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="".getlang($pid[name])."";
		$pidp=tmq("select * from servicespot_room where id='$pid[pid]' ",false);
		$pidp=tmq_fetch_array($pidp);
		$wh=getlang($pidp[name]).", ".getlang($pid[name]).""."[$wh]";
	}	
	if ($mode=="ttbitem") {
		$pid=tmq("select * from rqroom_maintb where code='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="".getlang($pid[name]).""."[$wh]";
	}	
	if ($mode=="ms_gatecode") {
		$pid=tmq("select * from ms_sub where code='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="".getlang($pid[name]).""."[$wh]";
	}	
	if ($mode=="fulltexttype") {
		$pid=tmq("select * from media_fttype  where code='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="".getlang($pid[name]).""."[$wh]";
	}	
	if ($mode=="mbroom") {
		/*$pid=tmq("select * from room where id='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh="".getlang($pid[name]).""."[$wh]";*/
		$wh=get_room_name($wh)."[$wh]";
	}		
	if ($mode=="restype") {
		$wh="".get_media_type($wh).""."[$wh]";
	}			
	if ($mode=="formattime") {
		$wh="".($wh).".00-".($wh+1).".00";
	}
	if ($mode=="format_dc") {
	  global $globalstatdescr;
		$wh="".($globalstatdescr[$wh]).""." [$wh"."x]";
	}
	if ($mode=="format_local") {
	  global $globalstatdescr;
		$wh="".($globalstatdescr[$wh]).""." [$wh"."]";
	}
	if ($mode=="format_lc") {
	     global $globalstatdescr;
		$wh="".($globalstatdescr[$wh]).""." [$wh"."]";
	}	
	if ($mode=="format_nlm") {
	     global $globalstatdescr;
		$wh="".($globalstatdescr[$wh]).""." [$wh"."]";
	}	
	if ($mode=="membertype") {
		$pid=tmq("select * from member_type where type='$wh' ",false);
		$pid=tmq_fetch_array($pid);
		$wh=html_membertype_icon($wh)."".getlang($pid[descr]).""."[$wh]";
	}		
	//return iconvth($wh);;	
	
	if ($mode=="mediaid") {
		$wh="<a href='$dcrURL/dublin.php?ID=$wh' target=_blank>".marc_gettitle($wh)."</a>"."[$wh]";
	}
	if ($mode=="sharemarc_type") {
    $tmpdbtype[mined]=getlang("ผ่าน ULIBM-Catalog::l::trough ULIBM-Catalog");
    $tmpdbtype[clickonrecord]=getlang("คลิกที่รายการโดยตรง::l::Click on Bib.");
    $tmpdbtype[marked]=getlang("เลือกรายการและส่งออก::l::Marked and Export ");
		$wh=$tmpdbtype[$wh]."[$wh]";
	}	
	if ($mode=="visithp_type") {
		$tmpdbtype[undercon]=getlang("หน้าจอปิดปรับปรุงระบบ::l::Under construction");
		$tmpdbtype[webpage]=getlang("Home page");
		$tmpdbtype[webbox]=getlang("Home page (webbox)");
		$tmpdbtype[member_login]=getlang("แบบฟอร์มล็อกอินสมาชิก::l::Member's login form");
		$tmpdbtype[search]=getlang("แบบฟอร์มสืบค้นแบบง่าย::l::Basic Search");
		$tmpdbtype[advsearch]=getlang("แบบฟอร์มสืบค้นขั้นสูง::l::Advance Search");
		$tmpdbtype[searchmodule]=getlang("แสดงผลการสืบค้น::l::Search results");										
		$tmpdbtype[requestroom]=getlang("ระบบจองห้อง::l::Request room");
		$tmpdbtype[browsetitle]=getlang("แสดงรายการตามชื่อผู้เรื่อง::l::Browse database by Title");
		$tmpdbtype[browsesubject]=getlang("แสดงรายการหัวเรื่อง::l::Browse Subject");
		$tmpdbtype[browseauth]=getlang("แสดงรายการตามชื่อผู้แต่ง::l::Browse database by Author");
		$tmpdbtype[freedb]=getlang("ฐานข้อมูลใช้ฟรี::l::Free database");
		$tmpdbtype[browsereservmat]=getlang("รายการหนังสือสำรอง::l::Reserved Books");
		$tmpdbtype[wiki]=getlang("บทความแบบ Wikis::l::Wikis article");

		$wh=$tmpdbtype[$wh]."[$wh]";
	}		
	if (trim(strip_tags($wh))=="") {
		$wh="$mode.$wh";
	}
	return $wh;
}
?>