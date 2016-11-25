<?php 


	$afilter=Array();
	$afilter[last30d]=Array();
	$afilter[last30d][name]=getlang("รายการใหม่รายเดือน::l::Monthly New Item");
   $lastmonthdt=time()-(60*60*24*30);
	$afilter[last30d][sql]=" lastdtitem>$lastmonthdt ";
	$afilter[last30d][order]=" ulibnote like '%,cover,%' desc, lastdtitem desc ";

	$afilter[last90d]=Array();
	$afilter[last90d][name]=getlang("รายการใหม่ 3 เดือนล่าสุด::l::New Bib Last 3 Month");
   $lastmonthdt=time()-(60*60*24*90);
	$afilter[last90d][sql]=" lastdtitem>$lastmonthdt ";
	$afilter[last90d][order]=" ulibnote like '%,cover,%' desc, lastdtitem desc ";

	$afilter[mostborrowed]=Array();
	$afilter[mostborrowed][name]=getlang("รายการที่มีผู้ยืมมากที่สุด::l::Most borrowed");
	$afilter[mostborrowed][fullsql]=" select distinct pid as ID, count(id) as cc from checkout_log where %LIMITSQL group by pid order by cc desc %LIMITNUM";

	$afilter[ld07s]=Array();
	$afilter[ld07s][name]=getlang("วารสาร::l::Serials");
	$afilter[ld07s][sql]=" substring(leader,8,1)='s' ";
	$afilter[ld07s][order]=" lastdtitem desc ";
	
	$afilter[ld07b]=Array();
	$afilter[ld07b][name]=getlang("บทความวารสาร::l::Journal Index");
	$afilter[ld07b][sql]=" substring(leader,8,1)='b' ";
	$afilter[ld07b][order]=" lastdt desc "	;

	/*
	$afilter[unpublish]=Array();
	$afilter[unpublish][name]=getlang("รายการที่ไม่เผยแพร่::l::Unpublished");
	$afilter[unpublish][sql]="  ispublish<>'yes'  ";
	$afilter[publish]=Array();
	$afilter[publish][name]=getlang("รายการที่เผยแพร่::l::Published");
	$afilter[publish][sql]="  ispublish='yes'  ";*/
	$afilter[has856]=Array();
	$afilter[has856][name]=getlang("มีข้อมูลในแท็ก 856::l::with data in 856");
	$afilter[has856][sql]="  length(tag856)>6  ";
	$afilter[has856][order]=" lastdt desc "	;

	/*$afilter[emptylibsite]=Array();
	$afilter[emptylibsite][name]=getlang("ไม่กำหนดสาขาห้องสมุด::l::No campus defined");
	$afilter[emptylibsite][sql]="  trim(LIBSITE)=''  ";*/

	$saf=tmq("select * from library_site");
	while ($safr=tfa($saf)) {
		$afilter["libsite_$safr[code]"]=Array();
		$afilter["libsite_$safr[code]"][name]=getlang("เป็นของสาขา::l::Campus").":".getlang($safr[name]);
		$afilter["libsite_$safr[code]"][sql]="  LIBSITE='$safr[code]'  ";
		$afilter["libsite_$safr[code]"][order]=" lastdtft desc,lastdtitem desc ";
	}
	$saf=tmq("select * from media_fttype");
	while ($safr=tfa($saf)) {
		$afilter["fttype_$safr[code]"]=Array();
		$afilter["fttype_$safr[code]"][name]=getlang("ไฟล์แนบ::l::Files").":".getlang($safr[name]);
		$afilter["fttype_$safr[code]"][sql]="  ulibnote like '%,$safr[code],%'  ";
		$afilter["fttype_$safr[code]"][order]=" lastdtft desc ";
	}
	$afilter[webpageshowcase]=Array();
	$afilter[webpageshowcase][name]=getlang("แสดงที่หน้าหลัก::l::on showcase");
	$afilter[webpageshowcase][sql]="  webpageshowcase='yes'  ";
	$afilter[webpageshowcase][order]=" lastdtft desc,lastdtitem desc ";
	
	
?>