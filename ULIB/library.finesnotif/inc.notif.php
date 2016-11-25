<?php  //พ
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("general");
// พ

$source_db=tmq("select * from fines_notif where setid='$setid' order by memid",false);
$files=Array();
while ($source_dbr=tmq_fetch_array($source_db)) {
	$id=$source_dbr[memid];
	$memberbarcode=$id;
	$compilevar="yes";
	//$pid="finesnotif";
	$PTP_OUTPUTFILE=$dcrs."_tmp/_pdftemp/$id.pdf";
	include("../library.printtemplate/_ptp.php");
	$files[]=$PTP_OUTPUTFILE;
}
//printr($files);
include($dcrs."inc/pdfmerger/PDFMerger.php");


$pdfm = new PDFMerger;

@reset($files);
while (list($k,$v)=each($files)) {
	$pdfm->addPDF($v, 'all');
}
	$pdfm->merge('browser')
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.



?>