<?php 
;
 include("../inc/config.inc.php");
 ////////////
//$colnum=1;
//load_pdf_ini("barcode-singlecolumn");
$colnum=2;
load_pdf_ini("barcode");
//////////////
$papersize=barcodeval_get("BARCODE-xpbc_bookcraft-papersize");
$percolumn=barcodeval_get("BARCODE-xpbc_bookcraft-perpage");///
$allbc=barcodeval_get("BARCODE-xpbc_bookcraft-allbc");///

$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
$pdf->AddPage();
$pdf->SetMargins(10,10);
	$pdf->SetY(10);

$pdf->SetFont('Tahoma','',12);
//$pdf->Cell(40,10,'Hello World!');

$result=explodenewline($allbc);
$NRow = count($result);
if($NRow >0) { 
	$iwidth=barcodeval_get("BARCODE-xpbc_bookcraft-iwidth");
	$iheight=barcodeval_get("BARCODE-xpbc_bookcraft-iheight");
	$width=barcodeval_get("BARCODE-xpbc_bookcraft-width");
	$height=barcodeval_get("BARCODE-xpbc_bookcraft-height");
	$str=barcodeval_get("BARCODE-xpbc_bookcraft-str");
	$text=barcodeval_get("BARCODE-xpbc_bookcraft-text");
	$color=barcodeval_get("BARCODE-xpbc_bookcraft-color");	
	$colora=str_html2rgb($color);
	
	 barcode_startupvar();
	 $_x=0;
	 $_y=0;
	 $i=0; 
	//$pdf->Cell(0,(72/2.54)+9,"" ,0,1);
	$earlyCOL=10;
	$colcount=1;
	 while(list($k,$v) = each($result)) {
		 $rowbc=$v;
		 $rowbc=trim($rowbc);
		//$pdf->SetX(10);
		if ($colcount==1) {
			$pdf->SetX(10);
			$xtoset=10;
		} elseif ($colcount==2) {
			$pdf->SetX(205);
			$xtoset=205;
		} else {
			$pdf->SetX(400);
			$xtoset=400;
		}
		 $tmp=tmq("select * from media_mid where bcode='$rowbc' ");
		 $tmp=tmq_fetch_array($tmp);
		 $inumber=$tmp[inumber];
		 if (trim($inumber)=="ฉ.") {
			$inumber=""; 
		 }
		//$callnum=marc_getcalln($tmp[pid]);
		$callnum=marc_getmidcalln($rowbc);
		$iyear=marc_getyea($tmp[pid],"--");
		$iyear=strtolower($iyear);
		$iyear=explode('--',$iyear);
		$iyear=$iyear[count($iyear)-1];
		$iyear=trim($iyear);
		$iyear=trim($iyear,'.');
		$iyear=trim($iyear,'c');
		$ID = $rowbc;
		$img="$dcrs/_tmp/bc_$ID.JPG";
		//$tmp= Barcode39($ID, $iwidth, $iheight, $quality, "JPEG", $text ,$img);
		$tmp= Barcode39($ID, $iwidth, $iheight, $quality, "JPEG", 0 ,$img);
		$newx=ceil($pdf->wPt)/3;
		//$pdf->SetY(ceil($height/2));
		//$pdf->Cell($width,0," $callnum",0,1,'C');
		if ($colcount==1) {
			$startx=$pdf->GetX()+2;
		} elseif ($colcount==2) {
			$startx=205;
		} else {
			$startx=400;
		}
		$starty=$pdf->GetY()+2;
		$pdf->Image("$img",$startx+51+5,$starty+13,$width-51,$height+15);
//		$pdf->Image("$img",$startx+51+5,$starty+13+30,$width-51,$height);
		$pdf->SetFont('Tahoma','',10);
//		$pdf->Text($startx+5+floor($width/2),$starty+40,trim("$ID") );
		$pdf->Text($startx+floor($width/2),$starty+40+15,iconvth(trim("$ID")) );

		//$pdf->SetX($newx);
		//$pdf->Image("$img",$pdf->GetX(),$pdf->GetY(),$width,$height);

		//$pdf->SetX($newx*2);
		//$pdf->Image("$dcrs/_tmp/logo/_logo.jpg",$pdf->GetX()+6,$pdf->GetY(),30,30);
		//$pdf->SetX(($newx*2)+42);

		//$pdf->Cell($width+4,115,"" ,1,1);
		$callnum=str_replace('  ',' ',$callnum);
		$callnum=str_replace('  ',' ',$callnum);
		$callnum=trim($callnum);
		$callnuma=explode(' ',$callnum);
		//printr($callnuma);
		$call1_1=mb_substr($callnuma[0],0,2);
		$call1_2=mb_substr($callnuma[0],2);
     
		$pdf->SetFont('Tahoma','B',12);
		$pdf->Text($startx+2,$starty+ceil($height/8)+15,trim(iconvth("$call1_1")) );

		$pdf->SetFont('Tahoma','',12);

		$tmp1linecalln=trim("$call1_2");
		if (strlen($tmp1linecalln)>10) {
			$tmp1linecalln=mb_substr($tmp1linecalln,0,9)."..";
		}
		$pdf->Text($startx+2,$starty+ceil($height/8)+15+13,iconvth($tmp1linecalln) );
		$pdf->Text($startx+2,$starty+ceil($height/8)+15+26,iconvth(trim("$callnuma[1] ")) );
		$pdf->Text($startx+2,$starty+ceil($height/8)+15+39,iconvth(trim("$iyear ")) );
		$pdf->Text($startx+2,$starty+ceil($height/8)+15+50,iconvth(trim($inumber)));
		$pdf->Text($startx+2+60,$starty+ceil($height/8)+15+50,iconvth("$str"));
		//$pdf->Cell($width,10,"" ,0,1);
		$pdf->SetX($xtoset);
		$pdf->Cell($width+4,65+10,"" ,1,1);
		
	if (strtolower($color)!="#ffffff") {
		$pdf->SetFillColor($colora[0],$colora[1],$colora[2]);
		$pdf->SetX($xtoset);
		$pdf->Cell($width+4,10,"" ,1,1,'',1);	
	}
		
		//$pdf->SetX($startx+2);
		//$pdf->SetY($starty+ceil($height/2)+5+$height);
		//$pdf->Cell($width,$height,"$str" ,0,1,'C');
		//$pdf->SetX(25);
		$_y+=round($height+5);
		unlink($img);
		//$pdf->Cell($width,$height,"" ,1,1);
		$i++;

		$fullpage=$percolumn*3;

		if (($i % $fullpage)==0 && $i>1) {
			$pdf->_endpage();
			$pdf->AddPage();
			$pdf->SetMargins(10,10);
		   // $pdf->SetCol(0);
			$pdf->SetY(10);
			$colcount=1;
		} elseif (($i % $percolumn)==0 && $i>1) {
			$colcount++;
			if ($colcount>3) {
				$pdf->SetXY(10,10);
				$colcount=1;
			}
			if ($colcount==2) {
				$pdf->SetXY(205,10);
			}
			if ($colcount==3) {
				$pdf->SetXY(400,10);
			}
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