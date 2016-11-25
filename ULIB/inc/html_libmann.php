<?php // พ
function html_libmann($wh,$includebar="no") {
	global $html_libmann_count;
	global $useradminid;
	global $_TBWIDTH;
	if (strtolower(barcodeval_get("personalsetting-o-hidelibmann-$useradminid")=="yes")) {
		return;
	}
	$html_libmann_count=floor($html_libmann_count)+1;
	global $dcrURL;
	$libmann=tmq("select id from libmann where nested='FREECATE-$wh' ",false);
	if (tnr($libmann)!=0) {
		if ($includebar!="no") {
			?><table border=0 cellpadding=0 cellspacing=0 align=center width=<?php  echo $_TBWIDTH?>>
			<tr>
				<td><?php 
		}
		?><a href="javascript:void(null);" onclick="libmannloader<?php  echo $html_libmann_count;?>();"><img src="<?php echo $dcrURL;?>neoimg/help-icon.png" width="16" height="16" border="0" alt="" align=absmiddle></a>
		<script>
	function loadJS<?php  echo $html_libmann_count;?>(src, callback) {
		var s = document.createElement('script');
		s.src = src;
		s.async = true;
		s.onreadystatechange = s.onload = function() {
			var state = s.readyState;
			if (!callback.done && (!state || /loaded|complete/.test(state))) {
				callback.done = true;
				callback();
			}
		};
		document.getElementsByTagName('head')[0].appendChild(s);
	}
	function libmannloader<?php  echo $html_libmann_count;?>() {
		loadJS<?php  echo $html_libmann_count;?>('<?php  echo $dcrURL?>js/intro/loader.php?code=FREECATE-<?php  echo $wh?>&addid=<?php  echo $html_libmann_count;?>', function() { 
			// put your code here to run after script is loaded
			libmannstartIntro<?php  echo $html_libmann_count;?>()
		});
	}
	</script>
		<?php 
		if ($includebar!="no") {
			?></td>
			</tr>
			</table><?php 
		}

	}
}
?>