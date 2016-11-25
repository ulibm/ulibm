<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

if ($mon=="") {
	$mon=date("n");
}
if ($yea=="") {
	$yea=date("Y");
}

if ($minyea=="") {
	$minyea=date("Y")-5;
} 
if ($maxyea=="") {
	$maxyea=date("Y")+5;
}
$now=time();
$setbib=floor($setbib);
if ($setbib!=0 && $week!="") {
	tmq("delete from webpage_weeklybook where yea='$yea' and mon=$mon and week=$week ");
	tmq("insert into webpage_weeklybook set yea='$yea' , mon=$mon , week=$week ,bibid='$setbib' ,loginid='$useradminid',dt='$now' ");
}
if ($deletebib=="yes" && $week!="") {
	tmq("delete from webpage_weeklybook where yea='$yea' and mon=$mon and week=$week ");
}
?><BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<TR>
	<?php 
for ($i=$minyea;$i<=$maxyea;$i++) {
	$c=tmq("select id from webpage_weeklybook where yea='$i' ");
	$c=tmq_num_rows($c);
	$addstr="";
	if ($c!=0) {
		$addstr=" ($c)";
	}
	if ($i==$yea) {
		?><TD align=center width="<?php  echo floor($_TBWIDTH/10);?>"> <B><?php  echo ($i+543).$addstr;?></B> </TD><?php 
	} else {
		?><TD align=center width="<?php  echo floor($_TBWIDTH/10);?>"> <A HREF="index.php?mon=<?php  echo $mon?>&yea=<?php  echo $i?>"><?php  echo ($i+543).$addstr;?></A> </TD><?php 
	}
}
?>
</TR>
</TABLE>

<BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<TR>
	<?php 
for ($i=1;$i<=12;$i++) {
	$c=tmq("select id from webpage_weeklybook where yea='$yea' and mon=$i");
	$c=tmq_num_rows($c);
	$addstr="";
	if ($c!=0) {
		$addstr=" ($c)";
	}
	if ($i==$mon) {
		?><TD align=center width="<?php  echo floor($_TBWIDTH/12);?>"> <B class=smaller2><?php  echo $thaimonstrbrief[$i].$addstr;?></B> </TD><?php 
	} else {
		?><TD align=center width="<?php  echo floor($_TBWIDTH/12);?>" > <A HREF="index.php?mon=<?php  echo $i?>&yea=<?php  echo $yea?>" class=smaller2><?php  echo $thaimonstrbrief[$i].$addstr;?></A> </TD><?php 
	}
}
?>
</TR>
</TABLE>

<BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<TR>
	<?php 
for ($i=1;$i<=4;$i++) {
	?><TD align=center width="<?php  echo floor($_TBWIDTH/4);?>" class=table_head> <?php  echo getlang("สัปดาห์ที่ $i::l::Week $i")?> </TD><?php 
}
?>
</TR>
<TR>
	<?php 
	$ishas=Array();
for ($i=1;$i<=4;$i++) {

	?><TD height=150 align=center width="<?php  echo floor($_TBWIDTH/4);?>"> <?php 
		$c=tmq("select * from webpage_weeklybook where yea='$yea' and mon=$mon and week=$i");
		if (tmq_num_rows($c)!=0) {
			$c=tmq_fetch_array($c);
			echo res_icon($c[bibid]);
			$ishas[$i]="yes";
		}
	
	?></TD><?php 
}
?>
</TR>
<TR>
	<?php 
for ($i=1;$i<=4;$i++) {
	?><TD align=center width="<?php  echo floor($_TBWIDTH/4);?>" class=table_td>
	 <A HREF="<?php  echo $dcrURL?>/_bibpicker.php?goto=<?php  echo urlencode($dcrURL."library.weeklybook/index.php?yea=$yea&mon=$mon&week=$i&setbib=");;?>"  rel="gb_page_fs[]" class='a_btn smaller2'
><?php 
		echo getlang("เลือกทรัพยากร::l::Choose materials")?></A> 
		<?php 
	if ($ishas[$i]=="yes") {
?>
		<A HREF="index.php?<?php  echo "yea=$yea&mon=$mon&week=$i&deletebib=yes";?>" class='a_btn smaller2' style='color: red;'><?php  echo getlang("ลบ::l::Delete");?></A>
		<?php 
}	
?></TD><?php 
}
?>
</TR>

</TABLE>


<?php 


foot();
?>