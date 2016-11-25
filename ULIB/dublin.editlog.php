<?php 
    ;

    // ตรวจสอบว่าเป็น Root Admin หรือไม่
    //   include("config.inc.php");
    //  include("head.php");
include("inc/config.inc.php");
head();

mn_web("dspbib");

pagesection("Editing Log.");
?>
  <TABLE width="780" border="0" cellspacing="1" cellpadding="3" align=center>
<TR>
	<TD><?php 
  res_brief_dsp($ID);	
	?></TD>
</TR>
</TABLE>
<?php 

     	?><BR>
<table bgcolor=white width=<?php echo $_TBWIDTH;?> border=0 align=center cellpadding=1
cellspacing=0 >
<tr><td><a href='dublin.php?ID=<?php  echo $ID;?>'><B>Back</B></a> <?php
	if (floor($ID)!=0) {
		viewdiffman("bib","$ID");
	}
	?>
</td>
                    <td width=50><a href="javascript:window.close();"><nobr><IMG SRC="neoimg/closewin.jpg" WIDTH="26" HEIGHT="26" BORDER="0" ALT="" align=absmiddle>  <B> Close
</B></td>
</tr></table>
 <?php 

$dsp[2][text]="Librarian";
$dsp[2][field]="login";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_lib";


$dsp[3][text]="Date";
$dsp[3][field]="dt";
$dsp[3][width]="30%";
$dsp[3][filter]="datetime";


$dsp[4][text]="Action";
$dsp[4][field]="edittype";
$dsp[4][width]="30%";
$dsp[4][filter]="module:local_edittype";


function local_lib($wh) {
	$s=html_library_name($wh[login]);;
	return $s;
}

function local_edittype($wh) {
	$s=ucwords($wh[edittype]);;
	return $s;
}


$tbname="media_edittrace";
fixform_tablelister($tbname," bibid='$ID' ",$dsp,"no","no","yes","ID=$ID",$c);
?><center><?php
$s=tmq("select * from media where ID='$ID' ");
$s=tfa($s);
if (floor($s[acqxlsref])!=0) {
   echo "<a href='$dcrURL"."acqxls/viewsub.php?id=$s[acqxlsref]' target=_blank>".getlang("เลขที่ระบบจัดหา::l::Acquisition No.")." $s[acqxlsref]</a>";
}

foot();
?>