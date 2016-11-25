<?php include("../inc/config.inc.php");

if( barcodeval_get("webmobile-options-enable")!="yes") {
	redir("$dcrURL");
	die;
}// พ
$THEME=barcodeval_get("webmobile-options-titlebartheme");
if ($THEME=="") {
	$THEME="a";
}
include("func.php");
//echo "xx".barcodeval_get("webmobile-options-showsearchform");
include("html.start.php");
?>
<?php 
pages("home",str_webpagereplacer(stripslashes(stripslashes( barcodeval_get("webmobile-options-titlebartext") ))));
if ($kw!="") {
		$kw=trim($kw);
		if ($kw!="") {
			include("html.searchform.php");
			include("search.php");
		}	
} else {
	if (barcodeval_get("webmobile-options-showsearchform")=="yes") {
		include("html.searchform.php");
	}
}
if (barcodeval_get("webmobile-options-showloginform")=="yes") {
	include("html.loginform.php");
}
include("menu.php");

/*<ul data-role="listview">
				<!-- <li><a href="#home">Home page</a></li> -->
				<li data-role="list-divider">Welcome</li>
				<li><a href="#eservice">e-Service</a></li>
				<li><a href="#search">Search</a></li>
				<li><a href="#about">About AREC</a></li>
				<li><a href="#loginform">Member Login</a></li>


			</ul>

</div>*/
pagee();
?>
<?php 

//pages for type=content
$ct=tmq("select * from webmobile_menu where type='content' and isshow='yes' ");
while($ctr=tfa($ct)) {
	$contentread=tmq("select * from webmobile_menu_content where refid='$ctr[id]' ");
	$contentread=tmq_fetch_array($contentread);

	pages("content$ctr[id]",str_webpagereplacer(stripslashes(stripslashes(trim($contentread[title])))));
	echo trim(str_webpagereplacer(stripslashes(stripslashes( $contentread[body]))));

	pagee();
}		if ($kw!="") {
	?>
	<script type="text/javascript">
	<!--
		 $.mobile.changePage('#searchform', {transition : "slide"}, false);
	//-->
	</script>
	<?php 
}

pages("searchform","Search");
	include("html.searchform.php");
		$kw=trim($kw);
		if ($kw!="") {
			include("search.php");
		}	
pagee();
pages("memberloginform","Member Login");
	if ($_memid=="") {
		include("html.loginform.php");
	} else {
		include("html.member.php");
	}
pagee();


?>

<?php pages("undercon","Under Construction");
?>
this page is Under Construction
<?php pagee();?>

<?php 
include("html.end.php");
?>