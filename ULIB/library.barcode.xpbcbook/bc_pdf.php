<?php 
;
 include("../inc/config.inc.php");
 ////////////
$colnum=1;
load_pdf_ini("barcode-singlecolumn");
//////////////
$papersize=barcodeval_get("BARCODE-xpbcbook-papersize");
$perpage=barcodeval_get("BARCODE-xpbcbook-perpage");
$isborder=barcodeval_get("BARCODE-xpbcbook-isborder");

	$color=barcodeval_get("BARCODE-xpbcbook-color");	
	$colora=str_html2rgb($color);


$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddPage();
$pdf->SetMargins(10,10);
	//$pdf->SetY(1);

$pdf->SetFont('Tahoma','',12);
//$pdf->Cell(40,10,'Hello World!');

$sql1 ="SELECT *  FROM xpbcbook"; 
$sql2 = "$sql1 order by id ";
$result = tmq($sql2);
$NRow = tmq_num_rows($result);
if($NRow >0) { 
	$iwidth=barcodeval_get("BARCODE-xpbcbook-iwidth");
	$iheight=barcodeval_get("BARCODE-xpbcbook-iheight");
	$width=barcodeval_get("BARCODE-xpbcbook-width");
	$height=barcodeval_get("BARCODE-xpbcbook-height");
	$str=barcodeval_get("BARCODE-xpbcbook-str");
	$text=barcodeval_get("BARCODE-xpbcbook-text");
	 barcode_startupvar();
	 $_x=0;
	 $_y=0;
	 $i=0; 
	//$pdf->Cell(0,(72/2.54)+9,"" ,0,1);
	$earlyCOL=10;
	 while($row = tmq_fetch_array($result)){
		$pdf->SetX(10);
		 $tmp=tmq("select * from media_mid where bcode='$row[bc]' ");
		 $tmp=tmq_fetch_array($tmp);
		 $inumber=$tmp[inumber];
		 if (trim($inumber)=="ฉ.") {
			$inumber=""; 
		 }
		 if (trim($inumber)=="c.") {
			$inumber=""; 
		 }
		$callnum=marc_getcalln($tmp[pid]);
		$ID = $row[bc];
		$img="$dcrs/_tmp/bc_$ID.JPG";
		$tmp= Barcode39($ID, $iwidth, $iheight, $quality, "JPEG", ($text ),$img);
		$newx=ceil($pdf->wPt)/3;
		//$pdf->SetY(ceil($height/2));
		//$pdf->Cell($width,0," $callnum",0,1,'C');
		$pdf->Image("$img",$pdf->GetX(),$pdf->GetY(),$width,$height);
		$pdf->SetX($newx);
		$pdf->Image("$img",$pdf->GetX(),$pdf->GetY(),$width,$height);

		$pdf->SetX($newx*2);
		$pdf->Image("$dcrs/_tmp/logo/_logo.jpg",$pdf->GetX()+6,$pdf->GetY(),30,30);
		$pdf->SetX(($newx*2)+42);

		$pdf->Text($pdf->GetX(),$pdf->GetY()+ceil($height/8)+5,iconvth(trim("$callnum ") .' '.trim($inumber)));
		$pdf->Text($pdf->GetX(),$pdf->GetY()+ceil($height/2)+5,iconvth(trim("$str")));
		$pdf->SetX(10);

		$barwidth=($width*3)+30;
		$barheight=$height;
		if (strtolower($color)!="#ffffff") {
			$barheight+=8;
		}
		$pdf->Cell($barwidth,$barheight+5,"" ,$isborder,1);		//border

		//color
		if (strtolower($color)!="#ffffff") {
			$pdf->SetY($pdf->GetY()-8);
			$pdf->SetX($pdf->GetX()+1);
			$pdf->SetFillColor($colora[0],$colora[1],$colora[2]);
			$pdf->Cell($barwidth-2,5,"" ,0,1,'',1);	
			$pdf->SetX($pdf->GetX()+1);
			$pdf->SetFillColor(255,255,255);	
			$pdf->Cell($barwidth-2,3,"" ,0,1,'',1);	
		}

		$_y+=round($height+5);
		unlink($img);
		$i++;
		if (($i % $perpage)==0 && $i>1) {
			$pdf->_endpage();
			$pdf->AddPage();
//		    $pdf->SetCol(0);
			$pdf->SetMargins(10,10);
		}

		//echo $i;
		$s = $i-1;	
   } 
} else {
	$pdf->SetXY(100,100);
	$pdf->Cell(0,5,"No barcode found in Database",0,1);
}

$pdf->Output();
?>