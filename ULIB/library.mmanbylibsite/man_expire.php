<?php 
    ;
	include ("../inc/config.inc.php");
if ($issave=="yes") {
	tmq("update member set 
	dat='$dat',
	mon='$mon',
	yea='$yea'
	where LIBSITE='$slibsite'
	");
	redir("media_type.php");
	die;
}
	head();
	include("_REQPERM.php");
	mn_lib();
?><BR><BR>

<CENTER>
<B><?php  echo getlang("กรุณาตรวจสอบให้แน่ใจก่อนทำการตั้งค่า เพราะการตั้งค่าไม่สามารถยกเลิกได้::l::Please re-check this operation, this operation cannot be undone."); ?>
</B><BR><BR><?php  echo getlang("กรุณาระบุวันที่::l::Please specific new expire date"); ?> <HR width=770><BR>
<TABLE width=770 align=center>
<FORM METHOD=POST ACTION="man_expire.php">
<INPUT TYPE="hidden" name='slibsite' value='<?php  echo $ID?>'>
<INPUT TYPE="hidden" name='issave' value='yes'>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("วันหมดอายุ::l::Expire date"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2">
                                                <select name = dat  ID="expdat">
                                                    <option value = "">กรุณาเลือก<?php 
                                                        for ($i=1; $i <= 31; $i++)
                                                            {
                                                            print "<option value='$i'>$i";
                                                            }
                                                    ?></select>
                                                <select name = mon ID="expmon">
                                                    <option value = "">กรุณาเลือก<?php 
                                                        for ($i=1; $i <= 12; $i++)
                                                            {
                                                            print "<option value='$i'>";
                                                            echo $thaimonstr[$i];
                                                            }
                                                    ?></select>
                                                <select name = yea ID="expyea">
                                                    <option value = "">กรุณาเลือก<?php 
                                                        for ($i=$_MSTARTY; $i <= $_MENDY; $i++)
                                                            {
                                                            print "<option value='$i'>$i";
                                                            }
                                                    ?></select> * <?php  echo getlang("ไม่ใส่หมายถึงไม่กำหนด::l::left all balnk if not specific"); ?><br>
													
		<font class=smaller2><?php  echo getlang("หรือเลือกจากรายการ::l::or choose from template");?></font>
		<?php 
			$setp=tmq("select * from member_expireset order by dt");
			?><select name="tmp_member_expireset" class=smaller  
			onchange="member_expiresetfunc(this);">
			<?php 
			echo "<option selected value=''>-";
			while ($setpr=tfa($setp)) {
				echo "<option value='".date("Y/m/d",$setpr[dt])."'>".stripslashes($setpr[name]);;
			}
		?>
		</select>

	<script type="text/javascript">
	<!--
		function member_expiresetfunc(wh) {
			//alert(wh.value);
			ymd=wh.value;
			ymd=ymd.split("/");
			//alert(ymd);
			var curr_date = Math.floor(ymd[2]);
			var curr_month = Math.floor(ymd[1]);
			var curr_year =Math.floor(ymd[0])+543;
			//alert(curr_year);
			tmp=getobj('expdat');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_date) {
					tmp.options[i].selected=true
				}
			}
			tmp=getobj('expmon');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_month) {
					tmp.options[i].selected=true
				}
			}
			tmp=getobj('expyea');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_year) {
					tmp.options[i].selected=true
				}
			}
		}
	//-->
	</script>
</TD>
</TR>
<TR>
	<TD align=center colspan=2><INPUT TYPE="submit" value="  Update "></TD>
</TR>

</FORM></TABLE>
<BR><BR><BR>
</CENTER>
<?php 
	foot();
?>