<center>
<div style="background-color: #c7c7c7; xwidth: 620px;
margin-top: 10px;
     -moz-border-radius: 20px;
    -webkit-border-radius: 20px;
    -khtml-border-radius: 20px;
    border-radius: 20px; max-width: 500px;
"><form data-ajax="false" method=post action="index.php#searchform">
	<table width=100% bgcolor=white>
<tr>
	<td  align=center><b>Search</b></td></tr>
	<tr>
	<td>
<?php // พ
	$s=tmq("select * from index_ctrl where searchable='yes' order by ordr");
?>
<input type="text" name="kw" value="<?php  echo $kw;?>">
 <select name="idx">
 <?php 
	while ($r=tfa($s)) {
		$sl="";
		if ($r[fid]=="$idx") {
			$sl=" selected";
		}
		echo "<option $sl value='$r[fid]'>".getlang($r[name]);
	}
 ?>
	
 </select>
 <input type="submit" value=Search>
	
	<!-- &nbsp;&nbsp;<a style="font-size: 12px;color: #105265; margin-bottom:10;padding-right:5;display: block;" href="javascript:webopac();">Check Personal Info</a> -->
</td>
</tr>
</table>
</form>
</div><br>
</center>