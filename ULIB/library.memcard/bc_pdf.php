<?php 
;
 include("../inc/config.inc.php");
 include("./fpdfclone.php");
$submittype =trim($submittype );
$submittype =strtolower($submittype );
$submittype =str_replace(" ","",$submittype );


function local_operationdotline() {
	global $adddotline;
	if (strtolower($adddotline)!="yes") {
		return;
	}
	global $pdf;
	global $setcols;
	global $setrows;
	global $xdist;
	global $ydist;
	global $marginleft;
	global $margintop;
	global $paperh;
	global $paperw;
	global $margin;
	///operation dotline - before add page
		for ($doti=1;$doti<$setcols;$doti++) {
			/*$pdf->Line(($xdist*$doti)+($marginleft),0  ,  
							  ($xdist*$doti)+($marginleft),$paperh);*/
			for ($dotii=0;$dotii<$paperh;$dotii=$dotii+6) {
				$pdf->Line(($xdist*$doti)+($marginleft),$dotii  ,  
				  ($xdist*$doti)+($marginleft),$dotii+3);
			}
		}
		for ($doti=1;$doti<$setrows;$doti++) {
			/*
			$pdf->Line(0,($ydist*$doti)+($margintop)  ,  
							  $paperw,($ydist*$doti)+($margintop));*/
			for ($dotii=0;$dotii<$paperw;$dotii=$dotii+6) {
				$pdf->Line($dotii,($ydist*$doti)+($margintop)  ,  
				  $dotii+3,($ydist*$doti)+($margintop));
			}
		}
}
 ////////////
//$colnum=1;
//load_pdf_ini("barcode-singlecolumn");
$colnum=2;
//load_pdf_ini("barcode");
	include("./ini.blockbarcode.php");
/////////////
if ($save=='yes') {
	barcodeval_set("BARCODE-memcardbc-sizefac",$sizefac);
	barcodeval_set("BARCODE-memcardbc-margintop",$margintop);
	barcodeval_set("BARCODE-memcardbc-marginleft",$marginleft);
	barcodeval_set("BARCODE-memcardbc-marginright",$marginright);
	barcodeval_set("BARCODE-memcardbc-marginbottom",$marginbottom);
	barcodeval_set("BARCODE-memcardbc-paperw",$paperw);
	barcodeval_set("BARCODE-memcardbc-paperh",$paperh);
	barcodeval_set("BARCODE-memcardbc-setrows",$setrows);
	barcodeval_set("BARCODE-memcardbc-setcols",$setcols);
	barcodeval_set("BARCODE-memcardbc-allbc",$allbc);
	barcodeval_set("BARCODE-memcardbc-addblank",$addblank);
	barcodeval_set("BARCODE-memcardbc-margin",$margin);
	barcodeval_set("BARCODE-memcardbc-setxdist",$setxdist);
	barcodeval_set("BARCODE-memcardbc-setydist",$setydist);
	barcodeval_set("BARCODE-memcardbc-font",$font);
	barcodeval_set("BARCODE-memcardbc-adddotline",$adddotline);
	@reset($bctype);
	tmq("delete from barcode_valmem where classid like 'BARCODE-memcardbc-bctype-%' ");
	tmq("delete from barcode_val where classid like 'BARCODE-memcardbc-bctype-%' ");
	while (list($k,$v)=@each($bctype)) {
		barcodeval_set("BARCODE-memcardbc-bctype-$k","yes");
	}

}


function local_addbox($id) {
	
}
/////////////
$papersize="ulib";
$percolumn=8;///
$allbc=barcodeval_get("BARCODE-memcardbc-allbc");///
$allbc=trim($allbc);

$pdf=new FPDFCLONE("P","pt","$papersize");

$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
$pdf->AddPage();
$pdf->SetMargins(0,0);
$pdf->SetY(0);

$pdf->SetFont('Tahoma','',9);
$pdf->SetLineWidth(0.3);
$pdf->SetDrawColor(100,100,100);
//$pdf->Cell(40,10,'Hello World!');

$result=explodenewline($allbc);
$NRow = count($result);
if($NRow >0) { 

	//add for each bctype (s)
	@reset($result);
	$resultuse=Array();
	while (list($k,$v)=@each($result)) {
		@reset($bctype);
		if (trim($v)=="") {$resultuse[]="[addblank]"; continue;}
		while (list($bk,$bv)=@each($bctype)) {
			//if (trim($v)=="") {continue;}
			$resultuse[]="$bk:::$v";
		}
	}
	for ($i=0;$i<$addblank;$i++) {
		array_unshift($resultuse,"[addblank]");
	}
	@reset($resultuse);
	$row=1;
	$column=0;
	while (list($k,$v)=@each($resultuse)) {
		if ($column==$setcols) {
			$column=0;
			if ($row==$setrows) {
				$row=1;
				local_operationdotline();

				//add new page
				$pdf->_endpage();
				$pdf->AddPage();
				$pdf->SetMargins(0,0);
			} else {
				$row++;
				$column=0;
			}
		} else {
			//$row++;
		}
		$column++;
		$paperwuse=$paperw-($marginleft+$marginright);
		$paperhuse=$paperh-($marginbottom+$margintop);
		
		$xdist=($paperwuse/$setcols);
		$ydist=($paperhuse/$setrows);


		//echo "paperwuse=$paperwuse /setcols=$setcols = $xdist<BR>";
		//echo "ydist=$ydist /xdist=$xdist <BR>";
		$pdf->SetX($xdist*$column);
		$pdf->SetY($ydist*$row);
		//$pdf->Cell(0,5,"$row - $column",0,1);
		$bcinfo=explode(':::',$v);
		//printr($bcinfo);
		if ($bcinfo[0]=="[addblank]") {
			//$pdf->Text($xdist*($column-1),$ydist*($row-1),trim("-blank-") );
			continue;
		}
      //printr($bcinfo); die;
		$bcgenmode="$bcinfo[0]";
		$barcodeBC="$bcinfo[1]";
		include("bcgen.php");

	//echo "paperw=$paperw / column=$column / xdist=$xdist <HR>";
		//$xdist=$paperw/$setcols;//198;
		//$ydist=$paperh/$setrows;//107.55;

		//$pdf->Image("$barcodeoutput_dcrs",floor(($xdist*($column-1))+$margin)+$marginleft,floor(($ydist*($row-1))+$margin)+$margintop,floor($xdist-($margin*2)),floor($ydist-($margin*2)));
		$pdf->Image("$barcodeoutput_dcrs",(($xdist*($column-1))+$margin)+$marginleft,(($ydist*($row-1))+$margin)+$margintop,($xdist-($margin*2)),($ydist-($margin*2)));
		//$pdf->Text($xdist*($column-1),$ydist*($row-1),trim("$xdist*($column-1),$ydist*($row-1)") );
		//$pdf->Text($xdist*($column-1),$ydist*($row-1),trim("$v") );
      //die($barcodeoutput_dcrs);
      @unlink($barcodeoutput_dcrs);
      //echo $outputfile;
	}
} else {
	$pdf->SetXY(100,100);
	$pdf->Cell(0,5,"กรุณาระบุบาร์โค้ดที่ต้องการพิมพ์",0,1);
}

	local_operationdotline();

$pdf->Output();
?>