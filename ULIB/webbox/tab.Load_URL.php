<?php 
	$url=local_getwebboxtabdata($deftab,"loadurl");
	if (loginchk_lib('check')==true) {
		if ($issaveloadurl=="yes") {
			local_setwebboxtabdata($deftab,"loadurl",$saveloadurl);
			$url=local_getwebboxtabdata($deftab,"loadurl");
		}
		?><div class=adminbox2><FORM METHOD=POST ACTION="index.php">
			<?php  echo getlang("แก้ URL ของเพจนี้::l::Edit URL to load");?><BR>
		<INPUT TYPE="hidden" NAME="issaveloadurl" value="yes">
		<INPUT TYPE="hidden" NAME="deftab" value="<?php  echo $deftab?>">
		<INPUT TYPE="text" NAME="saveloadurl" value="<?php  echo $url?>" style="width:500"> <INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save")?>">
		</FORM> </div><?php 
	}
	if ($url!="") {
	?><iframe src="<?php  echo $url;?>" 
		width=870 height=900 FRAMEBORDER="NO" BORDER=0
 id="iframe_local" onload="resizeIframe2('iframe_local');" SCROLLING=AUTO></iframe>
 <?php 
	}
	?>
 <script language="javascript"> 
function resizeIframe2(id) { 
	try { 
		frame = getobj(id); 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight + 2 +addheight; 
		 if (tmpfrheight>10000) {
			 tmpfrheight=10000;
		 }
		 if (tmpfrheight<minwidth) {
			 tmpfrheight=minwidth;
		 }
		 objToResize.height = tmpfrheight;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script>