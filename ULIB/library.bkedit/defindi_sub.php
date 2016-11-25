<?php 
include("../inc/config.inc.php");
head();
	include("_REQPERM.php");
mn_lib();
$tbname="bkedit_indi";
$copyform=trim($copyform);
if (strlen($copyform)==3) {
   $s=tmq("select * from bkedit_indi where tag='tag$copyform' ");
   while ($r=tfa($s)) {
      tmq("insert into bkedit_indi set tag='$tag',
      indiid='$r[indiid]' ,
      indi='$r[indi]' ,
      descr='".addslashes($r[descr])."'
      ");
   }
}
$pastetoindi=floor($pastetoindi);
if ($pastetoindi==1 || $pastetoindi==2) {
   $data=explodenewline($data);
   $data=arr_filter_remnull($data);
   reset($data);
   while (list($k,$v)=each($data)) {
      $v=trim($v);
      $va=explode("-",$v);
      $va[0]=trim($va[0]);
      if ($va[0]=="#") {$va[0]="_";}
      $va[1]=trim($va[1]);
      $va[1]=str_replace("\$","^",$va[1]);
      $va[1]=addslashes($va[1]);
      $sql="insert into bkedit_indi set tag='$tag',
       indiid=$pastetoindi,
       indi='$va[0]',
       descr='$va[1]'
       ";
       echo $sql."<BR>";
       tmq($sql);
   }
}


$c[2][text]="Nested::l::Nested";
$c[2][field]="tag";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$tag;


$c[3][text]="Indicator 1 or 2";
$c[3][field]="indiid";
$c[3][fieldtype]="1or2";
$c[3][descr]="";
$c[3][defval]="";

$c[20][text]="Indicator";
$c[20][field]="indi";
$c[20][fieldtype]="text";
$c[20][descr]="1 charactor";
$c[20][defval]="";



$c[5][text]="ข้อความเพิ่มเติม::l::Description";
$c[5][field]="descr";
$c[5][fieldtype]="longtext";
$c[5][descr]="";
$c[5][defval]="";

//dsp


$dsp[3][text]="Position";
$dsp[3][field]="indiid";
$dsp[3][width]="10%";
$dsp[3][align]="center";

$dsp[4][text]="Indicator";
$dsp[4][field]="indi";
$dsp[4][width]="10%";
$dsp[4][align]="center";

$dsp[5][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[5][field]="descr";
$dsp[5][width]="70%";

$o[addlink][] = "defindi.php::".getlang("กลับ::l::Back");;

function local_name($wh) {
	global $tbname;
	global $cate;
	$img=fft_upload_get($tbname,"logoimg",$wh[id]);
	//printr($img);
	$s="<img src='$img[url]' align=left width=100>";
	$wh[name]=trim($wh[name]);
	if ($wh[name]=="") {
		$wh[name]="<I>- no title -</I>";
	}
	$s.="$wh[name]";
	if ($wh[reportdeadlink]!=0) {
		$s.="<BR><FONT class=smaller COLOR=red>Report Dead Link : $wh[reportdeadlink]</FONT>";
	}
	if ($wh[clickcount]!=0) {
		$s.="<BR><FONT class=smaller COLOR=darkgreen>Click : $wh[clickcount]</FONT>";
	}
	return $s;
}

fixform_tablelister($tbname," tag='$tag' ",$dsp,"yes","yes","yes","tag=$tag",$c," indiid,indi",$o,"","");
?><center>
<form action="<?php echo $PHP_SELF;?>" method=post>
Replace with indi from tag: <input type=text size="5" name=copyform><input type=submit>
<input type=hidden name=tag value="<?php echo $tag; ?>">
</form>
</center><HR>
?><center>
<form action="<?php echo $PHP_SELF;?>" method=post>
paste<BR>
indi 1 or 2: <input type=text size="5" name=pastetoindi value=1><BR>
<textarea name=data cols=50 rows=7></textarea>
<input type=submit>
<input type=hidden name=tag value="<?php echo $tag; ?>">
</form>
</center><?php


  include("reindexindi.php");
foot();
?>