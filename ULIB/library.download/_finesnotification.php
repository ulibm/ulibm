<?php
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("general");// พ

	$head=barcodeval_get("finesnotification-head");
	$body1=barcodeval_get("finesnotification-body1");
	$body2=barcodeval_get("finesnotification-body2");

$pdf=new PDF("P","pt","A4");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");

	$s=tmq("select * from member where UserAdminID='$id' ");
	$s=tmq_fetch_array($s);
	$address1=$s[address];
	$address2=$s[address2];


	$pdf->AddPage();

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
	include("../library.download/_finesnotification.sub.php");


	$pdf->Output();
?>