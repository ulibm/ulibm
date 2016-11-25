<?php  //พ
;
 include("../inc/config.inc.php");
 ////////////
load_pdf_ini("barcode-singlecolumn");
//////////////
$papersize=barcodeval_get("BARCODE-membercard-papersize");
$perpage=barcodeval_get("BARCODE-membercard-perpage");
$currentcardtp=barcodeval_get("BARCODE-membercard-currentcardtp");

$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
$pdf->SetMargins(10,10);
$pdf->AddPage();
$pdf->SetMargins(10,10);
		$pdf->SetFont('Tahoma','',12);

	//$pdf->SetY(1);

//$pdf->Cell(40,10,'Hello World!');

$mbtypedb=tmq_dump("member_type","type","descr");

	$class=(barcodeval_get("BARCODE-membercard-class"));
	$bc=trim(barcodeval_get("BARCODE-membercard-bc"));
	$border=(barcodeval_get("BARCODE-membercard-border"));
	$cardfronttitle=(barcodeval_get("BARCODE-membercard-cardfronttitle"));
	$rule=(barcodeval_get("BARCODE-membercard-rule"));
	$bwidth=(barcodeval_get("BARCODE-membercard-bwidth"));
	$bheight=(barcodeval_get("BARCODE-membercard-bheight"));
	$iwidth=(barcodeval_get("BARCODE-membercard-iwidth"));
	$iheight=(barcodeval_get("BARCODE-membercard-iheight"));
	$width=(barcodeval_get("BARCODE-membercard-width"));
	$height=(barcodeval_get("BARCODE-membercard-height"));
	$picypos=(barcodeval_get("BARCODE-membercard-picypos"));
	if ($forcesetmember!="") {
		$bc=$forcesetmember;
	}

$s="select * from member where 1 ";
if ($class!="") {
	$s="$s and room='$class'";
}
if ($bc!="") {
	$bca=explodenewline($bc);
	$bcs=" ( 0 or ";
	while (list($bck,$bcv)=each($bca)) {
		$bcv=trim($bcv);
		$bcs.=" UserAdminID='$bcv' or";
	}
	$bcs=trim($bcs,'or');
	$bcs.=" )";
	$s="$s and $bcs ";
}
$s="$s order by UserAdminID";
$s=tmq($s,false);

if(tmq_num_rows($s)!=0) { 
	//$width=200;
	//$height=43;
	 barcode_startupvar();
	 $_x=0;
	 $_y=0;
	 $i=0; 
	//$pdf->Cell(0,(72/2.54)+9,"" ,0,1);
	$earlyCOL=10;
	while ($r=tmq_fetch_array($s)) {
		$xx=$r[UserAdminID];
		$name=$r[UserAdminName];

		if ($earlyCOL!=$pdf->col) {
			$earlyCOL=$pdf->col;
			$pdf->SetY(10);
			//$pdf->Cell(0,5,"new cols ". $pdf->GetY() ,0,1);
		}
		$place=barcodeval_get("memberpic-wheresave");
		if ($place=="local") {
			$pic=member_pic_spath($xx);
			if (!file_exists($pic)) {
				$pic="$dcrs/pic/no.jpg";
			}
		} else {
			$tmppic=member_pic_url($xx);
			$tmppicpath="$dcrs/_tmp/_tmpmempic-tmp$xx.jpg";
			download_tofile($tmppic,$tmppicpath);
			//echo "download_tofile($tmppic,$tmppicpath);";
			$pic=$tmppicpath;
			if (!file_exists($pic)) {
				$pic="$dcrs/pic/no.jpg";
			}
		}
$cardfirstx=0+$pdf->GetX();
$cardfirsty=0+$pdf->GetY();

	$membertype=getlang($mbtypedb[$r[type]]);

		$pdf->Image("$dcrs/_tmp/cards/_card_back$currentcardtp.jpg",$pdf->GetX(),$pdf->GetY(),$width,$height);
		$pdf->Image("$dcrs/_tmp/cards/_card_front$currentcardtp.jpg",$pdf->GetX()+2+$width,$pdf->GetY(),$width,$height);
		$pdf->SetFont('Tahoma','B',21);
		$pdf->Text($pdf->GetX()+$width+4,$pdf->GetY()+25,iconvth("$cardfronttitle"));
		$pdf->SetFont('Tahoma','',12);
		$pdf->Text($pdf->GetX()+$width+4,$pdf->GetY()+53,iconvth("$name"));
		$pdf->SetFont('Tahoma','',10);
		$pdf->Text($pdf->GetX()+$width+4,$pdf->GetY()+65,iconvth("$membertype"));
		$pdf->SetFont('Tahoma','',0);
		$pdf->Text($pdf->GetX()+$width+4,$pdf->GetY()+110,iconvth("Barcode:$xx"));
		$pdf->Image("$pic",$pdf->GetX()+$width+($picypos),$pdf->GetY()+37,ceil(128/2),ceil(144/2));
		$pdf->SetFont('Tahoma','',12);
		//

		$img="$dcrs/_tmp/bc_$xx.JPG";
		$tmp= Barcode39($xx, $iwidth, $iheight, $quality, "JPEG", 0 ,$img);
$lastx=0+$pdf->GetX();
$lasty=0+$pdf->GetY();
	$pdf->SetXY($lastx+2,$lasty+40);
	$pdf->MultiCell($width+50,20,iconvth($rule));
	$pdf->SetXY($lastx,$lasty);
		$pdf->Image("$img",$pdf->GetX()+$width,$pdf->GetY()+120,$bwidth,$bheight);
$pdf->SetXY($cardfirstx,$cardfirsty);
		$pdf->Cell($width+2+$width,$height,"",$border,1);
		//$pdf->Cell(0,5,"" ,0,1);

		/*
		if ($number==1) {
			$xx= substr("00000000000000000000000000000000$runn",-$digit);
			$pdf->Cell($width,12,"$xx" ,0,"1T",'C');
		}
		*/
		$_y+=round($height+5);
		unlink($img);
		//echo $i;
		$i++;
		if (($i % $perpage)==0 && $i>1) {
			$pdf->_endpage();
			$pdf->AddPage();
			$pdf->SetMargins(10,10);
		    //$pdf->SetCol(0);
		}

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