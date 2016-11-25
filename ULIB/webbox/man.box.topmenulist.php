<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
	 $_REQPERM="webbox";
	 mn_lib();
$setnewscate=floor($setnewscate);
if ($setnewscate!=0) {
	tmq("delete from webbox_topmenulist_catemap where pid='$pid' ");
	tmq("insert into webbox_topmenulist_catemap set pid='$pid',cate='$setnewscate',displayformat='$displayformat',showcount='$showcount',readmoretxt='$readmoretxt'  ");
}

$catemap=tmq("select * from webbox_topmenulist_catemap where pid='$pid' ");
$catemap=tfa($catemap);
//printr($catemap);
pagesection(getlang("รายการจากเมนูด้านบน::l::Pull list from topmenu").":".$catedb[$cate]);
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

?><center><form method="post" action="<?php  echo $PHP_SELF?>">
<input type="hidden" name="pid" value="<?php  echo $pid?>">
	<?php  echo getlang("ให้กล่องนี้ดึงข้อมูลจาก::l::Pull news for this box from ");
	//form_quickedit("setnewscate",$cate,"foreign:-localdb-,webbox_newslist_cate,id,name");
	$s=tmq("select * from webbox_topmenu where type='list' ");
	
	?>
	<select name="setnewscate">
		<?php 
		while ($r=tfa($s)) {
			echo "<optgroup label='$r[name]''>";
			$s2=tmq("select * from webbox_topmenu_list where pid='$r[id]' order by ordr ");
			while ($r2=tfa($s2)) {
				$sl="";
				if ($r2[id]==$catemap[cate]) {
					$sl="selected"; 
				}
				echo "<option value='$r2[id]' $sl> ".getlang($r2[name]);
			}
			echo "</optgroup>";
		}	
		?>
	</select>
	<input type="submit" value="Save"> <br>
	<?php 
	echo getlang("รูปแบบการแสดง::l::Display"); 
	form_quickedit("displayformat",$catemap[displayformat],"list:List,Grid,Grid_2_column,2_Columns");
	echo getlang("จำนวนรายการที่แสดง::l::Number of news"); 
	form_quickedit("showcount",$catemap[showcount],"number");
		echo "<br>";
	echo getlang("ข้อความอ่านต่อ ::l::Read more text "); 
	form_quickedit("readmoretxt",$catemap[readmoretxt],"text");
?>
</form></center><?php 





?>