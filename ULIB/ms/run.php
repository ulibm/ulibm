<?php  //พ
	include ("../inc/config.inc.php");

	html_start("no");
	if ($use=="") {
		die("please select room to run");
	}
	sessionval_set("msrunningsub",$use);
	$hasannouce=tmq("select * from ms_annouce2 where loc='$use' ");
?>
<Frameset rows='*,45<?php 
if (tnr($hasannouce)!=0) { echo ",95";} ?>' frameborder=1 framespacing="0">
<frame src="body.php?gateid=<?php  echo $gateid?>" name=dspframe>
<frame src="form.php?fieldcode=<?php  echo $code?>&use=<?php  echo $use?>&gateid=<?php  echo $gateid?>" >
<?php 
if (tnr($hasannouce)!=0) { echo '<frame src="annouce.php">';} ?>

</frameset>
<?php 
html_end();
?>