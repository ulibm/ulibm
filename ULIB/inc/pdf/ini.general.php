<?php  //พ
class PDF extends FPDF
{
//Page header
function Header()
{
	global $dcrs;
    //Logo
    $this->Image("$dcrs/_tmp/paper/_paper_head.jpg",0,0,590);
    //Arial bold 15
    $this->SetFont('Tahoma','',15);
    //Move to the right
	/*
    $this->Cell(80);
    //Title
    $this->Cell(30,10,'Title',1,0,'C');
    //Line break
	*/
    $this->Ln(20);
}

//Page footer
function Footer()
{
		global $dcrs;

    //Position at 1.5 cm from bottom
		//$this->SetY(1000);
	    $this->Image("$dcrs/_tmp/paper/_paper_foot.jpg",10,810,590);

	/*
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	*/
}
}


?>