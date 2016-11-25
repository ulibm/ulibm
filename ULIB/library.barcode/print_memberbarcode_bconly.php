<?php  //พ
;
 include("../inc/config.inc.php");
 ////////////
  $colnum=barcodeval_get("BARCODE-memberbarcode_bconly-colnum");


load_pdf_ini("barcode");
//////////////
$papersize=barcodeval_get("BARCODE-memberbarcode_bconly-papersize");
$perpage=barcodeval_get("BARCODE-memberbarcode_bconly-perpage");

$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddPage();
//$pdf->SetMargins(0,0);
    $pdf->SetCol(0);
	//$pdf->SetY(1);

$pdf->SetFont('Tahoma','',34);
//$pdf->Cell(40,10,'Hello World!');


	$class=(barcodeval_get("BARCODE-memberbarcode_bconly-class"));
	$bc=trim(barcodeval_get("BARCODE-memberbarcode_bconly-bc"));

$s="select * from member where 1 ";
if ($class!="") {
	$s="$s and room='$class'";
}
if ($bc!="") {
	$s="$s and UserAdminID='$bc'";
}
$s="$s order by UserAdminID";
$s=tmq($s);

if(tmq_num_rows($s)!=0) { 
	$iwidth=barcodeval_get("BARCODE-memberbarcode_bconly-iwidth");
	$iheight=barcodeval_get("BARCODE-memberbarcode_bconly-iheight");
	$width=barcodeval_get("BARCODE-memberbarcode_bconly-width");
	$height=barcodeval_get("BARCODE-memberbarcode_bconly-height");
	$number=barcodeval_get("BARCODE-memberbarcode_bconly-number");
	 barcode_startupvar();
	 $_x=0;
	 $_y=0;
	 $i=0; 
	//$pdf->Cell(0,(72/2.54)+9,"" ,0,1);
	$earlyCOL=10;
	while ($r=tmq_fetch_array($s)) {
		$xx=$r[UserAdminID];
		if ($earlyCOL!=$pdf->col) {
			$earlyCOL=$pdf->col;
			$pdf->SetY(51);
			//$pdf->Cell(0,5,"new cols ". $pdf->GetY() ,0,1);
		}


		$img="$dcrs/_tmp/bc_$xx.JPG";
		$tmp= Barcode39($xx, $iwidth, $iheight, $quality, "JPEG", $number ,$img);
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
		$pdf->Cell(0,5,"" ,0,1);

		//echo $i;
   } 
} else {
	$pdf->SetXY(100,100);
	$pdf->Cell(0,5,"No result found for your limit:",0,1);
	$pdf->SetXY(100,130);
	$pdf->Cell(0,5,"Barcode: $bc",0,1);
	$pdf->SetXY(100,160);
	$pdf->Cell(0,5,"Class: $class",0,1);
}

$pdf->Output();
?>