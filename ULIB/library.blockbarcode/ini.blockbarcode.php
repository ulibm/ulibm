<?php // พ
class PDF extends FPDF
{

var $col=0;

function SetCol($col) {
global  $colnum;

    //Move position to a column
    $this->col=$col;
    $x=0+$col*ceil($this->wPt)/$colnum;
    $this->SetLeftMargin($x);
    $this->SetX($x);
	$this->SetY(1);
}

function AcceptPageBreak()
{
global  $colnum;

    if($this->col<($colnum-1))
    {
		//$this->Text(0,0,trim("$colnum"));

        //Go to next column
        $this->SetCol($this->col+1);
       // $this->SetY(10);
        return false;
    }
    else
    {
        //Go back to first column and issue page break
        $this->SetCol(0);
        return true;
    }
}

}

?>