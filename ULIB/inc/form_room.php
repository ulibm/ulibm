<?php  //พ
function form_room($formname="room",$fixroom="",$allownonspec="no") {
?>
<select name="<?php  echo $formname;?>"><?php 
if ($allownonspec!="no") {
   echo "<option value=''>-</option>";
}
   $cate=tmq("select * from room_cate order by ordr");
   while ($cater=tfa($cate)) {
		$result=tmq("select * from room where lower(ishide)='no' and pid='$cater[code]' order by name",false);
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
	</select><?php 
}
?>