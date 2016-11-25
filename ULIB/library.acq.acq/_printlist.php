<?php 
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("general-L");

	$body1=barcodeval_get("list-body");

	$pdf=new PDF("L","pt","A4");
	$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
	$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->SetTopMargin(60);
	$pdf->SetAutoPageBreak('On',50);
	$pdf->AddPage();

	//$pdf->Text($pdf->GetX()+246+4,$pdf->GetY()+25,"$head");
	$pdf->SetY(60);
	$pdf->SetFont('Tahoma','',12);
	$pdf->SetXY(50,50);
	$pdf->MultiCell(800,20,$body1,0,'C');
	$pdf->SetFont('Tahoma','',12);
	$pdf->SetXY(25,80);

	$pdf->SetFont('Tahoma','B',12);

	$pdf->Cell(50,25," ".getlang("ลำดับที่::l::No.")." ",1);

	$pdf->Cell(68,25," ".getlang("เลขอ้างอิง::l::ref.code")." ",1);
	$pdf->Cell(635,25," ".getlang("รายการ::l::Item")." ",1);
	$pdf->Cell(40,25," ".getlang("ไม่ได้::l::Not avail.")." ",1,0,'C');
	$pdf->SetXY(25,80+25);

	$pdf->SetFont('Tahoma','',12);
	$sql="select * from acq_mediasent where acq='$ID' order by id asc";
	$result=tmq($sql);
	$cc=0;
		while ($row = tmq_fetch_array($result)) {
			$md=tmq("select * from acq_media where id='$row[media]' ");
			$md=tmq_fetch_array($md);
			$cc++;

			$rowy=$pdf->GetY();
			$rowx=$pdf->GetX();

			$dat="$md[d_titl]";
			if ($md[d_auth]!="") {
				$dat.= " ".getlang("แต่งโดย::l::Author")." $md[d_auth]";
			}
			if ($md[d_isbn]!="") {
				$dat.= " isbn=$md[d_isbn]";
			}
			if ($md[d_yea]!="") {
				$dat.= " ".getlang("ปีพิมพ์::l::Year")."=$md[d_yea]";
			}
			if ($md[d_publ]!="") {
				$dat.= " ".getlang("สำนักพิมพ์::l::Publisher")." $md[d_publ]";
			}
			if ($md[d_edition]!="") {
				$dat.= " ".getlang("พิมพ์ครั้งที่::l::Edition")." $md[d_edition]";
			}
			if ($md[d_mdtype]!="") {
				$dat.= " ".getlang("ประเภทวัสดุ::l::Mat.type")." $md[d_mdtype]";
			}
			if ($md[d_imprint]!="") {
				$dat.= " ($md[d_imprint](";
			}
			//$pdf->Cell(635,25," $dat ",1);
			//$pdf->Cell(793,50,"  ",1);

			$pdf->SetXY(25,$rowy);

			$pdf->Line($pdf->GetX(),$pdf->GetY()-25,$pdf->GetX(),2000);
			$pdf->Cell(50,25," $cc ",0,0,'TC');
			$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),2000);
			$pdf->Cell(68,25," $row[id] ",0);
			$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),2000);
			$pdf->Cell(635,25,"  ",0);
			$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),2000);
			$pdf->Cell(40,25,"  ",0,0,'R');
			$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),2000);

			$pdf->SetX(145);
			$pdf->MultiCell(635,25,$dat,0,'L');
			$pdf->Line(25,$rowy,818,$rowy);
			//$pdf->SetXY($rowx,$rowy);
			//$pdf->MultiCell(635,50," " ,0,'L');
			//$pdf->SetY($rowy);
			$pdf->SetXY(25,$pdf->GetY());
		}


	$pdf->Output();

	die;
?>