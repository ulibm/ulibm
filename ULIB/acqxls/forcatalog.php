<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="acqxls_forcatalog";
$tmp=mn_lib();
pagesection($tmp);

$tbname="acqn_sub";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="งบประมาณ::l::Amount";
$c[3][field]="amnt";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ยังใช้งาน::l::is active?";
$c[4][field]="isactive";
$c[4][fieldtype]="list:yes,no";
$c[4][descr]="";
$c[4][defval]="yes";

//dsp


//$dsp[1][text]="รหัส::l::Code";
//$dsp[1][field]="code";
//$dsp[1][width]="20%";

$dsp[2][text]="Title";
$dsp[2][field]="titl";
$dsp[2][width]="30%";

$dsp[3][text]="Author";
//$dsp[3][filter]="number";
$dsp[3][field]="auth";
$dsp[3][width]="20%";

$dsp[5][text]="ISN";
//$dsp[5][filter]="number";
$dsp[5][field]="isn";
$dsp[5][width]="20%";

$dsp[4][text]="Catalogue";
$dsp[4][align]="center";
$dsp[4][field]="name";
$dsp[4][filter]="module:localstat";
$dsp[4][width]="20%";
function localstat($wh) {
	global $dcrURL;
	$s= "<a href=\"../library.book/addDBbook.php?loadacqxls=$wh[id]\" target=_blank>Catalogue</a>";
	$chk=tmq("select * from media where acqxlsref='$wh[id]' ");
	if (tnr($chk)==0) {
	} else {
		$chk=tfa($chk);
		$s.=" <a href=\"$dcrURL"."dublin.php?ID=$chk[ID]\" target=_blank class='smaller a_btn'>view</a>";
	}
	return $s;
}


?>
<center><form method="post" action="forcatalog.php">
	<?php  echo getlang("ค้นหาจากรหัสอ้างอิง::l::Search by ref.id"); ?>
<input type="text" name="refid" value="<?php  echo $refid?>" size=6>
<?php  echo getlang("คำสำคัญ::l::Keyword");  ?>
<input type="text" name="kw" value="<?php  echo $kw?>">
<input type="submit" value="Search">
</form></center>
<?php 
$limit=" 1 ";
if ($refid!="") {
	$limit.=" and id='$refid' ";
}
if ($kw!="") {
	$limit.=" and (
	titl  like '%$kw%' or
	auth  like '%$kw%' or
	isn  like '%$kw%' 
	
	)";
}
fixform_tablelister($tbname,"$limit and stat='bookrecieve'  ",$dsp,"no","no","no","mi=$mi",$c,"",$o);

foot(); 
?>