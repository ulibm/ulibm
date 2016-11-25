<?php 
	; 
	include ("../inc/config.inc.php");
	ptp("holdnotif"); die;


	load_pdf_ini("general");

	$head=getlang("Item Request Slip");
	$body1=getlang("ตามที่ได้มีการขอจองวัสดุสารสนเทศ บัดนี้ได้มีการนำวัสดุสารสนเทศดังกล่าวมาคืนแล้ว::l::As your request for item , now that item returned");
	$body2=getlang("ทางบรรณารักษ์จะเก็บรักษาวัสดุสารสนเทศไว้ระยะเวลาหนึ่ง::l::Librarian will keep item for a period of time");

	$pdf=new PDF("P","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();
	$pdf->SetFont('Tahoma','',10);
	$pdf->Cell(545,120,"". date('d') . " " . $thaimonstr[date('n')] . " " . (date('Y')+543),0,0,'R');

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
	$pdf->SetY(60);
	$pdf->SetFont('Tahoma','B',21);
	$pdf->Cell(545,35," $head ",1,0,'C');
	$pdf->SetXY(27,134);
	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");
	$s=tmq("select * from checkout where id='$id' ");
	$s=tmq_fetch_array($s);
	$pdf->SetFont('Tahoma','',12);
	$pdf->SetXY(27,130);
	$pdf->Cell(545,20,"เรื่อง  หนังสือจอง");
	$pdf->SetXY(27,150);
	$pdf->Cell(545,20,"เรียน ".strip_tags(get_member_name($s[request])));
	$pdf->SetXY(27,170);
	//$pdf->Cell(545,20,"แจ้งครั้งที่ ........");
	$pdf->SetXY(27,210);
	$pdf->MultiCell(545,20,$body1,0,'L');
	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->SetFont('Tahoma','B',12);

				//$pdf->Cell(50,25," ลำดับที่ ",1);
				$pdf->Cell(365,25," รายการ ",1);
				$pdf->Cell(125,25," วันส่ง ",1,0,'R');

	$pdf->SetFont('Tahoma','',12);
		

				$pdf->SetXY(27,$pdf->GetY()+5);


				$pdf->SetXY(27,$pdf->GetY()+20);
				//$pdf->Cell(50,20," $cc ",1);
				$pdf->Cell(365,20,substr($s[mediaName],0,50),1);
				$pdf->Cell(125,20,ymd_datestr($s[edt],'date'),1,0,'R');



	$pdf->SetXY(27,$pdf->GetY()+35);

	$pdf->MultiCell(545,20,$body2,0,'L');
	$pdf->SetXY(27,$pdf->GetY()+20);

$s=tmq("select * from library where UserAdminID='$useradminid' ");
$s=tmq_fetch_array($s);
$libname=$s[UserAdminName];
$mainlib=get_libsite_name($s[libsite]);
	$pdf->SetXY(270,$pdf->GetY()+50);
	$pdf->Cell(545,20,"ลงชื่อ ........................................................",0,'R');
	$pdf->SetXY(270,$pdf->GetY()+20);
	$pdf->Cell(545,20,"    ( ........................................................ )",0,'R');

	$pdf->SetXY(27,$pdf->GetY()+35);
	$pdf->SetFont('Tahoma','',9);
	$pdf->Cell(545,20,"ผู้ออกใบจอง: $libname",0,'R');
	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->Cell(545,20,"". $mainlib,0,'R');



	$pdf->Output();
?>