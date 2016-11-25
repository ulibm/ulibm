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
	barcodeval_set("BARCODE-blockbc-sizefac",$sizefac);
	barcodeval_set("BARCODE-blockbc-margintop",$margintop);
	barcodeval_set("BARCODE-blockbc-marginleft",$marginleft);
	barcodeval_set("BARCODE-blockbc-marginright",$marginright);
	barcodeval_set("BARCODE-blockbc-marginbottom",$marginbottom);
	barcodeval_set("BARCODE-blockbc-paperw",$paperw);
	barcodeval_set("BARCODE-blockbc-paperh",$paperh);
	barcodeval_set("BARCODE-blockbc-setrows",$setrows);
	barcodeval_set("BARCODE-blockbc-setcols",$setcols);
	barcodeval_set("BARCODE-blockbc-allbc",$allbc);
	barcodeval_set("BARCODE-blockbc-addblank",$addblank);
	barcodeval_set("BARCODE-blockbc-margin",$margin);
	barcodeval_set("BARCODE-blockbc-setxdist",$setxdist);
	barcodeval_set("BARCODE-blockbc-setydist",$setydist);
	barcodeval_set("BARCODE-blockbc-font",$font);
	barcodeval_set("BARCODE-blockbc-adddotline",$adddotline);
	@reset($bctype);
	tmq("delete from barcode_valmem where classid like 'BARCODE-blockbc-bctype-%' ");
	tmq("delete from barcode_val where classid like 'BARCODE-blockbc-bctype-%' ");
	while (list($k,$v)=@each($bctype)) {
		barcodeval_set("BARCODE-blockbc-bctype-$k","yes");
	}
	barcodeval_set("BARCODE-blockbc-color",$color);
}

if ($submittype =="savetemplate") {
	tmq("delete from barcode_valmem");

	$templatename=addslashes($templatename);
	tmq("delete from blockbarcode_tp where name='$templatename' ");
	$s=tmq("select * from barcode_val where classid like '%blockbc%' ");
	$res=Array();
	while ($r=tfa($s)) {
		$res[$r[classid]]=$r[val];
	}
	$res=serialize($res);
	//echo $res;
	$res=addslashes($res);
	$now=time();
	tmq("insert into blockbarcode_tp set name='$templatename',dt='$now' ,data='$res',loginid='".$_SESSION["useradminid"]."' ");
	?><script type="text/javascript">
	<!--
		window.opener.location.reload(false);
		self.close();
	//-->
	</script><?php 
	die;
}

function local_addbox($id) {
	
}
/////////////
$papersize="ulib";
$percolumn=8;///
$allbc=barcodeval_get("BARCODE-blockbc-allbc");///
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
$result=arr_filter_remnull($result);
//printr($result);
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
      //echo "list($k,$v)<BR>";
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
		$bcgenmode="$bcinfo[0]";
		$barcodeBC="$bcinfo[1]";
		include("bcgen.php");
      //echo "[$bcgenmode:$barcodeBC]<BR>";
	//echo "paperw=$paperw / column=$column / xdist=$xdist <HR>";
		//$xdist=$paperw/$setcols;//198;
		//$ydist=$paperh/$setrows;//107.55;

		//$pdf->Image("$barcodeoutput_dcrs",floor(($xdist*($column-1))+$margin)+$marginleft,floor(($ydist*($row-1))+$margin)+$margintop,floor($xdist-($margin*2)),floor($ydist-($margin*2)));
		$pdf->Image("$barcodeoutput_dcrs",(($xdist*($column-1))+$margin)+$marginleft,(($ydist*($row-1))+$margin)+$margintop,($xdist-($margin*2)),($ydist-($margin*2)));
		//$pdf->Text($xdist*($column-1),$ydist*($row-1),trim("$xdist*($column-1),$ydist*($row-1)") );
		//$pdf->Text($xdist*($column-1),$ydist*($row-1),trim("$v") );
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