<?php 
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("general");

	$head=barcodeval_get("sob-head");
	$head2=barcodeval_get("send-head2");
	$body1=barcodeval_get("sob-body");

	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
	$pdf->SetY(60);
	$pdf->SetFont('Tahoma','B',21);
	$pdf->Cell(545,35," $head ",0,0,'C');
	$pdf->SetFont('Tahoma','',12);
	$pdf->SetXY(400,110);
	$pdf->MultiCell(400,20,$head2,0,'L');
	$pdf->SetFont('Tahoma','',12);
	$pdf->SetXY(325,145);
	$pdf->Cell(200,120,"". date('d') . " " . $thaimonstr[date('n')] . " " . (date('Y')+543),0,0,'L');

	$pdf->SetXY(27,134);
	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");
	$acq=tmq("select * from acq_acq where id='$ID' ");
	$acq=tmq_fetch_array($acq);
	$s=tmq("select * from acq_company where id='$acq[company]' ");
	$s=tmq_fetch_array($s);

	$pdf->SetFont('Tahoma','',12);
	$pdf->SetXY(27,230);
	$pdf->Cell(545,20,"เรื่อง  สอบราคา");
	$pdf->SetXY(27,250);
	$pdf->Cell(545,20,"เรียน $s[name]");

	$pdf->SetXY(27,285);
	$pdf->MultiCell(545,20,$body1,0,'L');




	$pdf->Output();
?>