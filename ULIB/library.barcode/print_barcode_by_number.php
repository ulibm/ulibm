<?php  //พ
;
 include("../inc/config.inc.php");
 ////////////
 $colnum=barcodeval_get("BARCODE-barcode_bynumber-colnum");

load_pdf_ini("barcode");
//////////////
$papersize=barcodeval_get("BARCODE-barcode_bynumber-papersize");

$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddPage();
//$pdf->SetMargins(0,0);
    $pdf->SetCol(0);
	//$pdf->SetY(1);

$pdf->SetFont('Tahoma','',12);
//$pdf->Cell(40,10,'Hello World!');


	$start=round(barcodeval_get("BARCODE-barcode_bynumber-start"));
	$end=round(barcodeval_get("BARCODE-barcode_bynumber-end"));
	$perpage=round(barcodeval_get("BARCODE-barcode_bynumber-perpage"));

if($start <$end) { 
	$iwidth=barcodeval_get("BARCODE-barcode_bynumber-iwidth");
	$iheight=barcodeval_get("BARCODE-barcode_bynumber-iheight");
	$width=barcodeval_get("BARCODE-barcode_bynumber-width");
	$height=barcodeval_get("BARCODE-barcode_bynumber-height");
	$text=barcodeval_get("BARCODE-barcode_bynumber-text");
	$number=barcodeval_get("BARCODE-barcode_bynumber-number");
	$digit=barcodeval_get("BARCODE-barcode_bynumber-digit");
	 barcode_startupvar();
	 $_x=0;
	 $_y=0;
	 $i=0; 
	//$pdf->Cell(0,(72/2.54)+9,"" ,0,1);
	$earlyCOL=10;
	for ($runn=$start;$runn<=$end;$runn++) {
		$xx= substr("00000000000000000000000000000000000000000000000000000000000000$runn",-$digit);
		if ($earlyCOL!=$pdf->col) {
			$earlyCOL=$pdf->col;
			$pdf->SetY(51);
			//$pdf->Cell(0,5,"new cols ". $pdf->GetY() ,0,1);
		}


		$img="$dcrs/_tmp/bc_$xx.JPG";
		$tmp= Barcode39($xx, $iwidth, $iheight, $quality, "JPEG", $number ,$img);
		$pdf->Cell($width,20,iconvth("$text") ,0,1,'C');
		$pdf->Image("$img",$pdf->GetX(),$pdf->GetY(),$width,$height);
		/*
		if ($number==1) {
			$xx= substr("00000000000000000000000000000000$runn",-$digit);
			$pdf->Cell($width,12,"$xx" ,0,"1T",'C');
		}
		*/
		$_y+=round($height+5);
		unlink($img);
		$i++;
		if (($i % $perpage)==0 && $i>1) {
			$pdf->_endpage();
			$pdf->AddPage();
			$pdf->SetMargins(0,0);
		    $pdf->SetCol(0);
		}
		$pdf->Cell(0,$height,"" ,0,1);

		//echo $i;
   } 
} else {
	$pdf->SetXY(100,100);
	$pdf->Cell(0,5,"Invalid Number Specified",0,1);
}

$pdf->Output();
?>