<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="updateitemstatus";
$tmp=mn_lib();
pagesection($tmp);
html_dialog("",getlang("เลือกสถานะใหม่ของไอเทมที่ต้องการและสแกนบาร์โค้ดทรัพยากร::l::Select status and scan item's barcode"));
?>
<form method=post action="<?php  echo $PHP_SELF?>">
<table width=700 align=center>
<tr><td width=180><?php  echo getlang("สถานะ::l::Status");?></td><td><?php 
frm_genlist("status","select * from media_mid_status order by code","code","name","-localdb-","yes",$status);
?></td></tr>
<tr><td width=180><?php  echo getlang("บาร์โค้ด::l::Barcode");?></td><td><input type=text name=sbc ID=sbc value=""></td></tr>
<tr><td colspan=2 align=center><input type=submit value="Submit"></td></tr>
</table>
</form>
<script>
tmp=getobj("sbc");
tmp.focus();
</script>
<?php 

$sbc=trim($sbc);
if ($sbc!="") {
   $mid=tmq("select * from media_mid where bcode='$sbc' ");
   if (tnr($mid)==0) {
      html_dialog("Error",getlang("ไม่พบบาร์โค้ด [$sbc]::l::barcode [$sbc] not found"));
   } else {
   $media=tfa($mid);
   $media=$media[pid];
   ?><table width=500 align=center>
<tr><td width=180><?php  res_brief_dsp($media);?></td></tr>
</table>
<?php 
      
      tmq("update media_mid set status='$status' where bcode='$sbc' limit 1 ");
      
	$now=time();
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$media',
		edittype='update item bc=$sbc set status=[$status]'		");
		
      if ($status=="") {$status="ok";}
      html_dialog("Success",getlang("บาร์โค้ด [$sbc] อัพเดทสถานะแล้ว [$status]::l::barcode [$sbc] updated [$status]"));
  }

}
foot(); 
?>