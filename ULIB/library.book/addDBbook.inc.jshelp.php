<?php // พ
function local_bookjshelp($wh,$ddd) {
	global $html_libmann_count;
	global $useradminid;
	global $_TBWIDTH;
	if (strtolower(barcodeval_get("personalsetting-o-hidelibmann-$useradminid")=="yes")) {
		return;
	}
	$html_libmann_count=floor($html_libmann_count)+1;
	global $dcrURL;


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
		loadJS<?php  echo $html_libmann_count;?>('<?php  echo $dcrURL?>library.book/addDBbook.inc.jshelp.loader.php?code=<?php  echo $wh?>&addid=<?php  echo $html_libmann_count;?>', function() { 
			// put your code here to run after script is loaded
			libmannstartIntro<?php  echo $html_libmann_count;?>()
		});
	}
	
	</script>
	<?php
	//printr($ddd);
	$localvalidtag=explodenewline(strip_tags(str_replace("Subfields Info","",$ddd[subfieldinfocache])));
	$localvalidtagvstr="";
	//printr($localvalidtag);
	while (list($localvalidtagk,$localvalidtagv)=each($localvalidtag)) {
	  //echo "[$localvalidtagv]<BR>";
	  $localvalidtagv=trim($localvalidtagv);
	  //echo substr($localvalidtagv,0,2);
	  if (substr($localvalidtagv,0,1)=="^" ||substr($localvalidtagv,0,1)=="|" ||substr($localvalidtagv,0,1)=="\$") {
	     $localvalidtagvstr=$localvalidtagvstr.",".strtolower(substr($localvalidtagv,1,1));
	  }
	}
	?>
	<script>
   if (typeof getlocalvalidtagv=="undefined") {
      var getlocalvalidtagv=new Array;
   }
   getlocalvalidtagv[<?php echo floor(trim($wh," tag"));?>]= "<?php echo trim($localvalidtagvstr,",");?>";

	</script>
		<?php 

}
?>