
<TD <?php 
	if (loginchk_lib("chk")) {
		echo " style=\"border: 1px dashed black;\" ";
	}	
	?>>
<?php 
	local_edithtmlbtn("pagehead-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");

?>
<TABLE cellpadding=0 cellspacing=0 border=0 width=<?php  echo $_bodyw;?>>

<TR valign=top>
<?php 


$column_space=floor(barcodeval_get("webboxoptions-columnspace"));

for ($tabi=1;$tabi<=floor($tablayouts[$deftablayout][colnum]);$tabi++) {
	$usewidth=$tablayouts[$deftablayout][colwidth][$tabi]-$boxspace;
	//printr($tablayouts[$deftablayout]);
	$webbox_cur_columnwidth=$tablayouts[$deftablayout][colwidth][$tabi]-$column_space;
	//echo $usewidth;
	?><TD width="<?php  echo $tablayouts[$deftablayout][colwidth][$tabi]?>"><?php 

	?><DIV ID="DragContainer<?php echo $tabi?>" class="DragContainer" overclass="OverDragContainer" style="width:<?php  echo $tablayouts[$deftablayout][colwidth][$tabi]-$column_space?>; <?php 
	if (loginchk_lib("chk")) {
		echo " border: 1px dashed black;";
	}	
	?>">

	<?php 
		$s=tmq("select * from webbox_box where tab='$deftab' and col='$tabi' order by ordr ",false);
		$i=0;
		while ($r=tmq_fetch_array($s)) {
			$i++;
			local_webbox($r);
		}
	?>
</DIV></TD><?php 
}
?>
</TR>
</TD></TR>


</TABLE>
<?php 
	local_edithtmlbtn("pagefoot-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
?>
</TD>