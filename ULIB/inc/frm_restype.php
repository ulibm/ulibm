<?php 
    function frm_restype($NAME, $DEF="",$ALLOPTION="YES",$jsid="") {
	if ($jsid=="") {
		$jsid="autoid".randid();
	}
?>        <select name = "<?php  echo $NAME;?>" ID="<?php  echo $jsid?>">
            <?php 
                $sql82="select * from media_type order by code";
                $result=tmq($sql82);
                //echo $sql;
				if ($ALLOPTION=="YES") {
					echo "<option value=''>".getlang("ไม่กำหนดประเภทวัสดุ::l::not define item type")."</option>";
				}
                while ($row=tmq_fetch_array($result)) {
                    $selornot = "";
                    $DbID=$row[code];
                    if ("$DbID" == $DEF) {
                        $selornot="selected";
                    }
                    $DbDesc=mb_substr(getlang($row[name]),0,45);
                    echo "<option value='$DbID' $selornot>$DbID - $DbDesc</option>";
                }
            ?>
        </select>
<?php 
        }
?>