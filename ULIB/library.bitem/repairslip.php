<?php 
	; 
	include ("../inc/config.inc.php");
ptp("repairslip");
die;












	load_pdf_ini("general");
	 barcode_startupvar();

	$s=tmq("select * from media_mid where bcode='$bcode' ");
	$s=tmq_fetch_array($s);
	$mid=$s[pid];
	$mdtype=$s[RESOURCE_TYPE];
	$mdtypename=iconvth(get_media_type($s[RESOURCE_TYPE]));
	$mdtitle=iconvth(marc_gettitle($mid));
	$calln=iconvth(marc_getmidcalln($bcode));


	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");

	$pdf->SetFont('Tahoma','B',11);

	$pdf->SetXY(180,60);
	//$pdf->Cell(545,20,"select * from media_mid where bcode='$bcode' ");
	$pdf->Cell(545,20,iconvth(getlang("ใบส่งซ่อม::l::repair slip")));
	$pdf->SetXY(27,$pdf->GetY()+20);
	$pdf->Cell(545,20,"Title: $mdtitle");
	$pdf->SetXY(27,$pdf->GetY()+20);
	$pdf->Cell(545,20,"Call number: $calln ");
	$pdf->SetXY(27,$pdf->GetY()+20);
	$pdf->Cell(545,20,"Barcode: $bcode ");
	//end address 
	$pdf->SetXY(27,$pdf->GetY()+20);

		$img="$dcrs/_tmp/bc_$bcode.JPG";
		$iwidth=350; 
		$iheight=40;
		$tmp= Barcode39($bcode, $iwidth, $iheight, $quality, "JPEG", 1 ,$img);
		$pdf->Image("$img",27,$pdf->GetY(),$iwidth,$iheight);


$s=tmq("select * from library where UserAdminID='$useradminid' ");
$s=tmq_fetch_array($s);
$libname=iconvth($s[UserAdminName]);
$mainlib=iconvth(get_libsite_name($s[libsite]));
	$pdf->SetXY(270,$pdf->GetY()+50);
	$pdf->Cell(545,20,"      ........................................................",0,'R');
	$pdf->SetXY(270,$pdf->GetY()+20);
	$pdf->Cell(545,20,"    ( ........................................................ )",0,'R');

	$pdf->SetXY(27,$pdf->GetY()+12);
	$pdf->SetFont('Tahoma','',9);
	$pdf->Cell(545,20," ....... / ................. / ................",0,'R');
	$pdf->SetXY(27,$pdf->GetY()+12);
	$pdf->Cell(545,20,iconvth(getlang("ผู้พิมพ์ใบส่งซ่อม::l::Officer")).": $libname",0,'R');
	$pdf->SetXY(27,$pdf->GetY()+12);
	$pdf->Cell(545,20,"". $mainlib,0,'R');
	//$pdf->_endpage();




	$pdf->Output();
?>