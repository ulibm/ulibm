<?php 
;
 include("../../inc/config.inc.php");
 ////////////
load_pdf_ini("barcode-singlecolumn");
//////////////

$pdf=new PDF("P","pt","A4");
$pdf->AddPage();
		$pdf->Cell(490,155,"" ,$border,1);
$txt="ทดสอบภาษาไทย สะระเอีย ด์ร์ก์";
if ($handle = opendir('./font/')) {

    /* This is the correct way to loop over the directory. */
	$c=0;
    while (false !== ($file = readdir($handle))) {
		$t=explode('\.',$file);
		if (strtoupper($t[count($t)-1])=="PHP") {
			$c++;
			if ($c<10) {
				$fontname=$t[0];
				//echo "<B>".$t[count($t)-1]."</B>$file<BR>\n";
				$pdf->AddFont("$fontname",'',"$file");
				$pdf->SetFont("$fontname",'',25);
				$pdf->Cell(500,40," $fontname $file $txt" ,1,1);
			}
		}
    }
} else {
	echo "nofontdir";
}
	$pdf->Output();

?>