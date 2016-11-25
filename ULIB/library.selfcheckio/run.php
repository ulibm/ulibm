<?php 
include("../inc/config.inc.php");
html_start();
include("./inc.php");
?>
<style>
body {
	
	<?php 
		$img=fft_upload_get("selfcheckio","pageimgbg",$s[id]);
		 if($img[status]=="ok") {
			echo "background-image:url(".$img[url].")!important;; background-position:center; 
			";
		 } else {
			//echo "background-image:url(defbanner.png);";		
			?>background-color:<?php local_gethtml("pagebgcol");?>;
			<?php 
		 }
		?>
}
</style>
<?php 
$pass=false;
$iprange=trim($s[allowips]);
$iprangea=explodenewline($iprange);
@reset($iprangea);
while (list($k,$v)=each($iprangea)) {
	if (ip_in_range($IPADDR,$v)==true) {
		$pass=true;
		break;
	}
}

if ($pass==false) {
	html_dialog("Permission Denied","client's IP not in range : $IPADDR: $iprange");
	die;
}

?>
	<SCRIPT LANGUAGE="JavaScript" src="js.php"></SCRIPT>
    <div id="wrapper">
        <div id="headerwrap">
        <div id="header" style="display: block; text-align: center; align-vertical: middle; font-size: 36px;<?php 
		$img=fft_upload_get("selfcheckio","bannerfile",$s[id]);
		 if($img[status]=="ok") {
			echo "background-image:url(".$img[url].");";
		 } else {
			echo "background-image:url(defbanner.png);";		 
		 }
		?>;background-position:center; ">
            <div ID="headerdtext">&nbsp;&nbsp;</div>
        </div>
        </div>
        <div id="contentliquid"><div id="contentwrap">
        <div id="content">
           <iframe name=mainif ID=mainif style="width: calc(100%); height: calc(100% - 0px); border: 0px solid black;" src="./galleria/index.php?code=<?php  echo $s[id]?>"></iframe>
        </div>
        </div></div>
        <div id="rightcolumnwrap">
        <div id="rightcolumn"  style="display: block; text-align: center; <?php 
		$img=fft_upload_get("selfcheckio","menubg",$s[id]);
		 if($img[status]=="ok") {
			echo "background-image:url(".$img[url].");";
		 } else {
			echo "background-image:url(defbanner.png);";		 
		 }
		?>;background-position:center; ">
           <!-- menu -->
		   <div id="menu_main">
			<?php 
		   if (strtolower($s[io_out])=="yes") {
			?><a href="javascript:void(null);" class="iomainbtn" onclick="b_out()"><?php  echo getlang("ยืม::l::Check out");?></a><?php 
		   }
		   if (strtolower($s[io_in])=="yes") {
			?><a href="javascript:void(null);" class="iomainbtn" onclick="b_in()"><?php  echo getlang("คืน::l::Check in");?></a><?php 
		   }
		   ?>
		   </div>
		   <div id="menu_maincancel" style="display:none;">
			 <a href="javascript:void(null);" class="iomainbtncancel" onclick="b_cancel()"><?php  echo getlang("ยกเลิก::l::Cancel");?></a>
		   </div>
		   <div id="menu_finish" style="display:none;">
			 <a href="javascript:void(null);" class="iomainbtn" onclick="b_finish()"><?php  echo getlang("เสร็จสิ้น::l::Done");?></a>
		   </div>
		   <?php 
		   if (strtolower($s[io_allowkeym])=="yes") {
				$inputstyle="";
		   } else {
				$inputstyle="-webkit-opacity: 0.0;
	-moz-opacity: 0.0;
	filter:alpha(opacity=0);";
		   }
		   ?>
		   <form method="post" action="" onsubmit="local_handleform(); return false;">
			<input type="text" name="input1" ID="input1" style="<?php  echo $inputstyle;?>"> <input type="submit" style="<?php  echo $inputstyle;?>"> 
		   </form>
		   <script type="text/javascript">
		   <!--
		   local_focusme();
		   var base_code=<?php  echo $id;?>;
		   var cur_member="";
		   //-->
		   </script>
		   <?php local_gethtml("main_belowmainbtn");  ?>
		   <iframe src="" style="display:none;" ID='localhiddenif'></iframe>
		   </div>
        </div>
    </div>
</body>
</html>
