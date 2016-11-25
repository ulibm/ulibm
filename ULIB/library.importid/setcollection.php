<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
	if ($savec=="yes") {
      $addcollist=",".@implode(",",$collist).",";
      echo "[$collist=$addcollist]";
      tmq("update media set collist='$addcollist' where importid='$importid' ");
      tmq("update index_db set collist='$addcollist' where importid='$importid' ");
      redir("index.php");
      die;
	}
?>
<table align=center width=<?php  echo $_TBWIDTH;?>><tr><td>

<FORM METHOD=POST ACTION="setcollection.php">

<HR width=780>
<?php 

$s=tmq("select * from collections order by name");
$i=0;
$all=tmq_num_rows($s);
while ($r=tmq_fetch_array($s)) {
	$i++;
?><label><?php 
	echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=24 height=24 align=absbottom>";

?><INPUT TYPE="checkbox" NAME="collist[<?php echo $r[id]?>]" value="<?php echo $r[classid]?>" style="border-width: 0;">
	<B style='font-size: 14px; ' ><?php  echo getlang($r[name])?></B>  </label> &nbsp; 
<?php 
	if ($i<$all) {
		echo "<B>:</B> &nbsp;&nbsp;";
	}
}	?>

<BR><BR>
	<INPUT TYPE="hidden" name="importid" value="<?php  echo $importid?>">
	<INPUT TYPE="hidden" name="savec" value="yes">

<INPUT TYPE=submit value="<?php  echo getlang("บันทึก::l::Save"); ?>" style='background-color: #EDE0E0'>
</CENTER><HR width=780>

</FORM></td></tr></table>

<?php 
foot();
?>