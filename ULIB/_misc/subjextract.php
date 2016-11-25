<?php 
include("../inc/config.inc.php");
html_start();

if ($laststr!="") {
	$kw=$laststr;
}
?><TABLE cellpadding=0 width=0 cellspacing=0 class=table_border>
<FORM METHOD=POST ACTION="subjextract.php">
	<TR>
	<TD class=table_th><?php  echo getlang("ค้นหาหัวเรื่อง::l::Search Subject");?></TD>
	<TD class=table_td><INPUT size=50 TYPE="text" NAME="kw" value="<?php  echo $kw;?>"> 
	<INPUT TYPE="hidden" NAME="tagid" value="<?php  echo $tagid;?>">
	<INPUT TYPE="hidden" NAME="parentjsid" value="<?php  echo $parentjsid;?>">
	<INPUT TYPE="submit" value=" Search "></TD>
</TR>
</FORM>
</TABLE>
<?php 

$tbname="index_subjextract";


$c[2][text]="Subject::l::Subject";
$c[2][field]="word1";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="off";

//dsp
?><script language="javascript" type="text/javascript">
function copyText(theSel) {
if (!document.all) return; // IE only
theSel.select();
window.clipboardData.setData('Text',theSel.value);
}
</script> 
<script>
function addthis(wh) {
	//alert(parent);
	//alert(wh);
 <?php 
 $chk=tmq("select * from bkedit where fid='$tagid' ");
 $chk=tmq_fetch_array($chk);
$defindi1=substr($chk[defindi1],0,1);
$defindi2=substr($chk[defindi2],0,1);
if ($defindi1=='' || $defindi1=='b') {
	$defindi1='_';
}
if ($defindi2=='' || $defindi2=='b') {
	$defindi2='_';
}
 if ($chk[isrepeat]!="R") {
 		?>
		  parent.getobj('result_<?php  echo $tagid?>').innerHTML='';
		 	newid=parent.duplicatemarc("<?php  echo $tagid ?>","<?php echo $defindi1;?>","<?php echo $defindi2;?>",wh,"no");
			//alert(newid);
			//alert(wh);
			parent.setlastfocus("data"+newid);
			parent.showhidesuggestme_justhide();
			<?php 
 } else {
 ?> 
     parent.duplicatemarc("<?php  echo $tagid ?>","<?php echo $defindi1;?>","<?php echo $defindi2;?>",""+wh+"","yes");
	 <?php 
 }
 ?>

}
</script>
<?php 


function copier($wh) {
//printr($wh);
	global $parentjsid;
	//echo $wh[word1];
	$wh[word1]=(substr($wh[word1],2,strlen($wh[word1])));
	//echo $wh[word1];
	if ($parentjsid=="") {
		$s= "<form >
			<INPUT TYPE=text NAME='' value='$wh[word1]' style='cursor: hand; cursor: pointer;; width: 100%' 
		noonclick=\"copyText(this)\" onclick=\"this.select()\">
		</form>";
	} else {
		$dsp=dspmarc($wh[word1]);
		//$dsp=str_remspecialsign($dsp);      			
		$s="<a href='javascript:void(0)' onclick=\"addthis('".addslashes($wh[word1])."');\" class=smaller>$dsp</a>";
	}
	return $s;
}

$dsp[2][text]="Word::l::Word";
$dsp[2][field]="word1";
$dsp[2][width]="100%";
$dsp[2][filter]="module:copier";



if ($kw=="") {
	$limit=" 1 ";
} else {
	//$limit=" (word1 like '%$kw%' or usoundex like '%".usoundex_get($kw)."%' )";
	$limit=" (word1 like '%$kw%' )";
}

$o[tablewidth]="100%";

fixform_tablelister($tbname," $limit  ",$dsp,"no","no","no","kw=$kw&tagid=$tagid&parentjsid=$parentjsid",$c," word1",$o);
?>