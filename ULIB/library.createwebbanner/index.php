<?php 
	; 
        include ("../inc/config.inc.php");
        include ("_REQPERM.php");

		head();
        $tmp=mn_lib();
?>
                <div align = "center">
<?php 
pagesection($tmp);
?>
<form method=post action="print.php" target=_blank>
<input type=hidden name="issave" value="yes">
<table border = 0 cellpadding = 0 width = 100 align = center cellspacing=0>

 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("เลือกภาพพื้นหลัง ::l::Choose Background");?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head colspan=2> <table width=100%>
	<tr>
		<?php  
		for ($i=1;$i<=10;$i++) {
			?><td width=90 align=center><a href="upload.php?mediatypemanage=<?php  echo $i;?>"><img src="<?php  echo $dcrURL;?>_tmp/createwebbanner/<?php  echo $i;?>.jpg.thumb.jpg?rand=<?php  echo $randid;?>" width=90 border=0
			style="max-height: 120px;"></a><br>
			<input type="radio" name="choosebg" value="<?php  echo $i;?>" <?php 
			if (barcodeval_get("createwebbanner-choosebg")==$i){
				echo " checked selected ";
			}	
			?>>
			</td><?php 
		}
	?>
	</tr>
	</table></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td width=200>Size</td>
  <td  align=center class=table_td >Width <input type="text" name="imgw" value="<?php  echo barcodeval_get("createwebbanner-imgw")?>"> 
  Height <input type="text" name="imgh" value="<?php  echo barcodeval_get("createwebbanner-imgh")?>"></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td width=200><?php  echo getlang("ฟอนท์ที่ต้องการ::l::Font"); ?></td>
  <td  align=center class=table_td ><?php 
  $font=barcodeval_get("createwebbanner-font");
	form_quickedit("font",$font,"list:Tahoma,Browalia,Angsana,THSarabunNew");
  ?></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td width=200>Top Text</td>
  <td  align=center class=table_td ><textarea name="toptext" rows="" cols="" style="width:400px; height: 100px;"><?php  echo barcodeval_get("createwebbanner-toptext")?></textarea><br>
  Font-size: <input type="text" name="toptextsize" value="<?php  echo barcodeval_get("createwebbanner-toptextsize")?>" size=5><br>
  Color: <?php 
  $toptextcolor=barcodeval_get("createwebbanner-toptextcolor");
	form_quickedit("toptextcolor",$toptextcolor,"color");  
  ?>
  Background Color: <?php 
  $toptextbg=barcodeval_get("createwebbanner-toptextbg");
	form_quickedit("toptextbg",$toptextbg,"color");  
  ?>
  </td>
 </tr>
  <tr valign = "middle">
  <td  align=center class=table_td width=200>Middle Text</td>
  <td  align=center class=table_td ><textarea name="middletext" rows="" cols="" style="width:400px; height: 100px;"><?php  echo barcodeval_get("createwebbanner-middletext")?></textarea><br>
  Font-size: <input type="text" name="middletextsize" value="<?php  echo barcodeval_get("createwebbanner-middletextsize")?>" size=5><br>
  Color: <?php 
  $middletextcolor=barcodeval_get("createwebbanner-middletextcolor");
	form_quickedit("middletextcolor",$middletextcolor,"color");  
  ?>
  Background Color: <?php 
  $middletextbg=barcodeval_get("createwebbanner-middletextbg");
	form_quickedit("middletextbg",$middletextbg,"color");  
  ?>
  </td>
 </tr>



  <tr valign = "top">
  <td  align=center class=table_td colspan=2></td>
 </tr>




	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> </td>
</tr>
</table></form>
<?php 
				foot();
?>