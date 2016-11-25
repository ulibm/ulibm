<?php 
	// พ
function pages($id,$name) {
	global $dcrURL;
	global $THEME;
	/*
<div data-role="header" data-theme="a">
	<h1>a</h1>
</div>
<div data-role="header" data-theme="b">
	<h1>b</h1>
</div>
<div data-role="header" data-theme="c">
	<h1>c</h1>
</div>
<div data-role="header" data-theme="d">
	<h1>d</h1>
</div>
<div data-role="header" data-theme="e">
	<h1>e</h1>
</div>
<div data-role="header" data-theme="f">
	<h1>f</h1>
</div>
*/
	?>
<div data-role="page" id="<?php  echo $id;?>"  style="height: 600px;">
<div data-role="header" data-theme="<?php  echo $THEME;?>">
	<a href="index.php" data-icon="home" data-ajax="false" >Home</a>
	<h1><?php  echo $name;?></h1>
</div>
<div data-role="content">  
<?php 
}

function pagee() {
	global $dcrURL;
	global $THEME;
	?></div>
<div data-role="footer" cdlass="ui-bar" data-theme="<?php  echo $THEME;?>">
<?php 
	echo (str_webpagereplacer(stripslashes(stripslashes( barcodeval_get("webmobile-options-footertext")))));
	
?>
	<a href="<?php  echo $dcrURL;?>?forcenomobile=yes" data-icon="arrow-r" data-ajax="false">Desktop Version</a> 
</div>

<!-- /footer -->

</div><!-- endpage --><?php 
}

function localmore($u,$t="") {
	if ($t=="") {
		$t="_blank";
	}
	$more="<a href='".$u."' target='$t' style='font-size: 14px;'>read more </a>";

	echo $more;
}
?>