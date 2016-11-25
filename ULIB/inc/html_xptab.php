<?php  //พ
    function html_xptab($str,$setwidth="") {
		//frm= defaultindex::color::text,url::text,url
		//default=yes/no
		//color=b g o pu r
		global $dcrURL;
		global $_TBWIDTH;
		if ($setwidth=="") {
			$setwidth=$_TBWIDTH;
		}
		$str=explode("::",$str);
		list($k,$vdefault)=each($str);
		list($k,$vcolor)=each($str);

?><TABLE  border = "0" cellspacing = "0" cellpadding =0 width="<?php  echo $setwidth;?>" align=center>
<TR>
<?php 
	$count=0;
	while (list($k,$v)=each($str)) {
		$count++;
		$i=explode(',',$v);
		//printr($i);
		if ($i[3]=="") {
		//	$i[3]="_top";
		}
		?>

	<TD background="<?php echo $dcrURL?>neoimg/mediatab/menu<?php  echo $vcolor?>_bg.gif" >
	<?php  if ($count==$vdefault) {?>
	<img src='<?php echo $dcrURL?>neoimg/mediatab/menu<?php  echo $vcolor?>_hover_left.gif'>
	<?php } else {	?>
	<img src='<?php echo $dcrURL?>neoimg/mediatab/menu<?php  echo $vcolor?>_bg.gif'>
	<?php }?>
	</TD>
	<TD 
	<?php  if ($count==$vdefault) {?>
	background='<?php echo $dcrURL?>neoimg/mediatab/menu<?php  echo $vcolor?>_hover_right.gif' 
	<?php } else {?>
	background="<?php echo $dcrURL?>neoimg/mediatab/menu<?php  echo $vcolor?>_bg.gif"
	<?php }?>
	style="background-position: top right; padding-right: 10px;padding-left: 4px;">
<nobr>
<a  href="<?php echo $i[1]; ?>" target="<?php  echo $i[3]?>" 
	<?php  if ($count==$vdefault) {?>
	style="color:white;font-size:14px;font-weight:bold"
	<?php } else {?>
	style="color:black;font-size:14px;font-weight:bold"
	<?php }?>>
<?php  echo getlang($i[0]); ?></a>&nbsp;&nbsp; </nobr></TD>	
<?php 
	}
?>
<TD background="<?php echo $dcrURL?>neoimg/mediatab/menu<?php  echo $vcolor?>_bg.gif" width=100%>&nbsp;</TD>
</TR>
</TABLE>
<?php 
        }
?>