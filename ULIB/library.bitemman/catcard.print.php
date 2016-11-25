<?php 
;
 include("../inc/config.inc.php");
 include("./fpdfclone.php");
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
////
$data=tmq("select * from catcard where id='$id' ");
$data=tmq_fetch_array($data);
//printr($data);
$paperw=$data[w];
$paperh=$data[h];
$papersize="ulib";
$percolumn=8;///
$result=tmq("select distinct pid from media_mid where ismarked='YES'  ");
$allbccount=(tmq_num_rows($result));


$pdf=new FPDFCLONE("P","pt","$papersize");

$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
//$pdf->Cell(40,10,'Hello World!');


$NRow = ($allbccount);
if($NRow >0) { 


	while ($r=tmq_fetch_array($result)) {
		$pdf->AddPage();
		$pdf->SetMargins(0,0);
		$pdf->SetY(0);
		
		$fontsize=9;
		$pdf->SetFont('Tahoma','',$fontsize);
		$pdf->SetLineWidth(0.3);
		$pdf->SetDrawColor(100,100,100);
		$pdf->Ln(1.5);
		$pdf->SetX(10);
		$pdf->SetY(10);
		//$pdf->Cell(0,5,"$row - $column",0,1);
		$datause=$data[data];
		$mm=marc_melt($r[pid]);
		@reset($mm);
		while (list($k,$v)=each($mm)) {
			if (strlen($k)!=6 || floor($k)!=0) { continue; }
			$replacesubfields="";
			if ($k=="tag650") {
				$replacesubfields="--";
			}
			$mm[$k]=substr($mm[$k],2);
			$mm[$k]=dspmarc($mm[$k],$replacesubfields);
			if (floor($mm[$k."_num"])>1) {
				$thisround=1;
				while ($thisround<=floor($mm[$k."_num"])) {
					//echo("\$tmp=\$r_$thisround"."[$k];");
					eval("\$tmp=\$r_$thisround"."[$k];");
					//echo $tmp;
					$tmp=substr($tmp,2);
					$tmp=dspmarc($tmp,$replacesubfields);
					$mm[$k]=$mm[$k]. ",". $tmp;
					$thisround=$thisround+1;
				}
			}
			$mm[$k]=trim($mm[$k]);
			$mm[$k]=trim($mm[$k],",-");
			$mm[$k]=str_replace(",,",",",$mm[$k]);
			$mm[$k]=str_replace(",--",", ",$mm[$k]);
			//echo "$k=".$mm[$k]."<br>";
			$datause=str_replace("\$data[$k]","$mm[$k]",$datause);
		}
		//die;
		//printr($mm);
		//echo "<pre>$datause</pre>";
		$pdf->MultiCell($paperw, $fontsize+3, iconvth($datause), 0, 'J', false);


		//die;
	}
} else {
	$pdf->SetXY(100,100);
	$pdf->Cell(0,5,iconvth("กรุณาระบุบาร์โค้ดที่ต้องการพิมพ์"),0,1);
}

	local_operationdotline();

$pdf->Output();
?>