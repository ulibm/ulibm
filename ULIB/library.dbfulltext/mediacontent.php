<?php 
include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();
$now=time();
if ($deleteid!="") {
	$s=tmq("select * from media_ftitems  where id ='$deleteid' ");
	$s=tmq_fetch_array($s);
	$uploaddir ="$dcrs/_fulltext/$s[fttype]/$s[mid]/";
	
	@unlink($uploaddir.$s[filename]);
	@unlink($uploaddir."thumb.$s[filename]");
	@unlink($uploaddir."$s[filename].thumb.jpg");
	
	//echo($uploaddir.$s[filename]);
	//echo($uploaddir."thumb.$s[filename]");
	tmq(" delete from media_ftitems where id='$deleteid' ");
		 	tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$mid',
		edittype='Delete File ID=$deleteid [$FTCODE]'		");
}
if ($fftmode=="delete") {
	 	tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$mid',
		edittype='Delete URL ID=$fftdeleteid [$FTCODE]'		");
		//printr($ffdat);
}
if ($ffe_issave=="yes") {
	 	tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$mid',
		edittype='fulltext URL ".addslashes($ffdat[text])." url=".addslashes($ffdat[filename])."  [$FTCODE]'		");
		//printr($ffdat);
}

$tbname="media_ftitems";
?><br /><?php 
if ($addmode=="url") {
?>
<table border="0" cellpadding="0" cellspacing="0"width=780 align=center>
<form action="mediacontent.php">
<input type="hidden" name="FTCODE" value="<?php  echo $FTCODE;?>" />
<input type="hidden" name="mid" value="<?php  echo $mid;?>" />
<input type="hidden" name="addmode" value="url_save" />
<tr>
  <td class=table_head>URL</td>
  <td class=table_td><input type="text" name="url" /></td>
</tr>
<tr>
  <td class=table_head><?php  echo getlang("ข้อความ::l::Text");?></td>
  <td class=table_td><input type="text" name="text" /></td>
</tr>

<tr>
  <td class=table_td colspan=2 align=center><button type="submit" value=" Save "></button></td>
</tr>
</form>
</table>
<?php 
}

	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	$sname=getlang($s[name]);
?>


<table border="0" cellpadding="0" cellspacing="0" width=780 align=center>
<tr valign=top><td class=table_head width=200><b style='font-size: 22'><?php  echo getlang("เพิ่มเนื้อหาให้::l::Adding content to");?></b></td>
<td  class=table_td><?php  echo marc_gettitle($mid);?></td></tr>
<tr><td class=table_head>Call number</td>
<td  class=table_td><?php  echo marc_getcalln($mid);?></td></tr>
<!-- <tr>
  <td class=table_head><?php  echo getlang("จัดการ Content ประเภท::l::Managing content type");?></td>
  <td class=table_td><SELECT NAME="jumpftcate"  style="font-size: 24" onchange="self.location='mediacontent.php?FTCODE='+this.value+'&mid=<?php  echo $mid?>'">
	<?php 
	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	echo "<OPTION VALUE='$s[code]' SELECTED>".getlang($s[name])."</OPTION>";
		$sall1=tmq("select * from media_fttype where code<>'$FTCODE' order by name ");
	while ($sall1r=tmq_fetch_array($sall1)) {
		echo "<OPTION VALUE='$sall1r[code]' >".getlang($sall1r[name]);
	}

	?>
		
		
	</SELECT></td>
</tr> -->
<tr>
  <td align=center class=table_td colspan="1"><?php  echo " <a href='$dcrURL/dublin.php?ID=$mid' target=_blank class=a_btn>".getlang("ดูรายละเอียด::l::View")."</a>" ?></td>
	<td align=center ><b style='font-size: 18;color: #808080'><?php 
//	$o[addlink][] = "browse.php?FTCODE=$FTCODE::".getlang("กลับไปรายการ Content '$s'::l::Back to Content '$s'")."::_self";
	 echo getlang("อัพโหลดไฟล์เสร็จแล้วคลิก <a href='browse.php?FTCODE=$FTCODE'>กลับไปรายการ Content '$sname'</a>::l::When finish click <a href='browse.php?FTCODE=$FTCODE'>Back to Content '$sname'</a> ");?></b></td>
</tr>
</table>
<?php 


$c[2][text]="Mid::l::Mid";
$c[2][field]="mid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$mid;

