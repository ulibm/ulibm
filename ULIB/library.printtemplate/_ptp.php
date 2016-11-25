<?php  //พ

 include_once($dcrs."library.printtemplate/fpdfclone.php");
 include_once($dcrs."library.printtemplate/_ptp.defineclass.php");
 include_once($dcrs."library.printtemplate/_ptp.local_compilevar.php");

//printr($_POST);
$pid=str_replace("FOOT::","",$pid);


if ($compilevar=="yes") {
	$fineid=trim($fineid);
	if ($fineid!="") {
		$fine=tmq("select * from finedone where idid='$fineid' ",false);
		$fine=tmq_fetch_array($fine);
		$finedoneinfo=tmq("select * from finedone where idid='$fineid' ");
		$finedoneinfo=tmq_fetch_array($finedoneinfo);
	}
	$memberbarcode=trim($memberbarcode);
	if ($memberbarcode!="") {
		$member=tmq("select * from member where UserAdminID='$memberbarcode' ");
		$member=tmq_fetch_array($member);
	}
}
$parent=tmq("select * from printtemplate_sub where code='$pid' ",false);
$parent=tfa($parent);
//printr($parent);
$copyno=floor($parent[copyno]);
$cate=tmq("select * from printtemplate where code='$parent[pid]' ");
$cate=tfa($cate);
//printr($parent);
$paperw=$parent[w];
$paperh=$parent[h];
//$paperw=($paperw/25.4)*72;
//$paperh=($paperh/25.4)*72;
//echo "[$paperw/$paperh]";
$colnum=1;

//include($dcrs."library.printtemplate/ini.blockbarcode.php");

$papersize="ulib";

