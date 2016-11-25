<?php  //พ
;
 include("../inc/config.inc.php");
 ////////////
 $colnum=barcodeval_get("BARCODE-xpbc-colnum");
load_pdf_ini("barcode");
//////////////
$papersize=barcodeval_get("BARCODE-xpbc-papersize");

$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");

$pdf->AddPage();
$pdf->SetMargins(10,10);
//$pdf->SetMargins(0,0);
   // $pdf->SetCol(0);
	//$pdf->SetY(1);

$pdf->SetFont('Tahoma','',12);
//$pdf->Cell(40,10,'Hello World!');

$sql1 ="SELECT *  FROM xpbc"; 
$sql2 = "$sql1 order by id ";
$result = tmq($sql2);
$NRow = tmq_num_rows($result);
if($NRow >0) { 
	$width=barcodeval_get("BARCODE-xpbc-width");
	$height=barcodeval_get("BARCODE-xpbc-height");
	$iwidth=barcodeval_get("BARCODE-xpbc-iwidth");
	$iheight=barcodeval_get("BARCODE-xpbc-iheight");
	$text=barcodeval_get("BARCODE-xpbc-text");
	$perpage=barcodeval_get("BARCODE-xpbc-perpage");
	 barcode_startupvar();
	 $_x=0;
	 $_y=0;
	 $i=0; 
	//$pdf->Cell(0,(72/2.54)+9,"" ,0,1);
	$earlyCOL=10;
	 while($row = tmq_fetch_array($result)){
		if ($earlyCOL!=$pdf->col) {
			$earlyCOL=$pdf->col;
			$pdf->SetY(10);
			//$pdf->Cell(0,5,"new cols ". $pdf->GetY() ,0,1);
		}


		$ID = $row[bc];
		$img="$dcrs/_tmp/bc_$ID.JPG";
		$tmp= Barcode39($ID, $iwidth, $iheight, $quality, "JPEG", $text ,$img);
		$pdf->Image("$img",$pdf->GetX(),$pdf->GetY(),$width,$height);
		$_y+=round($height+5);
		unlink($img);
		$i++;
		if (($i % $perpage)==0 && $i>1) {
			$pdf->_endpage();
			$pdf->AddPage();
			$pdf->SetMargins(10,10);
			$pdf->SetCol(0);
		}
		$pdf->Cell(0,$height,"" ,0,1);

		//echo $i;
		$s = $i-1;	
   } 
} else {
	$pdf->SetXY(100,100);
	$pdf->Cell(0,5,"No barcode found in Database",0,1);
}

$pdf->Output();
?>