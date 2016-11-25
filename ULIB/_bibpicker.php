<?php 
 include("./inc/config.inc.php");
 html_start();
 loginchk_lib();
 if ($goto=="") {
	die("no goto passed");
}
 $goto2=urldecode($goto);
 $goto2=urldecode($goto2);
 $goto2=urldecode($goto2);
 $now=time();
$tbname="media";
	


//dsp


$dsp[2][text]="Bib Info";
$dsp[2][field]="id";
$dsp[2][width]="70%";
$dsp[2][filter]="module:localdsp";

$dsp[3][text]="Bib Info";
$dsp[3][field]="id";
$dsp[3][align]="center";
$dsp[3][width]="30%";
$dsp[3][filter]="module:localbtn";

function localdsp($wh) {
	//printr($wh);
	return res_brief_dsp($wh[ID],true,true,false);
}
function localbtn($wh) {
	global $goto2;
	return " <A HREF='$goto2$wh[ID]' target=_top>".getlang("เลือกรายการนี้::l::Choose this Bib.")."</A>";
}

?><TABLE cellspacing=0 cellpadding=2 width=100%><FORM METHOD=POST ACTION="_bibpicker.php">
<INPUT TYPE="hidden" NAME="goto" value="<?php  echo $goto;?>">	
			  <TR>
			  	<TD colspan=9 bgcolor=e9e9e9><img 
src="../image/search.gif" width="18" height="15" hspace="4"><?php  echo getlang("ค้นหา::l::Search"); ?></TD>
</TR>
			  <TR>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
			  	<TD><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?><BR>ISBN/ISSN<BR><?php  echo getlang("ผู้แต่ง::l::Author"); ?></TD>
				<TD>
				<input type="text" name="keyword" value="<?php  echo $keyword;?>" size=20  style="border-color:darkred;border-left-width:3"><BR>
 <input type="text" name="isbn" value="<?php  echo $isbn;?>" size=20 style="border-color:darkred;border-left-width:3"><BR>
 <input type="text" name="authorname" value="<?php  echo $authorname;?>" size=20 style=";border-left-width:3">
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
				<TD><?php  echo getlang("บาร์โค้ด::l::Barcode"); ?> <br />
				Bib. ID</TD>
				<TD>
<input type=text name=sbc value="<?php  echo $sbc; ?>" size=10><br />
<input type=text name=sbib value="<?php  echo $sbib; ?>" size=10>
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
<TD><input type="submit" name="Submit" value="<?php  echo getlang("ค้นหา::l::Submit"); ?>">
</TD>
 </TR>
</FORM>
  </TABLE><?php 
$_TBWIDTH="100%";

  $limit =" 1 ";
if ($sbc!="") {
	$s=tmq("select * from media_mid where bcode='$sbc' ");
	if (tmq_num_rows($s)!=0) {
	$s=tmq_fetch_array($s);
	  $limit="$limit  and id=$s[pid]";
	}
}

  if ($keyword <> "") {
		$limit= "$limit  ".ssql_for_raw($keyword,"titl");
		$limit= "$limit  ".ssql_for_raw("[[OR]] ".$keyword,"index01");
  }
  if ($isbn <> "") {
    $limit= "$limit  ".ssql_for_raw($isbn,"isbn");
  }
  if ($authorname <> "") {
    $limit= "$limit  ".ssql_for_raw($authorname,"auth");
  }
  if ($sbib <> "") {
    $limit= "$limit  and ID='$sbib' ";
  }	
 // echo $limit;
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","goto=".urlencode($goto)."&keyword=$keyword&isbn=$isbn&sbc=$sbc&authorname=$authorname",$c," tag245 ");


 ?>