<script src="<?php echo $dcrURL;?>webbox/photogrid/masonry.pkgd.min.js"></script>

<base href="<?php  echo $dcrURL;?>"><style>
.tabbg {
	padding-top: 3px;
	border: 0px;
	border-right: 2px solid white;
}
</style><script type="text/javascript">
<!--

	function local_edithtmlbtn_over(wh) {
		tmp=getobj(wh);
		tmp.style.borderWidth="1";
	}
	function local_edithtmlbtn_out(wh) {
		tmp=getobj(wh);
		tmp.style.borderWidth="0";
	}
//-->
</script><?php 
//echo($_SERVER['SCRIPT_FILENAME'])."<br>";
//print_r($_SERVER)."<br>";
//echo __FILE__;
if ( str_replace("\\","/",__FILE__) == str_replace("\\","/",$_SERVER['SCRIPT_FILENAME'])) {
   include("../inc/config.inc.php");
   redir($dcrURL);
   die;
}

include("$dcrs/webbox/config.php");
include("$dcrs/webbox/func-head.php");
$_menuw=floor(barcodeval_get("webboxoptions-menuwidth"));
if ($_menuw<5) {
	$_menuw=130;
}
$_bodyw=1000-$_menuw;

include("topmenu.php");
include("menu.inc.php");
?>
<link rel="stylesheet" href="<?php echo $dcrURL;?>webbox/sugarbar/sugarbar.css.php" />


<script src="<?php echo $dcrURL;?>webbox/sugarbar/sugarbar.js">
/***********************************************
* Sugar Bar- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Please keep this notice intact
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>
<script>

var mysugarbar

jQuery(function(){ // on DOM load
	mysugarbar = new sugarbar({
		sugarbarid: 'ulibtopwebboxmenu',
		externalfile: '<?php echo $dcrURL;?>webbox/topmenu.forexternal.php',
		persistclose: false
	})
})

</script>
<?php
if ($deftabmodule=="Searching") {
	include($dcrs."webbox/tab.Searching.php");
} else {
?><TABLE width=1000 align=center cellpadding=0 cellspacing=0 border=0>
<TR valign=top>
<?php 
if (barcodeval_get("webboxoptions-menupos")=="Left") {
?>
	<TD width="<?php  echo $_menuw;?>" style="background-color: <?php  echo barcodeval_get("webboxoptions-barcolor");?>" class=tabbg rowspan=100><?php 
		include("menu.php");
?></TD>
<?php 
}
?>
	<TD  colspan="<?php  
		if (floor($tablayouts[$deftablayout][colnum])==0) {
			echo 1;
		}	else {
			echo floor($tablayouts[$deftablayout][colnum]);
		}?>"><TABLE width=<?php  echo $_bodyw;?> align=center cellpadding=0 cellspacing=0 border=0>
<?php 
		$s=tmq("select * from webbox_box where tab='$deftab' and col='TOP' order by ordr ");
		if (tmq_num_rows($s)!=0 || loginchk_lib('check')==true) {
		?><TR><TD>
<DIV ID="DragContainerTOP" class="DragContainer" overclass="OverDragContainer" style="width: <?php  echo $_bodyw;?>px; padding-bottom:5">
	<?php 
		$webbox_cur_columnwidth=$_bodyw-$column_space;
		while ($r=tmq_fetch_array($s)) {
			local_webbox($r);
		}
	?>
</DIV></TD>
</TR>
<?php 
		}
?>	<TR valign=top>
<?php 
//echo "[$title]";
//printr($_GET); echo "$viewtopmenulist/$listid]";
$title=trim($title);
$listid=floor($listid);
//echo "[$deftab/$deftabmodule]"; 
if ($webboxloadwikisearch=="yes") {
	?><TD><div style="width: 100%; display:inline-block; border: 0 solid red;"> <?php 
	$_TBWIDTH="100%";
	//echo "[$deftab/$deftabmodule]"; printr($tablayouts);
	include($dcrs."webbox/tab.wiki.search.php");
	?></div></TD><?php 

} elseif ($webboxload=="yes"&&$title!="") {
   //wiki
	?><TD><div style="width: <?php echo $_bodyw;?>; display:block; border: 0 solid red;"> <?php 
	$_TBWIDTH="100%";
	//echo "[$deftab/$deftabmodule]"; printr($tablayouts);
	include($dcrs."webbox/tab.wiki.php");
	?></div></TD><?php 
} else {

	if ($deftabmodule=="Wiki_Home") {
	?><TD><div style="width: 100%; display:block; border: 0 solid red;"> <?php 
	$_TBWIDTH="100%";
	$title="wiki:home";
	include($dcrs."webbox/tab.wiki.php");
	?></div></TD><?php 	}
	if ($deftabmodule=="Webpage") {
		include("tab.Webpage.php");
	}
	if ($deftabmodule=="contentread") {
		?><TD><?php 
		//local_edithtmlbtn("pagehead-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		include("tab.contentread.php");
		//local_edithtmlbtn("pagefoot-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		?></TD><?php 
	}
	if ($deftabmodule=="viewtopmenulist") {
		?><TD><?php 
		//local_edithtmlbtn("pagehead-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		include("tab.topmenulist.php");
		//local_edithtmlbtn("pagefoot-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		?></TD><?php 
	}

	if ($deftabmodule=="Load_URL") {
		?><TD><?php 
		local_edithtmlbtn("pagehead-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		include("tab.Load_URL.php");
		local_edithtmlbtn("pagefoot-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		?></TD><?php 
	}
	if ($deftabmodule=="Member_Login") {
		$_TBWIDTH="100%";
		?><TD><?php 
		local_edithtmlbtn("pagehead-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		include("tab.Member_Login.php");
		local_edithtmlbtn("pagefoot-$deftab","แทรก/แก้ไขเนื้อหา::l::Insert/edit html");
		?></TD><?php 
	}

}

		?>

	</TR>
	</TABLE>
	<?php 
		$s=tmq("select * from webbox_box where tab='$deftab' and col='BOTTOM' order by ordr ",false);
		if (tmq_num_rows($s)!=0 || loginchk_lib('check')==true) {
		?>
<DIV ID="DragContainerBOTTOM" class="DragContainer" overclass="OverDragContainer" style="width: <?php  echo $_bodyw;?>px; padding-bottom:5">
	<?php 
		$webbox_cur_columnwidth=$_bodyw-$column_space;
		while ($r=tmq_fetch_array($s)) {
			local_webbox($r);
		}
	?>
</DIV>
<?php 
		}
	include("$dcrs/webbox/func.php");

?></TD>
<?php 
if (barcodeval_get("webboxoptions-menupos")=="Right") {
?>
	<TD width="<?php  echo $_menuw;?>" style="background-color: <?php  echo barcodeval_get("webboxoptions-barcolor");?>" class=tabbg rowspan=100><?php 
		include("menu.php");
?></TD>
<?php 
}
?>
</TR>
</TABLE>
<?php 
} // end if not deftabmodule=="Searching"

?>