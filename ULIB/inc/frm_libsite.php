<?php // พ
function frm_libsite($NAME,$DEF="") {
	global $LIBSITE;
	if ($DEF=="") {
		$DEF=$LIBSITE;
	}
?>
        <select name = "<?php  echo $NAME;?>">
            <?php 
                $sql82="select * from library_site order by name";
                $result=tmq($sql82);
                //echo $sql;
                echo "<option  value=''>-</option>";
                while ($row=tmq_fetch_array($result))
                    {
                    $selornot = "";
                    $DbID=$row[code];
                    if ("$DbID" == $DEF)
                        {
                        $selornot="selected";
                        }
                    $DbDesc=getlang($row[name]);
                    echo "<option value='$DbID' $selornot>$DbID - 
$DbDesc</option>";
                    }
            ?>
        </select>
<?php 
}
?>