<?php 
    ;
     include("../inc/config.inc.php");

ptp("fine");

die;
/// below is deprecated



 ////////////
load_pdf_ini("fine-common");
//////////////
$papersize=getval("BARCODE","papersize");

$pdf=new PDF("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
$pdf->AddPage();

$finedoneinfo=tmq("select * from finedone where idid='$id' ");
$finedoneinfo=tmq_fetch_array($finedoneinfo);


$s=tmq("select * from member where UserAdminID='$memberbarcode' ");
$s=tmq_fetch_array($s);
		$pdf->SetFont('Tahoma','',11);
		$pdf->Cell(200,60,"".getlang("หมายเลขใบเสร็จ::l::ref.number").": $id",0,0,'L');
		$pdf->Cell(340,60,"". $finedoneinfo[dat] . " " . $thaimonstr[$finedoneinfo[mon]] . " " . ($finedoneinfo[yea]+543),0,0,'R');
		$pdf->SetY($pdf->GetY()+45);
		$backx=$pdf->GetX();
		$backy=$pdf->GetY();
		$pdf->SetXY($backx,$backy);

		$pdf->Cell(540,48,"",1);
		$pdf->SetY($pdf->GetY());
		$pdf->SetFont('Tahoma','B',14);
		$pdf->Cell(100,25," ".getlang("สมาชิก::l::Member").": ",0);
		$pdf->SetFont('Tahoma','',14);
		$pdf->Cell(500,25,"$s[UserAdminName]",0);
		$pdf->SetY($pdf->GetY()+20);
		$pdf->SetFont('Tahoma','B',14);
		$pdf->Cell(100,25," ".getlang("บาร์โค้ด::l::Barcode").": ",0);
		$pdf->SetFont('Tahoma','',14);
		$pdf->Cell(500,25,"$s[UserAdminID]",0);
		
		$pdf->SetFont('Tahoma','B',14);
		$pdf->SetXY(27,155);
		$pdf->Cell(90,25," ".getlang("ลำดับที่::l::No.")." ",1);
		$pdf->Cell(350,25," ".getlang("รายการ::l::Fine")." ",1);
		$pdf->Cell(100,25," ".getlang("จำนวน::l::Amount")." ",1,0,'R');

  $sql ="select * from fine where memberId='$s[UserAdminID]' and idid='$id'";

			  $result = tmq($sql);
			//$tmp=tmq_fetch_array($result);
//			$ccccc= $tmp[cach];
			$Num = tmq_num_rows($result); 
			$pdf->SetX(25);
			$pdf->SetY(180);
			if ($Num==0) {
				$pdf->Text($pdf->GetX(),$pdf->GetY()+25,"".getlang("ไม่มีค่าปรับสำหรับสมาชิก::l::No fine for")." $memberbarcode-$s[UserAdminName]");
			}
          $allfine = 0;
          $cc=0;
		
		while ($row = tmq_fetch_array($result)) {
			$cc++;
			$id=$row[id];
			$topic=$row[topic];
			$fine=$row[fine];

			$pdf->SetFont('Tahoma','',14);
			$pdf->Cell(90,20,"$cc ",1);
			$pdf->Cell(350,20,substr("$row[fdat]/$row[fmon]/$row[fyea]-$topic ",0,50),1);
			$pdf->Cell(100,20," " .number_format($fine) ." ".getlang("บาท::l::baht")."  ",1,0,'R');
			$pdf->SetX(25);
			$pdf->SetY($pdf->GetY()+20);

			$allfine=$allfine+$fine;
		}

			$pdf->SetX(25);
			$pdf->SetY($pdf->GetY()+30);
			$pdf->SetFont('Tahoma','B',15);

			$pdf->Cell(550,25," ".getlang("รวม::l::Total")." " . number_format($allfine) . " ".getlang(" บาท ชำระโดยเงิน::l:: Baht , paid")." " . number_format($finedoneinfo[cach]) ." ".getlang("บาท และ::l::Baht and")." $finedoneinfo[credit] ".getlang("credit"),0,0,'R');

			$pdf->SetX(25);
			$pdf->SetY($pdf->GetY()+30);
			$pdf->SetFont('Tahoma','',15);

			$pdf->SetY($pdf->GetY()+40);
			$pdf->Cell(490,25," ".getlang("ชำระเงินเรียบร้อยแล้ว::l::Record processed")."",0,0,'R');
			$pdf->SetY($pdf->GetY()+44);
			$pdf->Cell(540,25," ___________________________",0,0,'R');
			$pdf->SetY($pdf->GetY()+30);
			$pdf->Cell(550,25," (...................................................)",0,0,'R');

$s=tmq("select * from library where UserAdminID='$finedoneinfo[lib]' ");
$s=tmq_fetch_array($s);
$libname=get_library_name($s[UserAdminID]);//$s[UserAdminName];

$mainlib=get_libsite_name($s[libsite]);
			$pdf->SetY($pdf->GetY()+20);
			$pdf->SetFont('Tahoma','',11);
			$pdf->Cell(550,25,"".getlang("รับชำระโดย::l::Librarian")." $libname, $mainlib",0,0,'R');

  		  $pdf->Output();
		  die;
        
       echo "<tr><td colspan=20 align=right>".getlang("รวม::l::Total")." " . number_format($allfine) . " ".getlang("บาท::l::Baht")." 
".getlang("ชำระจริง::l::Paid")." " . number_format($ccccc) 
." ".getlang("บาท::l::Baht")."</td></tr>";          

      echo "</table>"; 
//      echo "<a href='fine.php?memberbarcode=$memberbarcode&payment=yes'>ชำระรายการด้านบน</a>";

   
?>