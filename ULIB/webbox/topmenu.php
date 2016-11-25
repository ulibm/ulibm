<!-- topmenu.php s -->
<link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL;?>library.webbox.cascademenu/smoothmenu/ddsmoothmenu.css.php" />
<?php  /*
<!-- <link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL;?>library.webbox.cascademenu/smoothmenu/ddsmoothmenu-v.css" />
 -->
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script> -->
*/

if ($topmenunumber=="") {
   $topmenunumber="1";
}
?>
<script type="text/javascript" src="<?php  echo $dcrURL;?>library.webbox.cascademenu/smoothmenu/jquery.min.js"></script>
<script type="text/javascript" src="<?php  echo $dcrURL;?>library.webbox.cascademenu/smoothmenu/ddsmoothmenu.js.php">

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu<?php echo $topmenunumber;?>", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script><?php 
if (!function_exists("local_topmenugen")) {
function local_topmenugen($parent) {
	//echo "local_topmenugen($parent)";
	$s=tmq("select * from webbox_topmenu where parent='$parent' and lower(isshow)='yes' order by ordr ");
	if ($parent==0) {
		?><ul><?php 
	} 
	while ($r=tfa($s)) {
		$ishaschild=tmq("select * from webbox_topmenu where parent='$r[id]' and lower(isshow)='yes' order by ordr ",false);
		//echo tnr($ishaschild);
		if (tnr($ishaschild)==0) { // nochild
			?><li><a <?php  local_genlink($r);?>><?php  echo str_webpagereplacer(stripslashes(getlang($r[name])));?></a></li>
			<?php 
		} else {  // with child 
			?><li><a <?php  local_genlink($r);?>> <?php  echo str_webpagereplacer(stripslashes(getlang($r[name])));?></a>
					<ul>
						<?php  local_topmenugen($r[id]);?>
					</ul>
			</li><?php 
		}
	}
	if ($parent==0) {
		?></ul><?php 
	} 
}
}
if (!function_exists("local_genlink")) {
function local_genlink($wh) {
	global $dcrURL;
	echo " accesskey='$wh[accesskey]' ";
	if ($wh[type]=="content") {
		echo " href=\"index.php?deftab=contentread&readid=$wh[id]\" ";
	}
	if ($wh[type]=="list") {
		echo " href=\"index.php?viewtopmenulist=yes&listid=$wh[id]\" ";
	}
	if ($wh[type]=="url") {
		$inf=tmq("select * from webbox_topmenu_url  where refid='$wh[id]' ");
		if (tmq_num_rows($inf)==0) {
			echo " href=\"javascript:alert('".getlang("ยังไม่ได้กำหนด URL::l::Not spec. url")."');\"  ";
		} else {
			$addstr=tmq_fetch_array($inf);
			$addstr[url]=str_replace("[dcr]",$dcrURL,$addstr[url]);
			$addstr[url]=str_webpagereplacer($addstr[url]);
			echo " href='".urldecode($addstr[url])."'  target='$addstr[target]' ";
		}
	}
}
}




//topmenu s
$topmenu=tmq("select id from webbox_topmenu where parent='0' ");
if (tnr($topmenu)!=0) {
?><center><div id="smoothmenu<?php echo $topmenunumber;?>" class="ddsmoothmenu" style="display:block; width: <?php echo $_TBWIDTH;?>; background-color: #<?php  echo barcodeval_get("webboxoptions-topmenu_barcolor");?>; "><?php 
local_topmenugen(0);
?><br style="clear: left" />
</div></center>
<?php 
$mn_web_evercalled="yes";
}
//topmenu e
?>
<!-- topmenu.php e -->