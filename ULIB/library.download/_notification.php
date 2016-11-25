<?php 
	; 
	include ("../inc/config.inc.php");

// พ
	load_pdf_ini("general");

	$head=barcodeval_get("notification-head");
	$body1=barcodeval_get("notification-body1");
	$body2=barcodeval_get("notification-body2");

	$s=tmq("select * from member where UserAdminID='$id' ");
	$s=tmq_fetch_array($s);
	$address1=$s[address];
	$address2=$s[address2];


	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
include("_notification.sub.php");



	$pdf->Output();
?>