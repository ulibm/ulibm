<?php // พ
function editperm_form($mid) { 
	global $dcrURL;
	$mid=urlencode($mid);
	$ifid_local=randid();
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
	function editpermIFRAMEcontrol() {
		id="if<?php  echo $ifid_local;?>";
		try { 
			frame = getobj(id); 
			frame.scrolling = "no"; 
			frame.scrolling = "no"; 
			innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
			objToResize = (frame.style) ? frame.style : frame; 
			 tmpfrheight = innerDoc.body.scrollHeight ; 
			 if (tmpfrheight>1600) {
				 tmpfrheight=1600;
			 }

			objToResize.height = tmpfrheight;
		} catch (e) { 
			window.status = e.message; 
		} 
	}
	//-->
	</SCRIPT><iframe width=100% height=200 src="<?php  echo $dcrURL?>/_editperm.php?mid=<?php echo $mid?>" ID="if<?php  echo $ifid_local;?>" name="if<?php  echo $ifid_local;?>"></iframe><?php 
}
?>