<?php  //พ
function pagesection($txt,$mode="normal",$col="#555555") {
	global $dcrURL;
	global $_ROOMWORD;
	global $_FACULTYWORD;
	$txt=str_replace('[ROOMWORD]',$_ROOMWORD,$txt);
	$txt=str_replace('[FACULTYWORD]',$_FACULTYWORD,$txt);

	//echo "[$mode]";
	global $_TBWIDTH;
	if ($mode=="") {
		$mode="normal";
	}
	if ($mode=="normal") {
?><TABLE width=700 height=65 align=center cellspacing=10 background="<?php  echo $dcrURL?>/neoimg/pagesection.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD align=left style="padding-left: 120px" valign=middle><h1 SIZE="" COLOR=""  style="font-size: 22px; font-weight: bolder; color: <?php  echo $col;?>; padding-top: 10px; padding-bottom: 0px"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}
	if ($mode=="login") {
?><TABLE width=700 height=65 align=center cellspacing=10 background="<?php  echo $dcrURL?>/neoimg/pagesection-login.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD nostyle="padding-right: 60px" valign=middle align=center><h1 SIZE="" COLOR=""  style="font-size: 30px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}

	if ($mode=="stats") {
?><TABLE width=700 height=65 align=center cellspacing=10 background="<?php  echo $dcrURL?>/neoimg/pagesection-stats.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD nostyle="padding-right: 60px" valign=middle align=center><h1 SIZE="" COLOR=""  style="font-size: 30px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}

	if ($mode=="fulltext") {
?><TABLE width=700 height=65 align=center cellspacing=10 background="<?php  echo $dcrURL?>/neoimg/pagesection-fulltext.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD nostyle="padding-right: 60px" valign=middle align=center><h1 SIZE="" COLOR=""  style="font-size: 30px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}
	if ($mode=="article") {
?><TABLE width=90% height=65 align=center cellspacing=10 background="<?php  echo $dcrURL?>/neoimg/pagesection-fulltext.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD style="padding-right: 20px" valign=middle align=right><h1 SIZE="" COLOR=""  style="font-size: 30px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}
	if ($mode=="bookcomment") {
?><TABLE width="<?php  echo $_TBWIDTH?>" height=65 align=center cellspacing=10 background="<?php  echo $dcrURL?>/neoimg/pagesection-fulltext.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD style="padding-left: 150px" valign=middle align=left><h1 SIZE="" COLOR=""  style="font-size: 30px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}
	if ($mode=="articlelist") {
?><TABLE border=0 width=100% height=35 align=center cellspacing=3 background="<?php  echo $dcrURL?>/neoimg/pagesection-fulltext.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD style="padding-left: 120px" valign=middle align=left><h1 SIZE="" COLOR=""  style="font-size: 20px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}
	if ($mode=="narrow") {
		$col="white";
?><TABLE width=780 height=20 align=center cellspacing=2 background="<?php  echo $dcrURL?>/neoimg/pagesection-narrow.jpg" bgcolor=#334277 style="background-repeat: no-repeat;">
<TR>
	<TD  valign=middle align=center style="padding-top: 0px;"><h1 SIZE="" COLOR=""  style="font-size: 16px; font-weight: bolder; color: <?php  echo $col;?>; margin: 3px"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}
	
	if ($mode=="usissearchsection") {
		$col="black";
?><TABLE width=780 height=32 align=center cellspacing=2 background="<?php  echo $dcrURL?>/neoimg/pagesection-usis.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD  valign=middle align=left style="padding-left: 100"><h1 SIZE="" COLOR=""  style="font-size: 20px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}	
	if ($mode=="requestroom") {
		$col="#246C26";
?><TABLE width=780 height=43 align=center cellspacing=3 background="<?php  echo $dcrURL?>/neoimg/pagesection-requestroom.jpg" style="background-repeat: no-repeat;">
<TR>
	<TD style="padding-left: 90px" valign=middle align=left><h1 SIZE="" COLOR=""  style="font-size: 22px; font-weight: bolder; color: <?php  echo $col;?>"><?php echo getlang($txt);?></h1></TD>
</TR>
</TABLE><?php 
	}



}
?>