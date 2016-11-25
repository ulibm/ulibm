<?php  //พ
function uploadengine($relativepath,$filetype="image",$nametype="randid",$operaionmode="") {
	global $dcr;
	global $dcrURL;
	$file_types="*.*";
	$file_types_description="All Files";
	?>
<link href="<?php echo $dcrURL?>uploadengine/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $dcrURL?>uploadengine/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $dcrURL?>uploadengine/js/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo $dcrURL?>uploadengine/js/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo $dcrURL?>uploadengine/js/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "<?php echo $dcrURL?>uploadengine/Flash/swfupload.swf",
				upload_url: "<?php echo $dcrURL?>uploadengine/upload.php",
				post_params: {"PHPSESSID" : "<?php  echo session_id(); ?>" , "relativepath" : "<?php  echo $relativepath; ?>","filetype" : "<?php  echo $filetype;?>","nametype" : "<?php  echo $nametype;?>","operaionmode" : "<?php  echo $operaionmode;?>"},
				file_size_limit : "100 MB",
				file_types : "<?php  echo $file_types; ?>",
				file_types_description : "<?php  echo $file_types_description; ?>",
				file_upload_limit : 1000,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "<?php echo $dcrURL?>uploadengine/XPButtonNoText_61x22.png",
				button_width: "65",
				button_height: "22",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">Upload</span>',
				button_text_style: ".theFont { font-size: 12px; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
	</script>
<center><table width="600" align=center style="background-image: url(<?php echo $dcrURL?>uploadengine/bg.png); background-repeat: no-repeat;">
<tr>
	<td style="padding-left: 35px; padding-top: 15px;">
<div id="content">
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">

			
		<div id="divStatus">0 Files Uploaded</div>
			<div><table>
			<tr>
				<td><span id="spanButtonPlaceHolder"></span></td>
				<td><input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 22px; width: 120px;margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;" /></td>
			</tr>
			</table>
				
				
			</div>
<div class="fieldset flash" id="fsUploadProgress">
			<span class="legend">Upload Queue</span>
			</div>
	</form>
</div></td>
</tr>
</table></center><?php 
}
?>