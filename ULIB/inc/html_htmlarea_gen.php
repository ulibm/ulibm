<?php // พ
function html_htmlarea_gen($a) {
	global $html_htmlarea_genwiki;
	global $html_htmlarea_width;
	global $html_htmlarea_genadmin;
	global $dcrURL;
	
	$html_htmlarea_width=floor($html_htmlarea_width);
	if ($html_htmlarea_width==0) {
		$html_htmlarea_width=760;
	}
//////////////////////////////////////////////////////////////
	if ($html_htmlarea_genwiki=="yes") {
		$toolbaruse= 'wikimode' ;
	} else {
		if ($html_htmlarea_genadmin!='no')	{
			$toolbaruse= 'Full' ;
		} else {
			$toolbaruse= 'Basic' ;
		}
	}

		?>
				<script type="text/javascript"> 
				//<![CDATA[
 
					// This call can be placed at any point after the
					// <textarea>, or inside a <head><script> in a
					// window.onload event handler.
 
					// Replace the <textarea id="editor"> with an CKEditor
					// instance, using default configurations.
					CKEDITOR.replace( '<?php  echo $a;?>',
						{
							height : '400px',
							width : '<?php  echo $html_htmlarea_width;?>px',
							enterMode : 2,
							toolbar : '<?php  echo $toolbaruse?>',
							shiftEnterMode : 2,
							language : '<?php  echo getlang("th::l::en");?>',
							
						});
 
				//]]>
				</script> 		
		<?php 
}
?>