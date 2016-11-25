<?php 
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("nohead");

	$head=barcodeval_get("mannual-head");
	$body=barcodeval_get("mannual-body");

	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();
	$pdf->SetFont('Tahoma','',10);
function locl_page($_xx,$_yy) {
	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
	global $pdf;
	global $head;
	global $body;
	$pdf->SetFont('Tahoma','B',12);
	$pdf->SetXY($_xx,$_yy);

	$pdf->MultiCell(270,20,iconvth("$head "),1,'C');
	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");
	$pdf->SetXY($_xx,$_yy+63);
	$pdf->SetFont('Tahoma','',12);
	$pdf->MultiCell(545,20,iconvth($body));

	$_yy2=$_yy+163;
	for ($i=1;$i<=12;$i++) {
		$_yy2+=17;
		$pdf->Text($_xx,$_yy2," $i . ............................................................");
		
	}
		$pdf->Text($_xx,$_yy2+25,iconvth(" ลงชื่อบรรณารักษ์ ........................................"));
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