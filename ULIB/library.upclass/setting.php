<?php 
if ($issave=="yes") {
   $from1=floor($from1);
   $to1=floor($to1);
   if ($from1==0 || $to1==0) {
      html_dialog("","Source or destination not set");
   } else if ($from1==$to1) {
      html_dialog("","Same room (source and destination)");
   } else {
      tmq("delete from upclass_rule where from1=$from1");
      tmq("insert into upclass_rule set from1=$from1, to1=$to1");
      html_dialog("Success","Done");

   }
}
?>
                <div align = "center">
<?php 
//pagesection(getlang("ตัวเลือกระบบระบบการให้คะแนน Bib::l::Bib. Rating system options"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<form method=post action="index.php">
<input type=hidden name="issave" value="yes">
<input type=hidden name="mode" value="setting">

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เลื่อนชั้นจาก::l::Move member from");?></td>
  <td width=50% align=center class=table_td>
<select name="from1"><?php 
if ($allownonspec!="no") {
   //echo "<option value=''>-</option>";
}
   $cate=tmq("select * from room_cate order by ordr");
   while ($cater=tfa($cate)) {
		$result=tmq("select * from room where lower(ishide)='no' and pid='$cater[code]' and id not in (select from1 from upclass_rule) order by name",false);
		if (tnr($result)==0) {
		 continue;
		}
		echo "<optgroup label='".getlang($cater[name])."'>";
		while ($row=tfa($result))
			{
			$ID = $row[id];
			$descr=$row[name];
			$sl="";
			if ($fixroom==$row[id]) {$sl="selected";}
			if ($sl!="selected") {
				/*if ($descr == "???????????"||$descr == "???????????????????")
					{
					$s="selected";
					}*/
			}
			$descr=getlang($descr);
         $cstr="";
         $cquery=tmq("select count(UserAdminID) as cc from member where room='$row[id]' ");
         $cqueryr=tfa($cquery);
         if (floor($cqueryr[cc])!=0) {
            $cqueryr=" (".number_format($cqueryr[cc]).")";
         } else {
            $cqueryr="";
         }
			echo "<option value='$ID' $sl>$descr$cqueryr</option>";
		}
		echo "</optgroup>";
	}
	?>
	</select></td>
 </tr>

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เลื่อนไป::l:: to");?></td>
  <td width=50% align=center class=table_td>
<select name="to1"><?php 
if ($allownonspec!="no") {
   //echo "<option value=''>-</option>";
}
   $cate=tmq("select * from room_cate order by ordr");
   while ($cater=tfa($cate)) {
		$result=tmq("select * from room where lower(ishide)='no' and pid='$cater[code]'  order by name",false);
		if (tnr($result)==0) {
		 continue;
		}
		echo "<optgroup label='".getlang($cater[name])."'>";
		while ($row=tfa($result))
			{
			$ID = $row[id];
			$descr=$row[name];
			$sl="";
			if ($fixroom==$row[id]) {$sl="selected";}
			if ($sl!="selected") {
				/*if ($descr == "???????????"||$descr == "???????????????????")
					{
					$s="selected";
					}*/
			}
			$descr=getlang($descr);
         $cstr="";
         $cquery=tmq("select count(UserAdminID) as cc from member where room='$row[id]' ");
         $cqueryr=tfa($cquery);
         if (floor($cqueryr[cc])!=0) {
            $cqueryr=" (".number_format($cqueryr[cc]).")";
         } else {
            $cqueryr="";
         }
			echo "<option value='$ID' $sl>$descr$cqueryr</option>";
		}
		echo "</optgroup>";
	}
	?>
	</select></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table><BR><BR>
<?php 
			

$tbname="upclass_rule";



$dsp[6][text]="เลื่อนชั้นจาก::l::Move member from";
$dsp[6][field]="id";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_from";
$dsp[6][width]="50%";

function local_from($wh) {
	return get_room_name($wh[from1]);
}
function local_to($wh) {
	return get_room_name($wh[to1]);
}

$dsp[2][text]="เลื่อนไป::l:: to";
$dsp[2][field]="id";
$dsp[2][width]="50%";
$dsp[2][filter]="module:local_to";




fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mode=$mode",$c," id desc ");         
         
        $s=tmq("select * from room where id in (select to1 from upclass_rule) and id not in (select from1 from upclass_rule)");
   if (tnr($s)==0) {
      html_dialog("error","<b style='color:darkred;'>Looped setting</b>");
   }    

?>