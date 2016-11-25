<?php 
    ;
	include ("../inc/config.inc.php");
	//printr($_POST);
if ($issave=="yes") {
	html_start();
	$dat=floor($dat);
	$mon=floor($mon);
	$yea=floor($yea);
	$edat=floor($edat);
	$emon=floor($emon);
	$eyea=floor($eyea);
	$now=time();
	if (!checkdate ($mon,$dat,$yea)) {
		echo getlang("วันที่ไม่ถูกต้อง::l::Date is incorrect"); die;
	}
	tmq("insert into setreturndtfromto set loginid='$useradminid' ,
		note='".addslashes($note)."',
		dt='$now',
		dat='$dat',
	mon='$mon',
	yea='$yea',
			edat='$edat',
	emon='$emon',
	eyea='$eyea'
		
	
	",false);
	$newid=tmq_insert_id();
	$s=tmq("select * from checkout where returned='no' and edat='$edat' and emon='$emon' and eyea='$eyea' ",false);
	$newdt=ymd_mkdt($dat,$mon,$yea-543);
	while ($r=tfa($s)) {
		$olddt=ymd_mkdt($r[edat],$r[emon],$r[eyea]-543);
		echo "$olddt/$newdt<br>";
		if ($olddt!=$newdt) {
			tmq("insert into setreturndtfromto_sub set pid='$newid',
			member='$r[hold]',
   		origid='$r[id]',

			bcode='$r[mediaId]',
			dat='$r[edat]',mon='$r[emon]',yea='$r[eyea]'

			",false);
			tmq("update checkout set edat='$dat', emon='$mon',eyea='$yea' where id='$r[id]' ",false);
		}
	}
/*
	tmq("update member set 
	dat='$dat',
	mon='$mon',
	yea='$yea'
	where room='$ID'
	");*/
	redir("index.php");
	die;
}
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);
?><BR><BR>

<CENTER>
<B><?php  echo getlang("กำหนดวันคืนทรัพยากรทั้งหมดที่ถูกยืมออกจากห้องสมุด (เฉพาะรายการที่มีกำหนดส่งในวันที่กำหนด)<br>กรุณาตรวจสอบให้แน่ใจก่อนทำการตั้งค่า เพราะการตั้งค่าไม่สามารถยกเลิกได้::l::Force set due date for checked out materials (only items on specificed due date)<br>Please re-check this operation, this operation cannot be undone."); ?>
</B><BR><BR><?php  echo getlang("กรุณาระบุวันที่::l::Please specific new due date"); ?> <HR width=770><BR>
<FORM METHOD=POST ACTION="index.php">
<INPUT TYPE="hidden" name='issave' value='yes'>
<TABLE width=770 align=center>

                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("บันทึก::l::Note"); ?><br> </font></td>
                                            <td width = "73%"><input type="text" name="note" placeholder="Put Note or remarks here" size=50>
											</td></tr>
											  <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("รายการที่มีกำหนดคืนวันที่::l::From due date"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2">
                                                <select name = edat  ID="eexpdat">
                                                    <option value = "">กรุณาเลือก<?php 
                                                        for ($i=1; $i <= 31; $i++)
                                                            {
                                                            print "<option value='$i'>$i";
                                                            }
                                                    ?></select>
                                                <select name = emon ID="eexpmon">
                                                    <option value = "">กรุณาเลือก<?php 
                                                        for ($i=1; $i <= 12; $i++)
                                                            {
                                                            print "<option value='$i'>";
                                                            echo $thaimonstr[$i];
                                                            }
                                                    ?></select>
                                                <select name = eyea ID="eexpyea">
                                                    <option value = "">กรุณาเลือก<?php 
                                                        for ($i=$_MSTARTY; $i <= $_MENDY; $i++)
                                                            {
                                                            print "<option value='$i'>$i";
                                                            }
                                                    ?></select> 
                                                    </td></tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("กำหนดคืนทรัพยากร::l::New due date"); ?><br> </font></td>
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
                                                    ?></select> <?php  //echo getlang("ไม่ใส่หมายถึงไม่กำหนด::l::left all balnk if not specific"); ?><br>
													
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
</TABLE>
</FORM>
<BR><BR><BR>
</CENTER>
<?php 
	pagesection("ประวัติการกำหนด::l::History");



$tbname="setreturndtfromto";



//dsp


$dsp[1][text]="เจ้าหน้าที่ห้องสมุด::l::Librarian";
$dsp[1][filter]="module:local_libid";
$dsp[1][field]="type";
$dsp[1][width]="20%";
function local_libid($wh) {
	return get_library_name($wh[loginid]);
}

$dsp[3][text]="Note";
$dsp[3][field]="note";
$dsp[3][width]="20%";

$dsp[2][text]="วันเวลา::l::Datetime";
$dsp[2][field]="dt";
$dsp[2][filter]="datetime";
$dsp[2][width]="20%";


$dsp[5][text]="รายละเอียด::l::Detail";
$dsp[5][field]="maxfine";
$dsp[5][filter]="module:local_det";
$dsp[5][width]="20%";
function local_det($wh) {
	$s="";
	$s.=getlang("ตั้งกำหนดส่งเป็นวันที่::l::Set due date to")." ".$wh[dat]."/".$wh[mon]."/".$wh[yea]."<br>";
	$cc=tmq("select * from setreturndtfromto_sub where pid='$wh[id]' ");
	$num=tnr($cc);
	$s.="<a href='sub.php?ID=$wh[id]'>".getlang("มีผลกระทบ $num รายการ::l::Affected $num rows")."</a>";

	return $s;
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"id desc",$o);

	foot();
?>