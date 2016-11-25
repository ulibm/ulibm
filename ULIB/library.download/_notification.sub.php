<?php 
	$pdf->SetFont('Tahoma','B',11);

	$pdf->SetXY(180,50+60);
	$dspuname="$s[prefi] $s[UserAdminName]";
	if (trim($dspuname)=="" ) {
		$dspuname="ไม่พบสมาชิก [$id]";
	}
	$pdf->Cell(545,20,iconvth("$dspuname"));
	$pdf->SetXY(180,50+75);
	$pdf->Cell(545,20,iconvth("$address1"));
	$pdf->SetXY(180,50+90);
	$pdf->Cell(545,20,iconvth("$address2 "));
	//end address 
	$pdf->SetXY(27,134+0);
	$pdf->SetFont('Tahoma','',10);
	$pdf->Cell(545,120,iconvth("". date('d') . " " . $thaimonstr[date('n')] . " " . (date('Y')+543)),0,0,'R');
	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");
	$startbodyy=70;

	$pdf->SetFont('Tahoma','',11);
	$pdf->SetXY(27,$startbodyy+130);
	$pdf->Cell(545,20,iconvth("เรื่อง  $head"));
	$pdf->SetXY(27,$startbodyy+150);
	$memtype=tmq("select * from member_type where type='$s[type]'");
	$memtype=tfa($memtype);
	$pdf->Cell(545,20,iconvth("เรียน  คุณ $s[UserAdminName] ($id-$memtype[descr])"));
	$pdf->SetXY(27,$startbodyy+170);
	$pdf->Cell(545,20,iconvth("แจ้งครั้งที่ ........"));
	$pdf->SetXY(27,$startbodyy+210);
	$pdf->MultiCell(545,15,iconvth($body1),0,'L');
	$pdf->SetXY(27,$pdf->GetY()+5);
	$pdf->SetFont('Tahoma','B',12);

				$pdf->Cell(50,25,iconvth(" ลำดับที่ "),1);
				$pdf->Cell(365,25,iconvth(" รายการ "),1);
				$pdf->Cell(125,25,iconvth(" วันยืม-ส่ง "),1,0,'R');

	$pdf->SetFont('Tahoma','',10);
				$sql="select * from checkout where hold='$id' and allow='yes' and returned='no' order by id asc";
		$result=tmq($sql);
		$cc=0;
				$pdf->SetXY(27,$pdf->GetY()+5);
		while ($row = tmq_fetch_array($result)) {
			$tmpdecis=getduedecis($row[mediaId], date("j"), date("n"), date("Y"));
			//if ($tmpdecis>0) {
				$cc++;
				$pdf->SetXY(27,$pdf->GetY()+20);
				$pdf->Cell(50,20," $cc ",1);
				$pdf->Cell(365,20,iconvth($row[mediaId]).":".substr(trim(iconvth($row[mediaName])),0,55),1);
				$pdf->SetFont('Tahoma','',10);
				$pdf->Cell(125,20,iconvth("$row[sdat] " . $thaimonstrbrief[$row[smon]] . " $row[syea] - $row[edat] " . $thaimonstrbrief[$row[emon]] . " $row[eyea]"),1,0,'R');
				$pdf->SetFont('Tahoma','',10);
		}

	$pdf->SetXY(27,$pdf->GetY()+30);

	$pdf->MultiCell(550,15,iconvth($body2),0,'L');
	$pdf->SetXY(27,$pdf->GetY()+20);

$s=tmq("select * from library where UserAdminID='$useradminid' ");
$s=tmq_fetch_array($s);
$libname=$s[UserAdminName];
$mainlib=get_libsite_name($s[libsite]);
	$pdf->SetXY(270,$pdf->GetY()+30);
	$pdf->Cell(545,20,iconvth("ลงชื่อ ........................................................"),0,'R');
	$pdf->SetXY(270,$pdf->GetY()+20);
	$pdf->Cell(545,20,iconvth("    ( ........................................................ )"),0,'R');

	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->SetFont('Tahoma','',9);
	$pdf->Cell(545,20,iconvth("ผู้ออกหนังสือทวงถาม: $libname"),0,'R');
	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->Cell(545,20,"". iconvth($mainlib),0,'R');
	//$pdf->_endpage();

?>