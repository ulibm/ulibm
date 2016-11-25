<?php 
	; 
	include ("../inc/config.inc.php");
	include ("./inc.php");

	load_pdf_ini("general");
	 barcode_startupvar();

	$s=tmq("select * from media_place_shelf where id='$shfid' ");
	$s=tmq_fetch_array($s);
	$name=stripslashes(getlang($s[name]));

	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");

	$pdf->SetFont('Tahoma','B',80);

	$pdf->SetXY(30,60);
	//$pdf->Cell(545,20,"select * from media_mid where bcode='$bcode' ");
	$pdf->Cell(535,120,iconvth($name),1,0,'C');
	$pdf->SetXY(30,190);
	$pdf->SetFont('Tahoma','B',45);
	
	$sdescr=local_callndescr($s[startc],$s[callntype]);
	$edescr=local_callndescr($s[endc],$s[callntype]);
	
	$pdf->SetXY(27,$pdf->GetY()+40);
	$pdf->Cell(545,20,iconvth(getlang("ตั้งแต่::l::From")." $s[startc]"));
	$pdf->SetFont('Tahoma','B',12);
	$pdf->SetXY(27,$pdf->GetY()+27);
	$pdf->Cell(545,20,iconvth("$sdescr"));

	$pdf->SetFont('Tahoma','B',45);
	$pdf->SetXY(27,$pdf->GetY()+42);
	$pdf->Cell(545,20,iconvth(getlang("จนถึง::l::to")." $s[endc]"));
	$pdf->SetXY(27,$pdf->GetY()+27);
	$pdf->SetFont('Tahoma','B',12);
	$pdf->Cell(545,20,iconvth("$edescr"));
	
	
	/*
	$pdf->Cell(545,20,"Barcode: $bcode ");
	//end address 
	$pdf->SetXY(27,$pdf->GetY()+20);

		$img="$dcrs/_tmp/bc_$bcode.JPG";
		$iwidth=350; 
		$iheight=40;
		$tmp= Barcode39($bcode, $iwidth, $iheight, $quality, "JPEG", 1 ,$img);
		$pdf->Image("$img",27,$pdf->GetY(),$iwidth,$iheight);
*/

/*
$s=tmq("select * from library where UserAdminID='$useradminid' ");
$s=tmq_fetch_array($s);
$libname=$s[UserAdminName];
$mainlib=get_libsite_name($s[libsite]);
	$pdf->SetXY(270,$pdf->GetY()+50);
	$pdf->Cell(545,20,"      ........................................................",0,'R');
	$pdf->SetXY(270,$pdf->GetY()+20);
	$pdf->Cell(545,20,"    ( ........................................................ )",0,'R');

	$pdf->SetXY(27,$pdf->GetY()+12);
	$pdf->SetFont('Tahoma','',9);
	$pdf->Cell(545,20," ....... / ................. / ................",0,'R');
	$pdf->SetXY(27,$pdf->GetY()+12);
	$pdf->Cell(545,20,getlang("ผู้พิมพ์ใบส่งซ่อม::l::Officer").": $libname",0,'R');
	$pdf->SetXY(27,$pdf->GetY()+12);
	$pdf->Cell(545,20,"". $mainlib,0,'R');
	//$pdf->_endpage();

*/


	$pdf->Output();
?>