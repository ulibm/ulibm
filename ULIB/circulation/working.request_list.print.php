<?php 
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("general");

	$head=getlang("Request Slip");
	$body1=getlang("ตามที่ได้มีการขอจองวัสดุสารสนเทศ บัดนี้ทางบรรณารักษ์ได้รับทราบ และจัดเตรียมทรัพยากรไว้ให้แล้ว::l::As your request for item , now librarian prepared the item you requested");
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
	$pdf->Cell(545,35,iconvth(" $head "),1,0,'C');
	$pdf->SetXY(27,134);
	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");
	$s=tmq("select * from request_list where id='$id' ");
	$s=tmq_fetch_array($s);
	$pdf->SetFont('Tahoma','',12);
	$pdf->SetXY(27,130);
	$pdf->Cell(545,20,iconvth("เรื่อง  หนังสือจอง"));
	$pdf->SetXY(27,150);
	$pdf->Cell(545,20,iconvth("เรียน ".strip_tags(get_member_name($s[memberid]))));
	$pdf->SetXY(27,170);
	//$pdf->Cell(545,20,"แจ้งครั้งที่ ........");
	$pdf->SetXY(27,210);
	$pdf->MultiCell(545,20,iconvth($body1),0,'L');
	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->SetFont('Tahoma','B',12);

				//$pdf->Cell(50,25," ลำดับที่ ",1);
				$pdf->Cell(365,25,iconvth(" รายการ "),1);
				$pdf->Cell(125,25,iconvth(" วันส่งคำขอ "),1,0,'R');

	$pdf->SetFont('Tahoma','',11);
		

				$pdf->SetXY(27,$pdf->GetY()+5);

$mediaid=tmq("select * from media_mid where bcode='$s[itemid]' ",false);
$mediaid=tmq_fetch_array($mediaid);
//printr($mediaid);
				$pdf->SetXY(27,$pdf->GetY()+20);
				//$pdf->Cell(50,20," $cc ",1);
				$pdf->Cell(365,20,iconvth("[$s[itemid]]".mb_substr(marc_gettitle($mediaid[pid]),0,45).'..'),1);
				$pdf->Cell(125,20,iconvth(ymd_datestr($s[dt],'date')),1,0,'R');



	$pdf->SetXY(27,$pdf->GetY()+35);

	$pdf->MultiCell(545,20,iconvth($body2),0,'L');
	$pdf->SetXY(27,$pdf->GetY()+20);

$s=tmq("select * from library where UserAdminID='$useradminid' ");
$s=tmq_fetch_array($s);
$libname=$s[UserAdminName];
$mainlib=get_libsite_name($s[libsite]);
	$pdf->SetXY(270,$pdf->GetY()+50);
	$pdf->Cell(545,20,iconvth("ลงชื่อ ........................................................"),0,'R');
	$pdf->SetXY(270,$pdf->GetY()+20);
	$pdf->Cell(545,20,"    ( ........................................................ )",0,'R');

	$pdf->SetXY(27,$pdf->GetY()+35);
	$pdf->SetFont('Tahoma','',9);
	$pdf->Cell(545,20,iconvth("ผู้ออกใบแจ้ง: $libname"),0,'R');
	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->Cell(545,20,"". iconvth($mainlib),0,'R');



	$pdf->Output();
?>