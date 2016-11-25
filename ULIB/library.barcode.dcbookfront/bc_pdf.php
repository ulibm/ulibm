<?php 
;
 include("../inc/config.inc.php");
 ////////////
//$colnum=1;
//load_pdf_ini("barcode-singlecolumn");
$colnum=4;
load_pdf_ini("barcode");
//////////////
$papersize=barcodeval_get("BARCODE-xpbc_dcbookfront-papersize");
$percolumn=barcodeval_get("BARCODE-xpbc_dcbookfront-perpage");///
$allbc=barcodeval_get("BARCODE-xpbc_dcbookfront-allbc");///
	$color=barcodeval_get("BARCODE-xpbc_dcbookfront-color");	
	$colora=str_html2rgb($color);
	
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
	 barcode_startupvar();
	 $_x=0;
	 $_y=0;
	 $i=0; 
	//$pdf->Cell(0,(72/2.54)+9,"" ,0,1);
	$earlyCOL=10;
	$colcount=1;
	 while(list($k,$v) = each($result)) {
		 $width=floor($pdf->wPt/5)-15;
		 $rowbc=$v;
		 $rowbc=trim($rowbc);
		//$pdf->SetX(10);
		if ($colcount==1) {
			$pdf->SetX(10);
			$xtoset=10;
		} elseif ($colcount==2) {
			$pdf->SetX(125);
			$xtoset=125;
		} elseif ($colcount==3) {
			$pdf->SetX(240);
			$xtoset=240;
		} elseif ($colcount==4) {
			$pdf->SetX(355);
			$xtoset=355;
		} else {
			$pdf->SetX(470);
			$xtoset=470;
		}
		 $tmp=tmq("select * from media_mid where bcode='$rowbc' ");
		 $tmp=tmq_fetch_array($tmp);
		 $inumber=$tmp[inumber];
		 if (trim($inumber)=="ฉ.") {
			$inumber=""; 
		 }
		$callnum=marc_getmidcalln($rowbc);
		$iyear=marc_getyea($tmp[pid],"--");
		$iyear=strtolower($iyear);
		$iyear=explode('--',$iyear);
		$iyear=$iyear[count($iyear)-1];
		$iyear=trim($iyear);
		$iyear=trim($iyear,'.');
		$iyear=trim($iyear,'c');
		$ID = $rowbc;
		$newx=ceil($pdf->wPt)/3;
		//$pdf->SetY(ceil($height/2));
		//$pdf->Cell($width,0," $callnum",0,1,'C');
		if ($colcount==1) {
			$startx=$pdf->GetX()+2;
		} elseif ($colcount==2) {
			$startx=125;
		} elseif ($colcount==3) {
			$startx=240;
		} elseif ($colcount==4) {
			$startx=355;
		} else {
			$startx=470;
		}
		$starty=$pdf->GetY()+2;
		//$pdf->SetX($newx);

		//$pdf->SetX($newx*2);
		//$pdf->Image("$dcrs/_tmp/logo/_logo.jpg",$pdf->GetX()+6,$pdf->GetY(),30,30);
		//$pdf->SetX(($newx*2)+42);

		//$pdf->Cell($width+4,115,"" ,1,1);
		$callnum=str_replace('  ',' ',$callnum);
		$callnum=str_replace('  ',' ',$callnum);
		$callnum=trim($callnum);
		if (strpos($callnum, '.')=== false) {
			 $callnuma_1=explode(' ',$callnum);
			 $callnuma_part1=array_slice($callnuma_1,0,count($callnuma_1)-1);
			 $callnuma_part2=$callnuma_1[count($callnuma_1)-1];
			 $callnuma=Array();
			 $callnuma[0]=implode(' ',$callnuma_part1);;
			 $callnuma[1]=$callnuma_part2;
			 $predotline2="";
		} else {
			 $predotline2=".";
			 $callnuma=explode('.',$callnum);
		}
		///$call1_1=substr($callnuma[0],0,2);
		///$call1_2=substr($callnuma[0],2);
		$call1_1=$callnuma[0];
		$call1_2=$callnuma[1];
		$call1_2=explode(' ',$call1_2,2);
		$call1_2_1=$call1_2[0];
		$call1_2_2=$call1_2[1];
		if ($call1_2_2=="" && count(explode(' ',$call1_1))>1) {
			 $call1_2_2=$call1_2_1;
			 $call1_2_1="";
		}
		if ($call1_2_1!="") {
			$call1_2_1="$predotline2$call1_2_1";
		}

		$pdf->SetFont('Tahoma','B',15);
		$tmp1linecalln=trim("$call1_1 $call1_2_1");
		if (mb_strlen($tmp1linecalln)>11) {
			$tmp1linecalln=mb_substr($tmp1linecalln,0,15)."..";
		}

		$pdf->Text($startx+2,$starty+ceil($height/8)+13,iconvth($tmp1linecalln ));

		$pdf->SetFont('Tahoma','',13);
		$pdf->Text($startx+2,$starty+ceil($height/8)+15+13,iconvth(trim("$call1_2_2 ")) );
		$pdf->Text($startx+2,$starty+ceil($height/8)+15+26,iconvth(trim("$iyear ")) );
		$pdf->Text($startx+2,$starty+ceil($height/8)+15+39,iconvth(trim($inumber)));
		//$pdf->Text($startx+2+60,$starty+ceil($height/8)+15+50,trim("$str"));
		///$pdf->Cell($width,10,"" ,0,1);
		$pdf->SetX($xtoset);
		$pdf->Cell($width+4,75,"" ,1,1);
		
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
		//$pdf->Cell($width,$height,"" ,1,1);
		$i++;

		$fullpage=$percolumn*5;

		if (($i % $fullpage)==0 && $i>1) {
			$pdf->_endpage();
			$pdf->AddPage();
			$pdf->SetMargins(10,10);
		   // $pdf->SetCol(0);
			$pdf->SetY(10);
			$colcount=1;
		} elseif (($i % $percolumn)==0 && $i>1) {
			$colcount++;
			if ($colcount>5) {
				$pdf->SetXY(10,10);
				$colcount=1;
			}
			if ($colcount==2) {
				$pdf->SetXY(125,10);
			}
			if ($colcount==3) {
				$pdf->SetXY(240,10);
			}
			if ($colcount==4) {
				$pdf->SetXY(355,10);
			}
			if ($colcount==5) {
				$pdf->SetXY(470,10);
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