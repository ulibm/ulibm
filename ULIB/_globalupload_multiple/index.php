<?php 
set_time_limit(0);
     include("../inc/config.inc.php");
	 html_start();

if ($key=="TEMP") {
	$key="tempolary-for-$useradminid";
}

 $ismanager=loginchk_lib("check");

 $addtotextarea=trim($addtotextarea);
 $key=trim($key);

if ($key=="") {
	die("globalupload.php need key ($key)");
}

$_iswiki=substr($key,0,5);
if ($_iswiki=="wiki-") {
	$_iswiki="yes";
}

$_VAL_FILE_SAVEPATHurl="$dcrURL/_globalupload/$key/";
$_VAL_FILE_SAVEPATH="$dcrs/_globalupload/$key/";
if ( $ismanager!=true) {
	die("you cannot use global upload");
}
$uploaddir =$_VAL_FILE_SAVEPATH;
@mkdir("$uploaddir", 0777);

?>
<link href="../css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="swfupload.js"></script>
<script type="text/javascript" src="js/swfupload.queue.js"></script>
<script type="text/javascript" src="js/fileprogress.js"></script>
<script type="text/javascript" src="js/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "Flash/swfupload.swf",
				upload_url: "upload.php",
				post_params: {"PHPSESSID" : "<?php  echo session_id(); ?>" , "key" : "<?php  echo $key; ?>","addtotextarea" : "<?php  echo $addtotextarea; ?>"},
				file_size_limit : "100 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 1000,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "XPButtonNoText_61x22.png",
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
</head>
<body>

<div id="content">
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">

			
		<div id="divStatus">0 Files Uploaded</div>
			<div><table>
			<tr>
				<td><span id="spanButtonPlaceHolder"></span></td>
				<td><input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 22px; width: 120px;margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;" /></td>
				<td><a href="../globalupload.php?key=<?php  echo $key?>&addtotextarea=<?php  echo $addtotextarea?>"><?php  echo getlang("กลับ::l::Back");?></a></td>
			</tr>
			</table>
				
				
			</div>
<div class="fieldset flash" id="fsUploadProgress">
			<span class="legend">Upload Queue</span>
			</div>
	</form>
</div>