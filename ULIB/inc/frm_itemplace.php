<?php 
function frm_itemplace($inputname,$defplace="",$optionall="",$placetype="book",$JSID="",$customsql="") {
	global $LIBSITE;
?>
<SELECT NAME="<?php 
echo $inputname;	
?>" ID="<?php echo $JSID;?>">
<?php 
if ($optionall=="yes") {
	echo "<option value=''>".getlang("แสดงทั้งหมด::l::Show all")."</option>";
}

$sm=tmq("select * from library_site where 1 $customsql order by name");
while ($rm=tmq_fetch_array($sm)) {
 echo "<optgroup label='".getlang($rm[name])."'>";
$s=tmq("select * from media_place where main='$rm[code]' order by name");

while ($r=tmq_fetch_array($s)) {
	$sl="";
	if ($defplace!="null") {
		if ($defplace!="") {
			if ("$r[code]"=="$defplace") {
				$sl="selected";
			}
		} else {
			if ($r[main]==$LIBSITE) {
				if ($r[isdef]=="YES" && $placetype=="book") {
					$sl="selected";
				}
				if ($r[isdefserial]=="YES" && $placetype=="serial") {
					$sl="selected";
				}
			}
		}
	}
	echo "<option value='$r[code]' $sl>".getlang($r[name]);
	if ($r[collcode]!="") {
		echo " [$r[collcode]]";
	}

	echo " ($r[code]) </option>";
}

///
 echo "</optgroup>";
}
?>
</SELECT>
<?php 
}?>