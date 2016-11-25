<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
	 $_REQPERM="webbox";
	 mn_lib();
$setnewscate=trim($setnewscate);
if ($setnewscate!="") {
	tmq("delete from webbox_biblist_catemap where pid='$pid' ");
	tmq("insert into webbox_biblist_catemap set pid='$pid',cate='$setnewscate',displayformat='$displayformat',showcount='$showcount',readmoretxt='$readmoretxt' ",false);
}

//printr($catemap);

$cateinfo=tmq("select * from webbox_biblist_catemap where pid='$pid' ",false);
$cateinfo=tfa($cateinfo);
$additionalfilter=$cateinfo[cate];
//printr($cateinfo);
pagesection(getlang("รายการบรรณานุกรม::l::Bibliography List"));
?>
                <div align = "center">
<?php 
if ($issave=="yes") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
	die;
}
//
include($dcrs."webbox/man.box.biblist.inc.php");

?><center><form method="post" action="man.box.biblist.php">
<input type="hidden" name="pid" value="<?php  echo $pid?>">
	<?php  echo getlang("รายการบรรณานุกรม ::l::Bibliography Type ");
	//form_quickedit("setnewscate",$cate,"foreign:-localdb-,webbox_customlist_cate,id,name");
	
	@reset($afilter);
	?><select name="setnewscate" ID="setnewscate"  >
		<?php 
		while (list($k,$v)=each($afilter)) {
			$afl="";
			if ($k==$additionalfilter) {
				$afl="selected";
			}
			?><option value="<?php  echo $k;?>" <?php  echo $afl;?>><?php  echo getlang($v[name]);?><?php 
		}
		?>
	</select>
	
	
	<input type="submit" value="Save"><br>
	<?php 
	echo getlang("รูปแบบการแสดง::l::Display"); 
	form_quickedit("displayformat",$cateinfo[displayformat],"list:List,1_Row,2_Columns,Sliding_Cover");
	echo getlang("จำนวนรายการที่แสดง ::l::Number of news "); 
	form_quickedit("showcount",$cateinfo[showcount],"number");
	echo "<br>";
	echo getlang("ข้อความอ่านต่อ ::l::Read more text "); 
	form_quickedit("readmoretxt",$cateinfo[readmoretxt],"text");
	?>
</form></center><?php 




?>