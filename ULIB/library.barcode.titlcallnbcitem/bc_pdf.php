<?php  //พ
;
 include("../inc/config.inc.php");
 ////////////
//$colnum=1;
//load_pdf_ini("barcode-singlecolumn");
$colnum=2;
load_pdf_ini("barcode");
//////////////
$papersize=barcodeval_get("BARCODE-titlcallnbcitem-papersize");
$percolumn=barcodeval_get("BARCODE-titlcallnbcitem-perpage");///
$allbc=barcodeval_get("BARCODE-titlcallnbcitem-allbc");///

$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
$pdf->AddPage();
$pdf->SetMargins(10,10);
	$pdf->SetY(10);
	//$pdf->SetY(1);

$pdf->SetFont('Tahoma','',12);
//$pdf->Cell(40,10,'Hello World!');

$result=explodenewline($allbc);
$NRow = count($result);
if($NRow >0) { 
	$iwidth=barcodeval_get("BARCODE-titlcallnbcitem-iwidth");
	$iheight=barcodeval_get("BARCODE-titlcallnbcitem-iheight");
	$width=barcodeval_get("BARCODE-titlcallnbcitem-width");
	$height=barcodeval_get("BARCODE-titlcallnbcitem-height");
	$str=barcodeval_get("BARCODE-titlcallnbcitem-str");
	$text=barcodeval_get("BARCODE-titlcallnbcitem-text");
	$color=barcodeval_get("BARCODE-titlcallnbcitem-color");	
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
		//$callnum=marc_getcalln($tmp[pid]);
		$callnum=marc_getmidcalln($rowbc);
		$title=marc_gettitle($tmp[pid]);
		$bibid=$tmp[pid];
		if (mb_strlen($title)>34) {
			$title=mb_substr($title,0,32)."..";
		}
		if (mb_strlen($callnum)>100) {
			$callnum=mb_substr($callnum,0,98)."..";
		}

		$ID = $rowbc;
		$img="$dcrs/_tmp/bc_$ID.JPG";
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
		$pdf->Image("$img",$startx+5,$starty+33,$width-5,$height+15);
//		$pdf->Image("$img",$startx+51+5,$starty+10+$height,$width-51,$height);
		//$pdf->SetX($newx);
		//$pdf->Image("$img",$pdf->GetX(),$pdf->GetY(),$width,$height);
		$pdf->SetFont('Tahoma','',10);
		if ($text==1) {
			//$pdf->Text($startx+5+floor($width/2),$starty+40+15,trim("$ID") );
			$pdf->Text($startx+12,$starty+ceil($height/8)+65,trim("$ID") );
		}
		$pdf->Text($startx+12,$starty+ceil($height/8)+65+10,iconvth(trim("bib:$bibid")) );
		$pdf->SetFont('Tahoma','',12);
		$pdf->Text($startx+2,$starty+ceil($height/8)+10,(trim(mb_substr(iconvth($title),0,25))) );
		$pdf->Text($startx+2,$starty+ceil($height/8)+25,iconvth(trim("$callnum")) );
		//$pdf->Text($startx+1+5,$starty+40+28,("$callnum") );

		///$call1_1=substr($callnuma[0],0,2);
		///$call1_2=substr($callnuma[0],2);

		//$pdf->Text($startx+2+60,$starty+ceil($height/8)+15+50,trim("$str"));


		$pdf->SetFillColor(255,255,255);
		//$pdf->Cell($width,10,"" ,0,1);
		
		$pdf->SetX($xtoset);
		$pdf->Cell($width+4,75+10,"" ,1,1);
		//$starty+=10;

		if (strtolower($color)!="#ffffff") {
			$pdf->SetFillColor($colora[0],$colora[1],$colora[2]);
			$pdf->SetX($xtoset);
			$pdf->Cell($width+4,10,"" ,1,1,'',1);	
		}
		//$pdf->SetX($startx+2);
		//$pdf->SetY($starty+ceil($height/2)+5+$height);
		//$pdf->Cell($width,$height,"$str" ,0,1,'C');
		//$pdf->SetX(25);
		$_y+=round($height+5+15);
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