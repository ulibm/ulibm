<?php //พ
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("nohead");

	$body=barcodeval_get("bookstamp-body");

	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();
	$pdf->SetFont('Tahoma','',10);
function locl_page($_xx,$_yy) {
	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
	global $pdf;
	global $body;
	global $dcrs;
	$pdf->SetFont('Tahoma','B',12);
		$pdf->Image("$dcrs/_tmp/logo/_logo.jpg",$_xx+5,$_yy+5);

	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");

	$pdf->SetXY($_xx+63,$_yy+5);
	$pdf->MultiCell(210,45,iconvth("$body"),1,'C');
	$pdf->SetFont('Tahoma','',12);


	$_yy2=$_yy+60;
	for ($i=1;$i<=14;$i++) {
		$_yy2+=22;
		$pdf->Text($_xx,$_yy2,"........................|.........................|........................");
		
	}
}
//locl_page(0+6,0+20) ;
//locl_page(0,$pdf->hPt/2) ;
//locl_page($pdf->wPt/2,0+20) ;
locl_page(floor($pdf->wPt/2),floor($pdf->hPt/2)) ;
locl_page(0+10,floor($pdf->hPt/2)) ;
locl_page(floor($pdf->wPt/2),0+10) ;
locl_page(0+10,0+10) ;
$centerx=floor($pdf->wPt/2);
$centery=floor($pdf->hPt/2);

$pdf->Line($centerx-15,$centery,$centerx+15,$centery);
$pdf->Line($centerx,$centery-15,$centerx,$centery+15);
	$pdf->Output();
?>