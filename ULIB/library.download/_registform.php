<?php 
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("general");

	$head=barcodeval_get("registform-head");
	$body=barcodeval_get("registform-body");

	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();
	$pdf->SetFont('Tahoma','',10);
	//$pdf->Cell(545,120,"". date('d') . " " . iconvth($thaimonstr[date('n')]) . " " . (date('Y')+543),0,0,'R');
	$pdf->Cell(545,120,"".".........../..................../................",0,0,'R');

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
	$pdf->SetY(60);
	$pdf->SetFont('Tahoma','B',21);
	$pdf->Cell(545,35,iconvth(" $head "),1,0,'C');
	$pdf->SetXY(27,134);
	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");
	$pdf->SetFont('Tahoma','',12);
	$pdf->MultiCell(545,20,iconvth($body));


	$pdf->SetXY(27,685);
	$pdf->Cell(545,100," ",1,0,'C');
	$pdf->SetXY(27,685);
	$pdf->Cell(545,20,iconvth("สำหรับเจ้าหน้าที่"),0,0,'L');

	$pdf->Output();
?>