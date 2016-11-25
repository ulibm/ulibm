<?php 
	; 
	include ("../inc/config.inc.php");

	load_pdf_ini("general");

$pdf=new PDF("P","pt","A4");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
	$pdf->AddPage();
//round to text page wrap
for ($i=1;$i<=1;$i++) {
	$pdf->SetFont('Tahoma','B',16);
	$pdf->Cell(535,30,iconvth("รายชื่อผู้ค้างส่งทรัพยากรห้องสมุด"),1,0,'C');

	$pdf->SetXY(27,$pdf->GetY()+50);


$source_db=tmq("select * from holdlong_notif where setid='$setid' order by memid",false);
	$pdf->SetFont('Tahoma','',10);
	$pdf->Cell(545,10,iconvth("". date('d') . " " . $thaimonstr[date('n')] . " " . (date('Y')+543)),0,0,'R');

while ($source_dbr=tmq_fetch_array($source_db)) {
	$id=$source_dbr[memid];
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$s=tmq("select * from member where UserAdminID='$id' ");
	$s=tmq_fetch_array($s);
	$address1=$s[address];
	$address2=$s[address2];


	$pdf->SetFont('Tahoma','B',11);

	$pdf->SetXY(27,$pdf->GetY()+5);
	$dspuname="$s[prefi] $s[UserAdminName] ($id)";
	if (trim($dspuname)=="" ) {
		$dspuname="ไม่พบสมาชิก [$id]";
	}
	$pdf->Cell(545,20,iconvth("$dspuname"));
	//end address 
	$pdf->SetXY(27,$pdf->GetY()+0);
	//$pdf->Text($pdf->GetX(),$pdf->GetY(),"$body");

	$pdf->SetFont('Tahoma','',11);
	$pdf->SetXY(27,$pdf->GetY()+20);
	$pdf->SetFont('Tahoma','B',12);

				$pdf->Cell(50,25,iconvth(" ลำดับที่ "),1);
				$pdf->Cell(365,25,iconvth(" รายการ "),1);
				$pdf->Cell(125,25,iconvth(" กำหนดส่ง "),1,0,'R');

	$pdf->SetFont('Tahoma','',12);
				$sql="select * from checkout where hold='$id' and allow='yes' and returned='no' order by id asc";
		$result=tmq($sql);
		$cc=0;
				$pdf->SetXY(27,$pdf->GetY()+5);
		while ($row = tmq_fetch_array($result)) {
			$tmpdecis=getduedecis($row[mediaId], date("j"), date("n"), date("Y"));
			//if ($tmpdecis>0) {
			if (true) {
				$cc++;
				$pdf->SetXY(27,$pdf->GetY()+20);
				$pdf->Cell(50,20,iconvth(" $cc "),1);
				$pdf->Cell(365,20,(substr("".iconvth($row[mediaName]),0,50)),1);
				$pdf->Cell(125,20,iconvth("$row[edat] " . $thaimonstr[$row[emon]] . " $row[eyea]"),1,0,'R');

			}
		}

	$pdf->SetXY(27,$pdf->GetY()+20);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}


}
	$pdf->SetXY(27,$pdf->GetY()+20);

$s=tmq("select * from library where UserAdminID='$useradminid' ");
$s=tmq_fetch_array($s);
$libname=$s[UserAdminName];
$mainlib=get_libsite_name($s[libsite]);
	$pdf->SetXY(270,$pdf->GetY()+30);
	$pdf->Cell(545,20,iconvth("ลงชื่อ ........................................................"),0,'R');
	$pdf->SetXY(270,$pdf->GetY()+20);
	$pdf->Cell(545,20,"    ( ........................................................ )",0,'R');

	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->SetFont('Tahoma','',9);
	$pdf->Cell(545,20,iconvth("ผู้พิมพ์ประกาศ: $libname"),0,'R');
	$pdf->SetXY(27,$pdf->GetY()+10);
	$pdf->Cell(545,20,iconvth("". $mainlib),0,'R');


	//$pdf->_endpage();
	$pdf->Output();
?>