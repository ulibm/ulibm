<?php 
if ($_REQUEST['uploadDir']) {
	$uploadDir = $_REQUEST['uploadDir'];
	$uploadFile = $uploadDir . $_FILES['Filedata']['name'];
	move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadFile);
}
// พ
if ($_REQUEST['action'] == 'getMaxFilesize') {
	echo "&maxFilesize=".ini_get('upload_max_filesize');
}
?>