if ($setdef_url=="") {$setdef_url="http://";}
$c[3][text]="URL";
$c[3][field]="filename";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]=$setdef_url;

if ($fftmode=="edit") {
	 $chk=tmq("select * from $tbname where id='$ffteditid' ");
	 $chk=tmq_fetch_array($chk);
	 if ($chk[uploadtype]=="upload") {
	 		$c[3][fieldtype]="readonlytext";
	 }
}

$c[4][text]="Fttype::l::Fttype";
$c[4][field]="fttype";
//$c[4][fieldtype]="addcontrol";
$c[4][fieldtype]="foreign:-localdb-,media_fttype,code,name";
$c[4][descr]="";
$c[4][defval]=$FTCODE;

$c[5][text]="Text::l::Text";
$c[5][field]="text";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]=$setdef_name;

$c[6][text]="Uploadtype::l::Uploadtype";
$c[6][field]="uploadtype";
$c[6][fieldtype]="addcontrol";
$c[6][descr]="";
$c[6][defval]="url";


//dsp



$dsp[3][text]="Filename/URL";
$dsp[3][field]="filename";
$dsp[3][filter]="module:locallinkoutbtn";
$dsp[3][width]="30%";

$dsp[4][text]="Contenttype";
$dsp[4][field]="fttype";
$dsp[4][filter]="foreign:-localdb-,media_fttype,code,name";
$dsp[4][width]="15%";



$dsp[5][text]="Text::l::Text";
$dsp[5][field]="text";
$dsp[5][width]="30%";

$dsp[6][text]="<font color=red>ลบ</font>/filter::l::<font color=red>Del</font>/filter";
$dsp[6][field]="id";
$dsp[6][align]="center";
$dsp[6][filter]="module:localdelbtn";
$dsp[6][width]="15%";


	
$o[addlink][] = "mediacontent.upload.php?FTCODE=$FTCODE&mid=$mid::".getlang("อัพโหลดไฟล์::l::Upload Contents")." (Flash)::_self";
$o[addlink][] = "mediabasic.php?FTCODE=$FTCODE&mid=$mid::".getlang("อัพโหลดไฟล์::l::Upload Contents")." (normal)::_self";
$o[addlink][] = "./ulibcamcap/index.php?FTCODE=$FTCODE&mid=$mid::".getlang("ภาพปกจากกล้อง::l::Cover by camera")." ::_self";
$o[addlink][] = "picker.pre.php?FTCODE=$FTCODE&mid=$mid::".getlang("ไฟล์บนเซิร์ฟเวอร์::l::Files on server")."::_self";

//$o[addlink][] = "mediacontent.php?FTCODE=$FTCODE&mid=$mid&addmode=url::".getlang("เพิ่ม URL::l::Add URLs")."::_self";


$o[undelete][field]="uploadtype";
$o[undelete][value]="upload";
//$o[unedit][field]="uploadtype";
//$o[unedit][value]="upload";

$tmpsourcefttype="";
function locallinkoutbtn($wh) {
	global $dcrURL;
	global $tmpsourcefttype;
	$tmpsourcefttype=$wh[fttype];
	//printr($wh);
	if (strlen($wh[filename])>20) {
		$add='..';
	}
	 return "<a href=\"$dcrURL/_fulltext/$wh[fttype]/$wh[mid]/$wh[filename]\" target=_blank>".substr($wh[filename],0,20)."$add</a>";
}

function localdelbtn($wh) {
    global $FTCODE;
    global $tmpsourcefttype;
    global $mid;
    global $cfrm;
				if ($wh[uploadtype]=="upload") {
				 		return "<a href='./mediacontent.php?deleteid=$wh[id]&FTCODE=$FTCODE&mid=$mid' onclick=\"return confirm('$cfrm')\">".getlang("ลบ::l::Del")."</a>
				 		".html_photofilter("_fulltext/$tmpsourcefttype/$wh[mid]/$wh[filename]","",false);
				} else {
							  return "-";
				}
}

fixform_tablelister($tbname," mid='$mid' ",$dsp,"yes","yes","yes","FTCODE=$FTCODE&mid=$mid",$c,"",$o);

index_indexft($mid,true,true);
?>
<br />
<table width=780 align=center>
<tr><td align=left><?php 
html_label("b",$mid);
?></td></tr>
</table>
<?php 
//index_reindex($mid);
foot();
?>