//$pdf=new FPDFCLONE("P","pt","$papersize");
$pdf= new paperpdf("P","pt","$papersize");
$pdf->AddFont('Tahoma','',"tahoma.ttf.php");
$pdf->AddFont('Tahoma','B',"tahomabd.ttf.php");
for ($copynoi=1;$copynoi<=$copyno;$copynoi++) {
	////////////////// page s
$pdf->AddPage();
$pdf->SetMargins(0,0);
$pdf->SetY(0);
$pdf->SetX(0);

$pdf->SetFont('Tahoma','',10);
$pdf->SetLineWidth(0.3);
$pdf->SetDrawColor(100,100,100);

$s=tmq("select * from printtemplate_sub_i where pid='$pid' order by ordr ",false);
$currenty=0;
while ($r=tfa($s)) {
	//echo "[".$pdf->GetY()."<br>";
	$pos=explode(";",$r[pos]);
	//printr($pos);
	//$pos[0]=$pos[0]*$_MMTOPX;
	//printr($pos);
	//$pos[0]=100;
	$pdf->SetY(floor($pos[1]));
	$pdf->SetX(floor($pos[0]));
	//$pdf->SetXY(floor($pos[1]),floor($pos[0]));
	if ($r[type1]=="string") {
		$pdf->SetFont('Tahoma','',$r[string_fontsize]);
		//echo $r[string_align];
		$r[data]=str_replace("[ROOMWORD]",$_ROOMWORD,$r[data]);
		$r[data]=str_replace("[FACULTYWORD]",$_FACULTYWORD,$r[data]);

		$pdf->MultiCell($pos[2],  floor($r[string_fontsize])+2, iconvth($r[data]) ,0,"$r[string_align]");
	}
	if ($r[type1]=="image") {
		//($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
      $tmpimgfile=$dcrs."_tmp/printtemplate_img/$r[id].jpg";
      if (!file_exists($tmpimgfile)) {
         $tmpimgfile=$dcrs."library.printtemplate/defimg.jpg";
      }
		$pdf->Image($tmpimgfile,$pos[0],$pos[1],$pos[2],$pos[3]);
	}
	if ($r[type1]=="membarcodeimage") {
		//($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
      $tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$memberbarcode.JPG";
		//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
		$tmp= Barcode39($memberbarcode, 800, 500, 100, "JPEG", "no" ,$tmpimgbc_file);		
		$pdf->Image($tmpimgbc_file,$pos[0],$pos[1],$pos[2],$pos[3]);
	}
	if ($r[type1]=="repairslip_itembc") {
		//($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
      $tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$bcode.JPG";
		//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
		$tmp= Barcode39($bcode, 800, 500, 100, "JPEG", "no" ,$tmpimgbc_file);		
		$pdf->Image($tmpimgbc_file,$pos[0],$pos[1],$pos[2],$pos[3]);
	}
	if ($r[type1]=="memimage") {
		//($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
      $tmpimg_file=member_pic_spath($memberbarcode);
	  if ($tmpimg_file=="" || !file_exists($tmpimg_file)) {
		$tmpimg_file=$dcrs."pic/no.jpg";
	  }
		//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
		//$tmp= Barcode39($memberbarcode, 800, 500, 100, "JPEG", "no" ,$tmpimgbc_file);	
		//echo $tmpimg_file;
		$pdf->Image($tmpimg_file,$pos[0],$pos[1],$pos[2],$pos[3]);
	}
	if ($r[type1]=="var") {
		$pdf->SetFont('Tahoma','',$r[string_fontsize]);
		$tmpvar=$r[varid];
		if ($compilevar=="yes") {
			$tmpvar=local_compilevar($r[varid]);
		}
		//echo "$r[varid]=[$tmpvar]<br>";
		$pdf->MultiCell($pos[2], floor($r[string_fontsize])+2, iconvth("".$tmpvar),0,"$r[string_align]");
	}
	if ($r[type1]=="box") {
		//$pdf->Cell($pos[2], $pos[3],'s', 10);
		//$pdf->MultiCell($pos[2], 0, " ",1);
		$pdf->Line($pos[0],$pos[1],$pos[0]+$pos[2],$pos[1]);
		$pdf->Line($pos[0],$pos[1],$pos[0],$pos[1]+$pos[3]);

		$pdf->Line($pos[0],$pos[1]+$pos[3],$pos[0]+$pos[2],$pos[1]+$pos[3]);
		$pdf->Line($pos[0]+$pos[2],$pos[1],$pos[0]+$pos[2],$pos[1]+$pos[3]);
		//$pdf->Line($pos[0],$pos[1]+$pos[3],$pos[0],$pos[1]);
	}
	if (floor($pdf->GetY())>$currenty) {$currenty=floor($pdf->GetY());}
}
//footer s
	//$currenty=floor($pdf->GetY());
	//echo "[$currenty/".($pdf->h)."]";
	//$pdf->SetY($pdf->GetY());
	//$pdf->SetX($pdf->GetX());
$s=tmq("select * from printtemplate_sub_i where pid='FOOT::$pid' order by ordr ");
while ($r=tfa($s)) {
	$pos=explode(";",$r[pos]);
	//printr($pos);
	//$pos[0]=$pos[0]*$_MMTOPX;
	//printr($pos);
	//$pos[0]=100;
	$pdf->SetY(floor($pos[1])+$currenty);
	$pdf->SetX(floor($pos[0]));
	//$pdf->SetXY(floor($pos[1]),floor($pos[0]));
	if ($r[type1]=="string") {
		$pdf->SetFont('Tahoma','',$r[string_fontsize]);
		$r[data]=str_replace("[ROOMWORD]",$_ROOMWORD,$r[data]);
		$r[data]=str_replace("[FACULTYWORD]",$_FACULTYWORD,$r[data]);

		$pdf->MultiCell($pos[2],  floor($r[string_fontsize])+2, iconvth($r[data]) ,0,"$r[string_align]");
	}
	if ($r[type1]=="image") {
		//($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
		$pdf->Image($dcrs."_tmp/printtemplate_img/$r[id].jpg",$pos[0],$pos[1],$pos[2],$pos[3]);
	}
	if ($r[type1]=="membarcodeimage") {
		//($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
      $tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$memberbarcode.JPG";
		//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
		$tmp= Barcode39($memberbarcode, 800, 500, 100, "JPEG", "no" ,$tmpimgbc_file);		
		$pdf->Image($tmpimgbc_file,$pos[0],$pos[1],$pos[2],$pos[3]);
	}
	if ($r[type1]=="var") {
		$pdf->SetFont('Tahoma','',$r[string_fontsize]);
		if ($compilevar=="yes") {
			$r[varid]=local_compilevar($r[varid]);
		}
		$pdf->MultiCell($pos[2],  floor($r[string_fontsize])+2, iconvth($r[varid]),0,"$r[string_align]");
	}
	if ($r[type1]=="box") {
		//$pdf->Cell($pos[2], $pos[3],'s', 10);
		//$pdf->MultiCell($pos[2], 0, " ",1);
		$pdf->Line($pos[0],$pos[1],$pos[0]+$pos[2],$pos[1]);
		$pdf->Line($pos[0],$pos[1],$pos[0],$pos[1]+$pos[3]);

		$pdf->Line($pos[0],$pos[1]+$pos[3],$pos[0]+$pos[2],$pos[1]+$pos[3]);
		$pdf->Line($pos[0]+$pos[2],$pos[1],$pos[0]+$pos[2],$pos[1]+$pos[3]);
		//$pdf->Line($pos[0],$pos[1]+$pos[3],$pos[0],$pos[1]);
	}

}

//footer e

} // page e


//$pdf->SetFont('Tahoma','',10);
if ($_POST["autoprint"]=="yes") {
   barcodeval_set("PTP-remember-$useradminid-".$_POST["ptp_wh"]."",$_POST["pid"]);
	$pdf->IncludeJS("print('true'); "); 
	//$pdf->IncludeJS("print('true'); this.closeDoc(true);"); 
} else {
   barcodeval_set("PTP-remember-$useradminid-".$_POST["ptp_wh"]."","");
}

if (trim($PTP_OUTPUTFILE)!="") {
	$pdf->Output($PTP_OUTPUTFILE,'F');
} else {
   //die(".");
	$pdf->Output();
}
?>